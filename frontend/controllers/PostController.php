<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use common\models\Post;

/**
 * Post Controller
 */
class PostController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['get', 'save', 'remove'],
                'rules' => [
                    [
                        'actions' => ['get', 'save', 'remove'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Shows post
     *
     * @return mixed
     */
    public function actionRead()
    {
        $id = Yii::$app->request->get('id');
        
        if (!$post = Post::findOne($id))
            throw new NotFoundHttpException('Post not found');
        
        $post->isPublished();
        
        return $this->render('read', [
            'post' => $post
        ]);
    }
    
    /**
     * Shows post
     *
     * @return mixed
     */
    public function actionGet()
    {
        $id = Yii::$app->request->post('id');
        
        if (!$post = Post::findOne($id))
            throw new NotFoundHttpException('Post not found');

        $post->isPublished();
        $post->isMine();
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return static::result(true, [
            'id' => $post->id,
            'title' => $post->title(),
            'content' => $post->content()
        ]);
    }
    
    /**
     * Save article
     * 
     * @return string
     */
    public static function actionSave()
    {   
        $id = Yii::$app->request->post('id');

        $title = Yii::$app->request->post('title');
        $content = Yii::$app->request->post('content');
        $img = UploadedFile::getInstanceByName('img');
        
        $postForm = new \frontend\models\PostForm();
        $postForm->load(Yii::$app->request->post(), '');
        
        if ($img) {
            list ($width, $height, $fileType) = getimagesize($img->tempName);

            $image = new \common\helpers\Img();
            $image->load($img->tempName);

            if ($width > 320)
                $image->width(320);
            if ($height > 240)
                $image->width(240);
            
            $imgName = uniqid() . '.jpg';
            $imgPath = Yii::getAlias('@webroot') . '/' . Yii::$app->params['uploadDir'] . $imgName;

            $image->save($imgPath, IMAGETYPE_PNG);
            
            $postForm->img = $imgName;
        }
        
        $postForm->userId = Yii::$app->user->id;

        $post = $postForm->save();
        
        if ($errors = $postForm->getErrors() ? : $post->errors)
            return static::result(false, $errors);

        return static::result(true, '/post/read/' . $post->getPrimaryKey());
    }

    /**
     * Remove article
     * 
     * @return string
     */
    public static function actionRemove()
    {
        $id = Yii::$app->request->post('id');
        
        if (!$post = Post::findOne($id))
            throw new NotFoundHttpException('Post not found');
        
        $post->isMine();
        
        $post->status = Post::STATUS_REMOVED;
        $post->save();

        return static::result(true);
    }
}
