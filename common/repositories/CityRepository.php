<?php

namespace common\repositories;

use common\models\City;
use Yii;

class CityRepository extends Repository
{
    /**
     * @param int $company_id
     * @return City[]
     */
    public static function getCitiesByCompanyId($company_id) {
        return City::find()
            ->select(['geobase_city.id', 'geobase_city.name', 'geobase_city.slug'])
            ->innerJoin('vacancy', 'vacancy.city_id = geobase_city.id')
            ->where([
                'vacancy.status' => 1,
                'vacancy.company_id' => $company_id
            ])
            ->groupBy('geobase_city.id')
            ->orderBy('count(geobase_city.id) DESC')
            ->limit(3)
            ->all();
    }
}