<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Chipset */
/* @var $sockets app\models\Socket[] */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chipsets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chipset-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'sockets',
                'value'     => function () use ($sockets) {
                    $array = \yii\helpers\ArrayHelper::getColumn($sockets, 'name');
                    return trim(implode(', ', $array), ', ');
                }
            ]
        ],
    ]) ?>

</div>
