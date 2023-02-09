<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'year',
            [
                'attribute' => 'isbn',
                'value' => function ($model) {
                    return $model->getISBNImg();
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'photo',
                'value' => function ($model) {
                    return $model->getPhotoImg();
                },
                'format' => 'raw'
            ],
            [
                'label' => 'Authors',
                'value' => function ($model) {
                    return implode(', ', \yii\helpers\ArrayHelper::map($model->bookAuthors, 'id', 'name'));
                },
                'format' => 'raw'
            ],
            'updated_at',
            'created_at',
        ],
    ]) ?>

</div>
