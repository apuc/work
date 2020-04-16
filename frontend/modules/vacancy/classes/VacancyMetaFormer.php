<?php

namespace frontend\modules\vacancy\classes;

use common\models\Vacancy;
use Yii;
use yii\helpers\StringHelper;
use yii\web\View;

class VacancyMetaFormer
{
    /**
     * @param View $view
     * @param Vacancy $vacancy
     */
    public static function registerVacancyViewPageTags($view, $vacancy) {
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
        $view->registerMetaTag(['name' => 'description', $description]);
        $view->registerMetaTag(['name' => 'og:title', 'content' => $title]);
        $view->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
        $view->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
        $view->registerMetaTag(['name' => 'og:image', 'content' => $vacancy->company->image_url ?: '/images/og_image.jpg']);
        $view->registerMetaTag(['name' => 'og:description', 'content' => StringHelper::truncate($vacancy->qualification_requirements, 100, '...')]);
        $view->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->request->hostInfo . '/vacancy/view/' . $vacancy->id]);
    }
}