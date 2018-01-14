<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Socket */
/* @var $chipsetDictionary array */
/* @var $activeChipsets array */

$this->title = Yii::t('app', 'Create Socket');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sockets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'             => $model,
        'chipsetDictionary' => $chipsetDictionary,
        'activeChipsets'    => $activeChipsets,
    ]) ?>

</div>
