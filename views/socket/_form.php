<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Socket */
/* @var $chipsetDictionary array */
/* @var $activeChipsets array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="socket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chipsets')->widget(Select2::classname(), [
        'data'          => $chipsetDictionary,
        'language'      => 'uk',
        'options'       => [
            'value'       => $activeChipsets,
            'placeholder' => '-- Виберіть чипсети --',
            'multiple'    => true
        ],
        'showToggleAll' => false,
        'pluginOptions' => [
            'allowClear' => true
        ]
    ])->label('Чіпсети які підримують даний сокет'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
