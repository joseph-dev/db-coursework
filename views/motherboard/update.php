<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Motherboard */
/* @var $manufacturerDictionary array */
/* @var $formFactorDictionary array */
/* @var $chipsetDictionary array */
/* @var $socketDictionary array */
/* @var $ramTypeDictionary array */
/* @var $slotDictionary array */
/* @var $storagePortDictionary array */
/* @var $externalPortDictionary array */
/* @var $slotQuantities array */
/* @var $slotQuantities array */
/* @var $storagePortQuantities array */
/* @var $externalPortQuantities array */

$this->title = Yii::t('app', 'Update Motherboard: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Motherboards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="motherboard-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'                  => $model,
        'manufacturerDictionary' => $manufacturerDictionary,
        'formFactorDictionary'   => $formFactorDictionary,
        'chipsetDictionary'      => $chipsetDictionary,
        'socketDictionary'       => $socketDictionary,
        'ramTypeDictionary'      => $ramTypeDictionary,
        'slotDictionary'         => $slotDictionary,
        'storagePortDictionary'  => $storagePortDictionary,
        'externalPortDictionary' => $externalPortDictionary,
        'slotQuantities'         => $slotQuantities,
        'storagePortQuantities'  => $storagePortQuantities,
        'externalPortQuantities' => $externalPortQuantities,
    ]) ?>

</div>
