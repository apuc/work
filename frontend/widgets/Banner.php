<?php
namespace frontend\widgets;

use common\classes\BannerService;
use common\models\BannerLocation;
use yii\base\Widget;

class Banner extends Widget
{
    public $categoryId;

    public $cityId;

    public $banner=null;

    public function run()
    {
        if(!$this->banner) {
            $this->banner = (new BannerService([
                'repository' => \common\models\Banner::className(),
                'locationsRepository' => BannerLocation::className()
            ]))->getRandomBanner($this->categoryId, $this->cityId);
        }
        return ($this->banner) ? $this->render('banner', ['model' => $this->banner]) : '';
    }
}