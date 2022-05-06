<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\{ActiveRecord, ActiveQuery, Expression};

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property int $parent_id [int(11)]
 * @property string $content
 * @property int $created_at [int(11) unsigned]
 * @property int $updated_at [int(11) unsigned]
 * @property Comment[] $comments
 * @property Comment $parent
 * @property bool $isParent
 */
class Comment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['parent_id'], 'integer'],
            [
                ['parent_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Comment::class,
                'targetAttribute' => ['parent_id' => 'id']
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(Comment::class, ['id' => 'parent_id']);
    }

    /**
     * @return bool
     */
    public function getIsParent(): bool
    {
        return $this->getComments()->count() > 0;
    }
}
