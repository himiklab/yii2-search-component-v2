<?php
/**
 * @link https://github.com/himiklab/yii2-search-component-v2
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace app\modules\search;

use yii\web\AssetBundle;

class SearchAssets extends AssetBundle
{
    public $sourcePath = '@app/modules/search/assets';

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public $css = ['css/search.css'];

    public function init()
    {
        parent::init();
        $this->js[] = YII_DEBUG ? 'js/jquery.highlight-4.js' : 'js/jquery.highlight-4.closure.js';
    }
}
