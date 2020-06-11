<?php
namespace frontend\widgets;

use common\classes\BannerService;
use common\models\BannerLocation;
use yii\base\Widget;

class Banner extends Widget
{
    public $categoryId;

    public $cityId;

    public function run()
    {
        return '';
        $banner = (new BannerService([
            'repository' => \common\models\Banner::className(),
            'locationsRepository' => BannerLocation::className()
        ]))->getRandomBanner($this->categoryId, $this->cityId);

        return ($banner) ? $this->render('banner', ['model' => $banner]) : '';
    }
}