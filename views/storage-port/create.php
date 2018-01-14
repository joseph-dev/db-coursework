<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StoragePort */

$this->title = Yii::t('app', 'Create Storage Port');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Storage Ports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-port-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
