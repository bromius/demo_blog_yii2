<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Post;

/**
 * Post form
 */
class PostForm extends Model
{
    public $id;
    public $userId;
    public $title;
    public $content;
    public $img;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'integer', 'skipOnEmpty' => true],
            
            ['userId', 'required'],
            
            ['title', 'trim'],
            ['title', 'required'],
            ['title', 'string', 'min' => 2, 'max' => 255, 'message' => 'Заголовок должен содержать от 1 до 255 символов'],

            ['content', 'trim'],
            ['content', 'required'],
            ['content', 'string', 'min' => 2, 'message' => 'Текст должен содержать более 2 символов'],
            
            ['img', 'image',  'mimeTypes' => 'png,jpg', 'skipOnEmpty' => true],
        ];
    }

    /**
     * Saves post
     *
     * @return bool
     */
    public function save()
    {
        if (!$this->validate())
            return null;
        
        if ($this->id) {
            $model = Post::findOne($this->id);
            $model->isMine();
        } else {
            $model = new Post();
        }
        
        $model->user_id = $this->userId;
        $model->title = $this->title;
        $model->content = $this->content;
        $model->img = $this->img && $this->img != 'undefined' 
                ? $this->img 
                : $model->img;
        
        $model->save();
        
        return $model;
    }
}
