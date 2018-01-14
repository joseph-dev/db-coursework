<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Form Factors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-factor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Form Factor'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'label'     => Yii::t('app', 'ID')
            ],

            [
                'attribute' => 'name',
                'label'     => Yii::t('app', 'Name')
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
