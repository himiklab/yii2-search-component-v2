<?php
/**
 * @link https://github.com/himiklab/yii2-search-component-v2
 * @copyright Copyright (c) 2014-2017 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace himiklab\yii2\search\behaviors;

use yii\base\Behavior;
use yii\base\InvalidConfigException;

/**
 * For example:
 *
 * ```php
 * public function behaviors()
 * {
 *  return [
 *      'search' => [
 *         'class' => SearchBehavior::className(),
 *         'searchScope' => function ($model) {
 *             $model->select(['title', 'body', 'url']);
 *             $model->andWhere(['indexed' => true]);
 *         },
 *         'searchFields' => function ($model) {
 *             return [
 *                 ['name' => 'title', 'value' => $model->title],
 *                 ['name' => 'body', 'value' => strip_tags($model->body)],
 *                 ['name' => 'url', 'value' => $model->url, 'type' => SearchBehavior::FIELD_KEYWORD],
 *                 ['name' => 'model', 'value' => 'page', 'type' => SearchBehavior::FIELD_UNSTORED],
 *             ];
 *         }
 *      ],
 *  ];
 * }
 * ```
 *
 * @author HimikLab
 * @package himiklab\yii2\search\behaviors
 */
class SearchBehavior extends Behavior
{
    /* Fields are stored, indexed, and tokenized. Text fields are appropriate for storing
    information like subjects and titles that need to be searchable as well as returned with search results. */
    const FIELD_TEXT = 'text';

    /* Fields are stored and indexed, meaning that they can be searched as well as displayed
    in search results. They are not split up into separate words by tokenization. */
    const FIELD_KEYWORD = 'keyword';

    /* Fields are not tokenized or indexed, but are stored for retrieval with search hits.
    They can be used to store any data encoded as a binary string, such as an image icon. */
    const FIELD_BINARY = 'binary';

    /* Fields are not searchable, but they are returned with search hits. Database timestamps, primary keys,
    file system paths, and other external identifiers are good candidates for UnIndexed fields. */
    const FIELD_UNINDEXED = 'unIndexed';

    /* Fields are tokenized and indexed, but not stored in the index. Large amounts of text are best indexed using
    this type of field. Storing data creates a larger index on disk, so if you need to search but not redisplay
    the data, use an UnStored field. */
    const FIELD_UNSTORED = 'unStored';

    /** @var callable */
    public $searchFields;

    /** @var callable */
    public $searchScope;

    public function init()
    {
        if (!is_callable($this->searchFields)) {
            throw new InvalidConfigException('SearchBehavior::$searchFields isn\'t callable.');
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSearchModels()
    {
        /** @var \yii\db\ActiveRecord $owner */
        $owner = $this->owner;
        $query = $owner::find();
        if (is_callable($this->searchScope)) {
            call_user_func($this->searchScope, $query);
        }

        return $query;
    }
}
