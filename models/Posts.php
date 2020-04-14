<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $keywords
 * @property string $description
 * @property string $created_date
 * @property int $category
 * @property string $alias
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text', 'keywords', 'description', 'created_date', 'category', 'alias'], 'required'],
            [['title', 'text', 'keywords', 'description', 'alias'], 'string'],
            [['created_date'], 'safe'],
            [['category'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'created_date' => 'Created Date',
            'category' => 'Category',
            'alias' => 'Alias',
        ];
    }
}
