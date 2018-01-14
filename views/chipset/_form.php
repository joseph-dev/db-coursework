<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Chipset */
/* @var $socketDictionary array */
/* @var $activeSockets array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chipset-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sockets')->widget(Select2::classname(), [
        'data'          => $socketDictionary,
        'language'      => 'uk',
        'options'       => [
            'value'       => $activeSockets,
            'placeholder' => '-- Виберіть сокети --',
            'multiple'    => true
        ],
        'showToggleAll' => false,
        'pluginOptions' => [
            'allowClear' => true
        ]
    ])->label('Сокети які підримує даний чіпсет'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
