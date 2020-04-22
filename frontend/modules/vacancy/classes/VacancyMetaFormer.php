<?php

namespace frontend\modules\vacancy\classes;

use common\models\Category;
use common\models\City;
use common\models\Country;
use common\models\KeyValue;
use common\models\Professions;
use common\models\Vacancy;
use Yii;
use yii\helpers\StringHelper;
use yii\web\View;

class VacancyMetaFormer
{
    /**
     * @param View $view
     * @param City $city
     * @param Category $category
     * @param Professions $profession
     * @param Country $country
     */
    public static function registerVacancySearchPageTags($view, $city, $category, $profession, $country)
    {
        $description = null;
        $title = null;
        $meta_data = null;
        if($country && !$city) {
            if($category) {
                $title = "Вакансии: $category->name в $country->name";
                $description = "Свежие вакансии в категории $category->name. Все вакансии ДНР на сайте поиска работы №1 - rabota.today";
            } else if ($profession) {
                $title = "Работа $profession->instrumental в $country->name. Вакансии $profession->genitive - $country->name";
                $description = "Открытые вакансии $profession->genitive в $country->name. Поиск работы $profession->instrumental - $country->name. Свежие вакансии на сегодня.";
            } else {
                $title = $country->search_page_title;
                $description = $country->search_page_description;
            }
        } else {
            if ($city && $category) {
                $meta_data = $category->metaData;
            } else if ($city && $profession) {
                $meta_data = $profession->metaData;
            }
            if($meta_data) {
                $title = str_replace('{city}', $city->name, $meta_data->vacancy_meta_title_with_city);
                $title = str_replace('{region}', $city->region->name, $title);
                $title = str_replace('{city_prep}', $city->prepositional, $title);
                $description = str_replace('{city}', $city->name, $meta_data->vacancy_meta_description_with_city);
                $description = str_replace('{region}', $city->region->name, $description);
                $description = str_replace('{city_prep}', $city->prepositional, $description);
            }
            if ($city && (!$title || !$description)) {
                $title = $title ?: $city->meta_title;
                $description = $description ?: $city->meta_description;
            }
            if ($category && (!$title || !$description)) {
                $title = $title ?: $category->metaData->vacancy_meta_title;
                $description = $description ?: $category->metaData->vacancy_meta_description;
            }
            if ($profession && (!$title || !$description)) {
                $title = $title ?: $profession->metaData->vacancy_meta_title;
                $description = $description ?: $profession->metaData->vacancy_meta_description;
            }
        }

        $title = $title ?: KeyValue::findValueByKey('vacancy_search_page_title') ?: "Поиск Вакансий";
        $description = $description ?: KeyValue::findValueByKey('vacancy_search_page_description') ?: "Поиск Вакансий";

        $view->title = $title;
        $view->registerMetaTag(['name'=>'description', 'content' => $description]);
        $view->registerMetaTag(['name'=>'og:title', 'content' => $view->title]);
        $view->registerMetaTag(['name'=>'og:type', 'content' => 'website']);
        $view->registerMetaTag(['name'=>'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
        $view->registerMetaTag(['name'=>'og:image', 'content' => Yii::$app->urlManager->hostInfo.'/images//og_image.jpg']);
        $view->registerMetaTag(['name'=>'og:description', 'content' => $description]);
    }

    /**
     * @param City $city
     * @param Category $category
     * @param Professions $profession
     * @param Country $country
     * @return string
     */
    public static function getSearchPageHeader($city, $category, $profession, $country)
    {
        $header = null;
        $meta_data = null;
        if($country && !$city) {
            if ($category) {
                $header = "Вакансии: $category->name, $country->name";
            } else if ($profession) {
                $header = "Работа $profession->instrumental в $country->name";
            } else {
                $header = $country->search_page_header;
            }
        }
        if ($city && $category) {
            $meta_data = $category->metaData;
        } else if ($city && $profession) {
            $meta_data = $profession->metaData;
        }
        if($meta_data) {
            $header = str_replace('{city}', $city->name, $meta_data->vacancy_header_with_city);
            $header = str_replace('{region}', $city->region->name, $header);
            $header = str_replace('{city_prep}', $city->prepositional, $header);
        }
        if ($city && !$header) {
            $header = $header ?: $city->header;
        }
        if ($category && !$header) {
            $header = $header ?: $category->metaData->vacancy_header;
        }
        if ($profession && !$header) {
            $header = $header ?: $profession->metaData->vacancy_header;
        }
        $header = $header ?: KeyValue::findValueByKey('vacancy_search_page_h1') ?: "Поиск Вакансий";
        return $header;
    }

    /**
     * @param View $view
     * @param Vacancy $vacancy
     */
    public static function registerVacancyViewPageTags($view, $vacancy)
    {
        if ($vacancy->company->name)
            $title = 'Вакансия: ' . ucfirst($vacancy->post) . ($vacancy->city0 ? ' в '.$vacancy->city0->prepositional : '') . ', ' . $vacancy->company->name;
        else
            $title = 'Вакансия: ' . ucfirst($vacancy->post) . ($vacancy->city0 ? ' в '.$vacancy->city0->prepositional : '') . ', ' . $vacancy->getMoneyString(false) . ', ' . 'размещено ' .Yii::$app->formatter->asDate($vacancy->update_time, 'dd.MM.yyyy');

        if ($vacancy->company->name) {
            $description = 'Вакансия ' . $vacancy->post . ' в компании ' . $vacancy->company->name . ' в категории ' .
                $vacancy->mainCategory->name;
            if($vacancy->city0)
                $description .= ', г' . $vacancy->city0->name . ',' . $vacancy->city0->region->name;
            $description .= '. Размещено ' . Yii::$app->formatter->asDate($vacancy->update_time, 'dd MM yyyy');
        } else {
            $description = 'Вакансия ' . $vacancy->post . ' в категории ' . $vacancy->mainCategory->name;
            if($vacancy->city0)
                $description .= ', г. ' . $vacancy->city0->name . ', ' . $vacancy->city0->region->name;
            $description .= '. Контактное лицо ' . $vacancy->company->contact_person .
                '. Размещено ' . Yii::$app->formatter->asDate($vacancy->update_time, 'dd MM yyyy');
        }
        $view->title = $title;
        $view->registerMetaTag(['name' => 'description', 'content' => $description]);
        $view->registerMetaTag(['name' => 'og:title', 'content' => $title]);
        $view->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
        $view->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
        $view->registerMetaTag(['name' => 'og:image', 'content' => $vacancy->company->image_url ?: '/images/og_image.jpg']);
        $view->registerMetaTag(['name' => 'og:description', 'content' => StringHelper::truncate($vacancy->qualification_requirements, 100, '...')]);
        $view->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->request->hostInfo . '/vacancy/view/' . $vacancy->id]);
    }
}