<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FormFactor */

$this->title = Yii::t('app', 'Create Form Factor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Form Factors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-factor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
