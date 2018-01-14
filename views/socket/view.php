<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Socket */
/* @var $chipsets app\models\Chipset[] */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sockets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'chipsets',
                'value'     => function () use ($chipsets) {
                    $array = \yii\helpers\ArrayHelper::getColumn($chipsets, 'name');
                    return trim(implode(', ', $array), ', ');
                }
            ]
        ],
    ]) ?>

</div>
