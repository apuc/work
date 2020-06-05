<?php

namespace common\classes;

use common\models\Banner;
use common\models\BannerLocation;

use yii\base\Component;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Transaction;

use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class BannerService extends Component
{
    const LOCATIONS_FORM_NAME = 'BannerLocation';

    /** @var Banner $repository */
    public $repository;

    /** @var BannerLocation $locationsRepository */
    public $locationsRepository;


    /**
     * @param ActiveRecord $repository
     */
    public function switchRepository(ActiveRecord $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @return ActiveDataProvider
     */
    public function getIndexDataProvider() : ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $this->getQuery()
        ]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery() : ActiveQuery
    {
        return $this->repository::find();
    }


    /**
     * @param $id
     * @return Banner
     * @throws NotFoundHttpException
     */
    public function getById($id) : Banner
    {
        if (is_null($model = $this->repository::findOne($id))) {
            throw new NotFoundHttpException('Баннер не найден');
        }

        return $model;
    }


    /**
     * @param $id
     * @return bool
     * @throws ErrorException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteById($id) : bool
    {
        $isDeleted = $this->getById($id)->delete();

        if (!$isDeleted) {
            throw new ErrorException('Удаление не удалось');
        }

        return true;
    }


    /**
     * @param $attributes
     */
    public function updateModelTransaction($attributes)
    {
        $transaction = $this->getTransactionAndStart();

        try {
            $this->updateModelAndRelations($attributes);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
        }
    }


    /**
     * @return Transaction|null
     */
    private function getTransactionAndStart()
    {
        return \Yii::$app->db->beginTransaction();
    }


    /**
     * @param $attributes
     * @return bool|void
     */
    private function updateModelAndRelations($attributes)
    {
        if (!$this->repository->load($attributes) || !$this->repository->save()) {
            return false;
        }

        $this->deleteAllLocations();

        if (!empty($attributes[static::LOCATIONS_FORM_NAME])) {
            return $this->loadLocationsAndSave($attributes[static::LOCATIONS_FORM_NAME]);
        }
    }


    /**
     * @return bool
     */
    private function deleteAllLocations()
    {
        return (bool) $this->locationsRepository::deleteAll([
            'id' => ArrayHelper::getColumn($this->repository->bannerLocations, 'id')
        ]);
    }


    /**
     * @param $attributes
     * @return int Количество сохраненных локаций
     */
    private function loadLocationsAndSave($attributes) : int
    {
        $bannerId = $this->repository->id;
        $savedCount = 0;
        foreach ($attributes as $key => $params) {
            $params = array_merge($params, ['banner_id' => $bannerId]);
            $savedCount = $this->loadLocationAndSave($params) ? $savedCount + 1 : $savedCount;
        }

        return $savedCount;
    }


    /**
     * @param $params
     * @return bool
     */
    private function loadLocationAndSave($params) : bool
    {
        /** @var BannerLocation $location */
        $location = new $this->locationsRepository();
        $location->setAttributes($params);

        return $location->save();
    }


    /**
     * @param $params
     * @return bool
     */
    public function addBannerLocation($params) : bool
    {
        return (new $this->locationsRepository([
            'attributes' => $params
        ]))->save();
    }


    /**
     * @param int|null $categoryId
     * @param int|null $cityId
     * @return Banner|null
     */
    public function getRandomBanner($categoryId, $cityId)
    {
        /** @todo */
        return $this->repository::findOne(2);
    }
}