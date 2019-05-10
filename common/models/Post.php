<?php

namespace common\models;

use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

use common\models\User;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property string $title
 * @property string $content
 * @property string $img
 * @property string $updated_at
 * @property string $created_at
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 'published';
    const STATUS_REMOVED = 'removed';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'content'], 'required'],
            [['user_id'], 'integer'],
            [['status', 'content'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'title' => 'Title',
            'content' => 'Content',
            'img' => 'Img',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
    
    public static function getPublishedPosts()
    {
        return new ActiveDataProvider([
            'query' => Post::find()
                ->where(['status' => static::STATUS_PUBLISHED])
                ->orderBy(['id' => SORT_DESC])
        ]);
    }
    
    public function title()
    {
        return ucfirst(Html::encode($this->{__FUNCTION__}));
    }
    
    public function content()
    {
        return $this->{Html::encode(__FUNCTION__)};
    }
    
    public function image()
    {
        return $this->img ? '/upload/' . $this->img : null;
    }
    
    public function createdAt($mask = null)
    {
        if ($mask) {
            $timeStamp = strtotime($this->created_at);
            return date($mask, $timeStamp);
        }
        
        return $this->created_at;
    }

    public function updatedAt($mask = null)
    {
        if ($mask) {
            $timeStamp = strtotime($this->updated_at);
            return date($mask, $timeStamp);
        }
        
        return $this->updated_at;
    }

    public function user()
    {
        return User::findOne($this->user_id);
    }
    
    /**
     * Check whether post author is current user
     * 
     * @param bool $throwException Throws exception if not FALSE
     * @return boolean
     * @throws ForbiddenHttpException
     */
    public function isMine($throwException = true)
    {
        if ($this->user_id != Yii::$app->user->id) {
            if ($throwException)
                throw new ForbiddenHttpException('У Вас недостаточно прав для доступа к этому материалу');
            else
                return false;
        }
        return true;
    }
    
    /**
     * Check whether post is published (status check)
     * 
     * @param bool $throwException Throws exception if not FALSE
     * @return boolean
     * @throws NotFoundHttpException
     */
    public function isPublished($throwException = true)
    {
        if ($this->status != static::STATUS_PUBLISHED) {
            if ($throwException)
                throw new NotFoundHttpException('Пост не найден');
            else
                return false;
        }
        return true;
    }
}
