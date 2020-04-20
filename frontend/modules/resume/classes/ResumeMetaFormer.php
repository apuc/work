<?php

namespace frontend\modules\resume\classes;

use common\models\Category;
use common\models\City;
use common\models\Experience;
use common\models\KeyValue;
use common\models\Professions;
use common\models\Resume;
use Yii;
use yii\helpers\StringHelper;
use yii\web\View;

class ResumeMetaFormer
{

    /**
     * @param View $view
     * @param City $city
     * @param Category $category
     * @param Professions $profession
     */
    public static function registerResumeSearchPageTags($view, $city, $category, $profession)
    {
        $description = null;
        $title = null;
        $meta_data = null;
        if ($city && $category){
            $meta_data = $category->metaData;
        }
        elseif($city && $profession){
            $meta_data = $profession->metaData;
        }
        if ($meta_data){
            $title = str_replace('{city}', $city->name, $meta_data->resume_meta_title_with_city);
            $title = str_replace('{region}', $city->region->name, $title);
            $title = str_replace('{city_prep}', $city->prepositional, $title);
            $description = str_replace('{city}', $city->name, $meta_data->resume_meta_description_with_city);
            $description = str_replace('{region}', $city->region->name, $description);
            $description = str_replace('{city_prep}', $city->prepositional, $description);
        }
        if ($city && (!$title || !$description)){
            $title = $title ?: $city->meta_title;
            $description = $description ?: $city->meta_description;
        }
        if ($category && (!$title || !$description)){
            $title = $title ?: $category->metaData->resume_meta_title;
            $description = $description ?: $category->metaData->resume_meta_description;
        }
        if ($profession && (!$title || !$description)){
            $title = $title ?: $profession->metaData->resume_meta_title;
            $description = $description ?: $profession->metaData->resume_meta_description;
        }
        $title = $title ?: KeyValue::findValueByKey('resume_search_page_title') ?: "Поиск резюме";
        $description = $description ?: KeyValue::findValueByKey('resume_search_page_description') ?: "Поиск резюме";

        $view->title = $title;
        $view->registerMetaTag(['name' => 'description', 'content' => $description]);
        $view->registerMetaTag(['name' => 'og:title', 'content' => $view->title]);
        $view->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
        $view->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
        $view->registerMetaTag(['name' => 'og:image', 'content' => Yii::$app->urlManager->hostInfo.'/images//og_image.jpg']);
        $view->registerMetaTag(['name' => 'og:description', 'content' => $description]);

    }

    /**
     * @param City $city
     * @param Category $category
     * @param Professions $profession
     * @return string
     */
    public static function getSearchPageHeader($city, $category, $profession)
    {
        $header = null;
        $meta_data = null;
        if ($city && $category){
            $meta_data = $category->metaData;
        }
        elseif ($city && $profession){
            $meta_data = $profession->metaData;
        }
        if ($meta_data){
            $header = str_replace('{city}', $city->name, $meta_data->resume_header_with_city);
            $header = str_replace('{region}', $city->region->name, $header);
            $header = str_replace('{city_prep}', $city->prepositional, $header);
        }
        if ($city && !$header){
            $header = $header ?: $city->header;
        }
        if ($category && !$header){
            $header = $header ?: $category->metaData->resume_header;
        }
        if ($profession && !$header){
            $header = $header ?: $profession->metaData->resume_header;
        }
        $header = $header ?: KeyValue::findValueByKey('resume_search_page_h1') ?: "Поиск резюме";
        return $header;
    }

    /**
     * @param View $view
     * @param Resume $resume
     * @throws \yii\base\InvalidConfigException
     */
    public static function registerResumeViewPageTags($view, $resume)
    {
        if (!Experience::getPeriod_string(Experience::getPeriod_sum($resume->experience)) == 0){
            $exp = Experience::getPeriod_string(Experience::getPeriod_sum($resume->experience));
        }else{
            $exp = 'без опыта';
        }

        $view->title = 'Резюме' . ':' . $resume->employer->second_name . ' ' . $resume->employer->first_name . '- ' . $resume->title . ',' . $resume->city0->name;
//$view->registerMetaTag(['name'=>'description', 'content' => StringHelper::truncate($resume->description, 100, '...')]);
        $view->registerMetaTag(['name' => 'description', 'Резюме ' . $resume->employer->second_name . ' ' . $resume->employer->first_name .
            ', на должность ' . $resume->title . '. Опыт работы: ' . $exp . '. ' .
            ' Размещено ' . Yii::$app->formatter->asDate($resume->update_time, 'dd.MM.yyyy')]);
        $view->registerMetaTag(['name' => 'og:title', 'content' => $resume->title]);
        $view->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
        $view->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
        $view->registerMetaTag(['name' => 'og:image', 'content' => $resume->image_url ?: '/images/og_image.jpg']);
        $view->registerMetaTag(['name' => 'og:description', 'content' => StringHelper::truncate($resume->description, 100, '...')]);
        $view->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->request->hostInfo . '/resume/view/' . $resume->id]);

    }
}