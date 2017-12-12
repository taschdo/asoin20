<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
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
        'brandLabel' => Html::img('@web/images/common/logo.png', ['style' => 'margin:-10px 0px 0px 0px;padding:0px;']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
//        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'О системе', 'url' => ['/site/about']],
        ['label' => 'Контакты', 'url' => ['/site/contact']],
        ['label' => '<i class="fa fa-facebook" aria-hidden="true"></i>', 'url' => null, 'linkOptions' => ['href' => 'https://www.facebook.com/MchsRussia', 'target' => '_blank']],
        ['label' => '<i class="fa fa-twitter" aria-hidden="true"></i>', 'url' => null, 'linkOptions' => ['href' => 'https://twitter.com/MchsRussia', 'target' => '_blank']],
        ['label' => '<i class="fa fa-vk" aria-hidden="true"></i>', 'url' => null, 'linkOptions' => ['href' => 'https://vk.com/mchsgov', 'target' => '_blank']],
        ['label' => '<i class="fa fa-pencil" aria-hidden="true"></i>', 'url' => null, 'linkOptions' => ['href' => 'http://mchsgov.livejournal.com/', 'target' => '_blank']],
        ['label' => '<i class="fa fa-youtube-play" aria-hidden="true"></i>', 'url' => null, 'linkOptions' => ['href' => 'https://www.youtube.com/user/MchsRussia', 'target' => '_blank']],
        ['label' => '<i class="fa fa-instagram" aria-hidden="true"></i>', 'url' => null, 'linkOptions' => ['href' => 'https://www.instagram.com/mchs112/', 'target' => '_blank']],
        ['label' => '<i class="fa fa-odnoklassniki" aria-hidden="true"></i>', 'url' => null, 'linkOptions' => ['href' => 'https://ok.ru/mchsgov', 'target' => '_blank']],
    ];
    if (Yii::$app->user->isGuest) {
//        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['./../admin/main']];
    } else {
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
//            . '</li>';

        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-user"></span>', 'items' => [
            ['label' => '<span class="glyphicon glyphicon-home"></span> &#8195; Личный кабинет ('.Yii::$app->user->identity->username.')', 'url' => ['/profile/default/index']],
//            ['label' => '<span class="glyphicon glyphicon-envelope"></span> &#8195; Сообщения &#8194; ' . ($messageCount ? '<span class="badge">'.$messageCount.'</span>' : '') , 'url' => ['/profile/message']],
            ['label' => '<span class="glyphicon glyphicon-wrench"></span> &#8195; Настройки', 'url' => ['/profile/default/settings']],
            ['label' => '<span class="glyphicon glyphicon-off"></span> &#8195; Выход', 'url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
        ]];

    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>

        <p class="pull-right">
            <i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:8-495-983-66-03">8-495-983-66-03</a>
            &emsp;
            <i class="fa fa-envelope" aria-hidden="true"></i> <?= Html::mailto('asoin@mchs.gov.ru') ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
