<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 13.06.19
 * Time: 17:17
 */

namespace frontend\modules\msg\assets;


use vision\messages\assets\BaseMessageAssets;

class CGMessageAssets extends BaseMessageAssets
{
    public $js = [
        '/js/cg_vision_messages.js',
    ];

    public $css = [
        'css/kushalpandya.css',
    ];

    public $depends = [
        'vision\messages\assets\PrivateMessPoolingAsset',
        'yii\web\JqueryAsset'
    ];

}