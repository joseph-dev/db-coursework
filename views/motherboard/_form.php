<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Motherboard */
/* @var $form yii\widgets\ActiveForm */
/* @var $manufacturerDictionary array */
/* @var $formFactorDictionary array */
/* @var $chipsetDictionary array */
/* @var $socketDictionary array */
/* @var $ramTypeDictionary array */
?>

<div class="motherboard-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manufacturer_id')->dropDownList($manufacturerDictionary) ?>

    <?= $form->field($model, 'form_factor_id')->dropDownList($formFactorDictionary) ?>

    <?= $form->field($model, 'chipset_id')->dropDownList($chipsetDictionary) ?>

    <?= $form->field($model, 'socket_id')->dropDownList($socketDictionary) ?>

    <?= $form->field($model, 'ram_type_id')->dropDownList($ramTypeDictionary) ?>

    <?= $form->field($model, 'ram_slots')->textInput() ?>

    <?= $form->field($model, 'ram_max')->textInput() ?>

    <?= $form->field($model, 'ram_chanels')->textInput() ?>

    <?= $form->field($model, 'power_connector')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
