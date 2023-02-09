<?php

use app\models\Author;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
?>
<style>
    #book-authors {
        height: 100px;
        overflow: auto;
        border: 1px solid #ccc;
    }

    #book-authors label {
        display: block;
    }
</style>
<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->dropDownList(\app\models\Book::getYears()) ?>
    <?= $form->field($model, 'authors')->checkboxList(ArrayHelper::map(Author::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'isbn')->fileInput() ?>
    <?= $model->getISBNImg(); ?>

    <?= $form->field($model, 'photo')->fileInput() ?>
    <?= $model->getPhotoImg(); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
