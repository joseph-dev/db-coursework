<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Socket */
/* @var $chipsetDictionary array */
/* @var $activeChipsets array */

$this->title = Yii::t('app', 'Update Socket: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sockets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="socket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'             => $model,
        'chipsetDictionary' => $chipsetDictionary,
        'activeChipsets'    => $activeChipsets,
    ]) ?>

</div>
