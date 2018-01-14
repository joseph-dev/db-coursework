<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chipset */
/* @var $socketDictionary array */
/* @var $activeSockets array */

$this->title = Yii::t('app', 'Create Chipset');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chipsets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chipset-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'            => $model,
        'socketDictionary' => $socketDictionary,
        'activeSockets'    => $activeSockets,
    ]) ?>

</div>
