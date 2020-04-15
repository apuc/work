<?php

namespace frontend\modules\main_page\classes;

use common\models\KeyValue;
use Yii;

class MetaFormer
{
    public static function registerMainPageTags($view, $country=null) {
        if($country) {
            $title = $country->meta_title?:(KeyValue::findValueByKey('main_page_title') ?: 'Работа: главная');
            $description = $country->meta_description?:KeyValue::findValueByKey('main_page_description');
        } else {
            $title = KeyValue::findValueByKey('main_page_title') ?: 'Работа: главная';
            $description = KeyValue::findValueByKey('main_page_description');
        }
        $view->title = $title;
        $view->registerMetaTag(['name' => 'description', 'content' => $description]);
        $view->registerMetaTag(['name' => 'og:title', 'content' => $title]);
        $view->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
        $view->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->hostInfo]);
        $view->registerMetaTag(['name' => 'og:image', 'content' => Yii::$app->urlManager->hostInfo . '/images/og_image.jpg']);
        $view->registerMetaTag(['name' => 'og:description', 'content' => $description]);
        $view->registerLinkTag(['rel'=>'canonical', 'href'=>Yii::$app->request->hostInfo]);

    }
}