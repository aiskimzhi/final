<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\components\AlertWidget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="/css/custom.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php $this->beginBody() ?>
<div class="my-wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-my navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        $items = [
            ['label' => 'Login', 'url' => ['/site/login']],
            ['label' => 'Sign Up', 'url' => ['/site/signup']]
        ];
    } else {
        $items = [
            ['label' => 'Adverts', 'url' => ['/adverts']],
            ['label' => 'Create Advert', 'url' => ['/advert/create']],
            ['label' => 'My Account', 'url' => ['/user/account']],
            [
                'label' => 'Logout (' . Yii::$app->user->identity->getFullName() . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right top-menu'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="my-container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= AlertWidget::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
<script src="/js/custom.js" type="text/javascript"></script>
</body>
</html>
<?php $this->endPage() ?>
