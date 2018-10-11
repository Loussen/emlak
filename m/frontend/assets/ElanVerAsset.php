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
class ElanVerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery.formstyler.css',
        'css/sumoselect.css',
        'css/jquery.scrollbar.css',
        'css/style.css',
    ];
    public $js = [
        'js/jquery.min.js',
		'js/jquery.formstyler.js',
		'js/jquery.scrollbar.js',
		'js/masked_input.js',
        'js/jquery.poshytip.min.js',
		'js/scripts.js',
        'js/callStyler.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
