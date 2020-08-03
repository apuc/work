<?php

namespace common\helpers;

use yii\data\BaseDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class ApiHelper
{
    public static function buildResponse(ActiveRecord $model, $expands = null) {
        $response = ArrayHelper::toArray($model);
        if($expands) {
            $expands = explode(',', $expands);
            foreach ($expands as $expand) {
                $exploded = explode('.', $expand);
                if (count($exploded) > 1) {
                    $first_item = $exploded[0];
                    $tmp = $model->$first_item;
                    if(!isset($response[$first_item]))
                        $response[$first_item] = ArrayHelper::toArray($tmp);
                    foreach ($exploded as $j => $item) {
                        if ($j != 0) {
                            $tmp = $tmp->$item;
                            $response[$first_item][$item] = is_object($tmp) ? ArrayHelper::toArray($tmp) : $tmp;
                        }
                    }

                } else {
                    $response[$expand] = $model->$expand;
                }
            }
        }
        return $response;
    }

    public static function buildMultiResponse(BaseDataProvider $dataProvider, $expands = null) {
        $models = $dataProvider->getModels();
        $expandsArray = explode(',', $expands);
        $response = [];
        /** @var ActiveRecord[] $models */
        foreach ($models as $i=> $model) {
            $response[$i]=ArrayHelper::toArray($model);
            if($expands) {
                foreach ($expandsArray as $expand) {
                    $exploded = explode('.', $expand);
                    if (count($exploded) > 1) {
                        $first_item = $exploded[0];
                        $tmp = $model->$first_item;
                        if(!isset($response[$i][$first_item]))
                            $response[$i][$first_item] = ArrayHelper::toArray($tmp);
                        foreach ($exploded as $j => $item) {
                            if ($j != 0 && !empty($tmp)) {
                                $tmp = $tmp->$item;
                                $response[$i][$first_item][$item] = is_object($tmp) ? ArrayHelper::toArray($tmp) : $tmp;
                            }
                        }

                    } else {
                        $response[$i][$expand] = $model->$expand;
                    }
                }
            }
        }
        $pagination = [
            'current_page'=>$dataProvider->getPagination()->getPage()+1,
            'page_count'=>$dataProvider->getPagination()->getPageCount(),
            'per_page'=>$dataProvider->getPagination()->getPageSize(),
            'total_count'=>$dataProvider->getTotalCount(),
        ];
        return ['pagination'=>$pagination, 'models'=>$response];
    }
}