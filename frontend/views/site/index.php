<?php

/* @var $this yii\web\View */
/* @var $rows common\models\Post */

use yii\helpers\Url;
use yii\helpers\StringHelper;

$this->title = 'Блог';
?>
<div class="site-index">

    <?php if (!empty($rows)): ?>
        <div class="row">
            <?php foreach ($rows as $row): ?>
                <div class="post-container col-md-12 col-lg-6 col-xl-3">
                    <div class="post-shortcut box-shadow">
                        <h2>
                            <a class="text-dark" href="<?= Url::to(['/post/read/' . $row->id]) ?>">
                                <?= $row->title() ?>
                            </a>
                        </h2>

                        <div class="text-muted post-date">
                            <?= $row->createdAt('d.m.Y H:i') ?>
                        </div>

                        <div class="post-content">
                            <?php if ($row->image()): ?>
                                <a class="post-img pull-right" href="<?= Url::to(['/post/read/' . $row->id]) ?>">
                                    <img src="<?= $row->image() ?>" alt="" />
                                </a>
                            <?php endif ?>

                            <?= StringHelper::truncateWords($row->content(), 40) ?>

                            <br />

                            <a href="<?= Url::to(['/post/read/' . $row->id]) ?>">Читать &raquo;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <div class="empty_list">
            Записей пока нет
        </div>
    <?php endif ?>
    
</div>
