<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Материнські плати та їх базові характеристики',
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    NavBar::end();
    ?>

    <?php
        $activeMenuItem = isset($this->params['activeMenuItem']) ? $this->params['activeMenuItem'] : '';
    ?>

    <div class="container container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="<?= Url::to(['/']); ?>" class="list-group-item <?= $activeMenuItem === 'home' ? 'active' : '' ?>">Головна</a>
                    <a href="<?= Url::to(['manufacturer/index']); ?>" class="list-group-item <?= $activeMenuItem === 'manufacturer' ? 'active' : '' ?>">Виробники</a>
                    <a href="<?= Url::to(['form-factor/index']); ?>" class="list-group-item <?= $activeMenuItem === 'form-factor' ? 'active' : '' ?>">Форм фактори</a>
                    <a href="<?= Url::to(['chipset/index']); ?>" class="list-group-item <?= $activeMenuItem === 'chipset' ? 'active' : '' ?>">Чіпсети</a>
                    <a href="<?= Url::to(['socket/index']); ?>" class="list-group-item <?= $activeMenuItem === 'socket' ? 'active' : '' ?>">Сокети</a>
                    <a href="<?= Url::to(['ram/index']); ?>" class="list-group-item <?= $activeMenuItem === 'ram' ? 'active' : '' ?>">Оперативна пам'ять</a>
                    <a href="<?= Url::to(['slots/index']); ?>" class="list-group-item <?= $activeMenuItem === 'slots' ? 'active' : '' ?>">Слоти</a>
                    <a href="<?= Url::to(['storage-port/index']); ?>" class="list-group-item <?= $activeMenuItem === 'storage-port' ? 'active' : '' ?>">Роз'єми для накопичувачів</a>
                    <a href="<?= Url::to(['external-port/index']); ?>" class="list-group-item <?= $activeMenuItem === 'external-port' ? 'active' : '' ?>">Зовнішні роз'єми</a>
                    <a href="<?= Url::to(['motherboard/index']); ?>" class="list-group-item <?= $activeMenuItem === 'motherboard' ? 'active' : '' ?>">Материнські плати</a>
                </div>
            </div>
            <div class="col-md-9">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Yosyp Mykhailiv <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
