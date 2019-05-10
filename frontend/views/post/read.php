<?php

/* @var $this yii\web\View */
/* @var $post common\models\Post */

use frontend\assets\PostAsset;

use yii\helpers\Url;
use yii\helpers\StringHelper;

$this->title = $post->title();

PostAsset::register($this);
?>

<div class="post">
	<h1><?= $post->title() ?></h1>
	
	<div class="post-date">
		<?= $post->user()->username ?> | <?= $post->createdAt('d.m.Y H:i') ?> 
		<?php if ($post->created_at != $post->updated_at): ?>
			<i>(обновлено <?= $post->updatedAt('d.m.Y H:i:s') ?>)</i>
		<?php endif ?>
	</div>

	<div class="post-content">
		<?php if ($post->image()): ?>
			<img class="pull-right" src="<?= $post->image() ?>" alt="" />
		<?php endif; ?>
		<?= $post->content() ?>
	</div>
	
	<?php if ($post->isMine(false)): ?>
		<div class="control-panel">
			<button type="button" class="btn btn-sm btn-secondary js-post-edit" data-id="<?= $post->id ?>">Редактировать</button>
			<button type="button" class="btn btn-sm btn-danger js-post-remove" data-id="<?= $post->id ?>">Удалить</button>
		</div>
	<?php endif ?>
</div>