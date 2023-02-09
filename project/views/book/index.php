<?php

use app\models\Book;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->isGuest ? '' : Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::beginForm('report', 'post'); ?>
        Report: TOP 10 <?= Html::dropDownList('year', null, Book::getYears()); ?>
        <?= Html::submitButton('Download', ['name' => 'report_send']); ?>
        <?= Html::endForm(); ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                    return implode(', ', ArrayHelper::map($model->bookAuthors, 'id', 'name'));
                },
                'format' => 'raw'
            ],
            'updated_at',
            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visible' => !Yii::$app->user->isGuest
            ],
        ],
    ]); ?>


</div>
