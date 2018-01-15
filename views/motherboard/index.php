<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\MotherboardSearch */

$this->title = Yii::t('app', 'Motherboards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="motherboard-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Motherboard'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin([
        'action'  => ['/motherboard/index'],
        'method'  => 'get',
        'options' => ['data-pjax' => false],
        'id'      => 'motherboard-search-form'
    ]); ?>
    <?= $form->field($searchModel, 'name')->textInput([['maxlength' => 200]])->label('Пошук:') ?>
    <div class="form-group">
        <?= Html::submitButton('Шукати', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Очистити', ['/motherboard/index'], ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
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
