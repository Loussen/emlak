<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/jquery.formstyler.css',
    ];
    public $js = [
        'js/jquery-1.7.1.min.js',
        'js/jquery.formstyler.js',
        'js/slick.min.js',
        'js/scripts.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
