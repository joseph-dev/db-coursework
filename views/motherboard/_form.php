<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Motherboard */
/* @var $form yii\widgets\ActiveForm */
/* @var $manufacturerDictionary array */
/* @var $formFactorDictionary array */
/* @var $chipsetDictionary array */
/* @var $socketDictionary array */
/* @var $ramTypeDictionary array */
/* @var $slotDictionary array */
/* @var $storagePortDictionary array */
/* @var $externalPortDictionary array */
/* @var $slotQuantities array */
/* @var $storagePortQuantities array */
/* @var $externalPortQuantities array */
?>

<div class="motherboard-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'manufacturer_id')->dropDownList($manufacturerDictionary) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'form_factor_id')->dropDownList($formFactorDictionary) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'chipset_id')->dropDownList($chipsetDictionary, ['id' => 'chipset']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'socket_id')->dropDownList($socketDictionary, ['id' => 'socket']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ram_type_id')->dropDownList($ramTypeDictionary) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'ram_slots')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ram_max')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'ram_chanels')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'power_connector')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'height')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'width')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <label>Слоти</label>

        <?php if (count($slotQuantities) === 0): ?>

            <div class="row repeatable-block">
                <div class="col-md-5">
                    <?= $form->field($model, 'slotTypes[]')->dropDownList($slotDictionary)->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'slotQuantities[]')->textInput([
                        'type'  => 'number',
                        'min'   => 0,
                        'value' => 0,
                    ])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <a href="#" class="btn btn-success duplicate"><span class="glyphicon glyphicon-plus"></span></a>
                    <a href="#" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></a>
                </div>
            </div>

        <?php else: ?>

            <?php foreach ($slotQuantities as $slot => $quantity): ?>

                <div class="row repeatable-block">
                    <div class="col-md-5">
                        <?= $form->field($model, 'slotTypes[]')->dropDownList($slotDictionary,
                            ['value' => $slot])->label(false) ?>
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($model, 'slotQuantities[]')->textInput([
                            'type'  => 'number',
                            'min'   => 0,
                            'value' => $quantity,
                        ])->label(false) ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#" class="btn btn-success duplicate"><span class="glyphicon glyphicon-plus"></span></a>
                        <a href="#" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <div class="form-group">
        <label>Ро'єми для накопичувачів</label>

        <?php if (count($storagePortQuantities) === 0): ?>

            <div class="row repeatable-block">
                <div class="col-md-5">
                    <?= $form->field($model,
                        'storagePortTypes[]')->dropDownList($storagePortDictionary)->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'storagePortQuantities[]')->textInput([
                        'type'  => 'number',
                        'min'   => 0,
                        'value' => 0,
                    ])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <a href="#" class="btn btn-success duplicate"><span class="glyphicon glyphicon-plus"></span></a>
                    <a href="#" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></a>
                </div>
            </div>

        <?php else: ?>

            <?php foreach ($storagePortQuantities as $port => $quantity): ?>

                <div class="row repeatable-block">
                    <div class="col-md-5">
                        <?= $form->field($model, 'storagePortTypes[]')->dropDownList($storagePortDictionary,
                            ['value' => $port])->label(false) ?>
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($model, 'storagePortQuantities[]')->textInput([
                            'type'  => 'number',
                            'min'   => 0,
                            'value' => $quantity,
                        ])->label(false) ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#" class="btn btn-success duplicate"><span class="glyphicon glyphicon-plus"></span></a>
                        <a href="#" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <div class="form-group">
        <label>Зовнішні ро'єми</label>

        <?php if (count($externalPortQuantities) === 0): ?>

            <div class="row repeatable-block">
                <div class="col-md-5">
                    <?= $form->field($model,
                        'externalPortTypes[]')->dropDownList($externalPortDictionary)->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'externalPortQuantities[]')->textInput([
                        'type'  => 'number',
                        'min'   => 0,
                        'value' => 0,
                    ])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <a href="#" class="btn btn-success duplicate"><span class="glyphicon glyphicon-plus"></span></a>
                    <a href="#" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></a>
                </div>
            </div>

        <?php else: ?>

            <?php foreach ($externalPortQuantities as $port => $quantity): ?>

                <div class="row repeatable-block">
                    <div class="col-md-5">
                        <?= $form->field($model,
                            'externalPortTypes[]')->dropDownList($externalPortDictionary,
                            ['value' => $port])->label(false) ?>
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($model, 'externalPortQuantities[]')->textInput([
                            'type'  => 'number',
                            'min'   => 0,
                            'value' => $quantity,
                        ])->label(false) ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#" class="btn btn-success duplicate"><span class="glyphicon glyphicon-plus"></span></a>
                        <a href="#" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script>
        var ajaxGetSocketsByChipsetUrl = '<?= Url::to(['ajax/get-sockets-by-chipset', 'id' => null]) ?>';
    </script>

</div>
