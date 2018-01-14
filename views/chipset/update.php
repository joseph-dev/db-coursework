<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chipset */
/* @var $socketDictionary array */
/* @var $activeSockets array */

$this->title = Yii::t('app', 'Update Chipset: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chipsets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="chipset-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'            => $model,
        'socketDictionary' => $socketDictionary,
        'activeSockets'    => $activeSockets,
    ]) ?>

</div>
