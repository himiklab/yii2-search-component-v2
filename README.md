Yii2 Zend Lucene Search Component V2
====================================
Zend Lucene `advanced` search component for Yii2.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

* Add

```json
"himiklab/yii2-search-component-v2" : "*",
"zendframework/zendsearch": "2.0.0rc6"
```

to the require section of your application's `composer.json` file.

* Add a new component in `components` section of your application's configuration file, for example:

```php
'components' => [
    'search' => [
        'class' => 'himiklab\yii2\search\Search',
        'models' => [
            'app\modules\page\models\Page',
        ],
    ],
    // ...
],
```

* Add behavior in the AR models, for example:

```php
use himiklab\yii2\search\behaviors\SearchBehavior;

public function behaviors()
{
    return [
        'search' => [
            'class' => SearchBehavior::className(),
            'searchScope' => function ($model) {
                /** @var \yii\db\ActiveQuery $model */
                $model->select(['title', 'body', 'url']);
                $model->andWhere(['indexed' => true]);
            },
            'searchFields' => function ($model) {
                /** @var self $model */
                return [
                    ['name' => 'title', 'value' => $model->title],
                    ['name' => 'body', 'value' => strip_tags($model->body)],
                    ['name' => 'url', 'value' => $model->url, 'type' => SearchBehavior::FIELD_KEYWORD],
                    // ['name' => 'model', 'value' => 'page', 'type' => SearchBehavior::FIELD_UNSTORED],
                ];
            }
        ],
    ];
}
```

Usage
-----
See example `Search` module.

Resources
---------
* [Zend Lucene](http://framework.zend.com/manual/1.12/en/zend.search.lucene.html)
