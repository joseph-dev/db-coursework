<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RamType */

$this->title = Yii::t('app', 'Create Ram Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ram Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ram-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
