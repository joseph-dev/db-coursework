<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExternalPort */

$this->title = Yii::t('app', 'Create External Port');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'External Ports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-port-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
