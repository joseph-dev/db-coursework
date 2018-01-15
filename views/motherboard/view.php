<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Motherboard */
/* @var $manufacturerName string */
/* @var $formFactorName string */
/* @var $chipsetName string */
/* @var $socketName string */
/* @var $ramTypeName string */
/* @var $slots array */
/* @var $storagePorts array */
/* @var $externalPorts array */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Motherboards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="motherboard-view">

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
                'attribute' => 'manufacturer_id',
                'value'     => $manufacturerName
            ],

            [
                'attribute' => 'form_factor_id',
                'value'     => $formFactorName
            ],

            [
                'attribute' => 'chipset_id',
                'value'     => $chipsetName
            ],

            [
                'attribute' => 'socket_id',
                'value'     => $socketName
            ],

            [
                'attribute' => 'ram_type_id',
                'value'     => $ramTypeName
            ],

            'ram_slots',
            'ram_max',
            'ram_chanels',
            'power_connector',
            'audio',
            'video',
            'height',
            'width',

            [
                'label' => 'Слоти',
                'value' => function () use ($slots) {
                    $result = '';

                    foreach ($slots as $slot) {
                        $result .= $slot['quantity'] . ' x ' . $slot['name'] . ', ';
                    }

                    return trim($result, ', ');
                }
            ],

            [
                'label' => 'Роз\'єми для накопичувачів',
                'value' => function () use ($storagePorts) {
                    $result = '';

                    foreach ($storagePorts as $port) {
                        $result .= $port['quantity'] . ' x ' . $port['name'] . ', ';
                    }

                    return trim($result, ', ');
                }
            ],

            [
                'label' => 'Зовнішні роз\'єми',
                'value' => function () use ($externalPorts) {
                    $result = '';

                    foreach ($externalPorts as $port) {
                        $result .= $port['quantity'] . ' x ' . $port['name'] . ', ';
                    }

                    return trim($result, ', ');
                }
            ],
        ],
    ]) ?>

</div>
