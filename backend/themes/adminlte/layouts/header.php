<?php
use yii\helpers\Html;
use backend\models\Profile;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<script type="text/javascript">
    function clock() {
        var d = new Date();
        var month_num = d.getMonth();
        var day = d.getDate();
        var hours = d.getHours();
        var minutes = d.getMinutes();
        var seconds = d.getSeconds();

        month = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];

        if (day <= 9) day = "0" + day;
        if (hours <= 9) hours = "0" + hours;
        if (minutes <= 9) minutes = "0" + minutes;
        if (seconds <= 9) seconds = "0" + seconds;

        date_time = "<b>" + hours + ":" + minutes + ":" + seconds + "</b><br>" + day + " " + month[month_num] + " " + d.getFullYear() + " г.";
        time = hours + ":" + minutes;

        document.getElementById("doc_date_time").innerHTML = date_time;
        document.getElementById("doc_time").innerHTML = time;

        setTimeout("clock()", 1000);
    }
</script>



<header class="main-header">

    <?= Html::a('<span class="logo-mini">' . Html::img("/admin/images/common/logo.png", ["title" => "АС ОИН", "alt" => "АС"]) . '</span><span class="logo-lg" style="font-weight: bold">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown messages-menu">

                    <?php
                    $sql = "SELECT * FROM asoin_profile WHERE DATE_FORMAT(FROM_UNIXTIME(date_birth),'%d-%m') IN (DATE_FORMAT(NOW(),'%d-%m'), DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 DAY),'%d-%m'), DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 DAY),'%d-%m'))";
                    $birthdays = \backend\models\Profile::findbysql($sql);
                    $birthdaysCount = $birthdays->count();
                    $today=time();
                    ?>

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-birthday-cake" title="Уведомления о днях рождениях личного состава"></i>
                        <?php echo $birthdaysCount ? '<span class="label label-success">' . $birthdaysCount . '</span>' : '' ?>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="header">
                            <?php echo $birthdaysCount ? $birthdaysCount . ' именинник' : 'Именинников нет!' ?>
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach ($birthdays->all() as $birthday) { ?>
                                    <li>
                                        <a href="<?= '/admin/profile/view?id=' . $birthday->id_user ?>" data-pjax="0">
                                            <div class="pull-left">
                                                <img
                                                    src="/admin/<?php echo empty($birthday->avatar) ? 'images/users/ava.jpg' : $birthday->avatar; ?>"
                                                    class="img-circle" title="<?= $birthday->user->username ?>"
                                                    alt="<?= $birthday->user->username ?>"/>
                                            </div>
                                            <h4>
                                                <?= empty($birthday->name) && empty($birthday->surname) ? $birthday->user->username : $birthday->name . ' ' . $birthday->surname ?>
                                            </h4>
                                            <p>
                                                <?php
                                                    if(date('d-m',$today)==date('d-m',$birthday->date_birth)) echo 'День рождения сегодня';
                                                    elseif(date('d-m',$today+24*60*60)==date('d-m',$birthday->date_birth)) echo 'День рождения завтра';
                                                    else echo 'День рождения прошло';
                                                ?>

                                                <?=' - '.date('d-m-Y',$birthday->date_birth)?>
                                            </p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <!--                        <li class="footer"><a href="#">See All Messages</a></li>-->
                    </ul>
                </li>

                <!--
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                                 alt="User Image"/>
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                -->

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may
                                        not fit into the page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>


                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img
                            src="/admin/<?php echo empty(Yii::$app->user->identity->profile->avatar) ? 'images/users/ava.jpg' : Yii::$app->user->identity->profile->avatar; ?>"
                            class="user-image" title="<?= Yii::$app->user->identity->username ?>"
                            alt="<?= Yii::$app->user->identity->username ?>"/>
                        <span class="hidden-xs">
                            <?php
                            if (empty(Yii::$app->user->identity->profile->name) and empty(Yii::$app->user->identity->profile->surname)) echo Yii::$app->user->identity->username;
                            else echo Yii::$app->user->identity->profile->name . ' ' . Yii::$app->user->identity->profile->surname;
                            ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?= \yii\helpers\Html::a(\yii\helpers\Html::img(empty(Yii::$app->user->identity->profile->avatar) ? '/admin/images/users/ava.jpg' : '/admin/' . Yii::$app->user->identity->profile->avatar, ['class' => 'img-circle', 'title' => Yii::$app->user->identity->username, 'alt' => Yii::$app->user->identity->username]), ['/profile/my'], ['data-pjax' => 0]) ?>
                            <p class="p-color-white">
                                <?= \yii\helpers\Html::a(empty(Yii::$app->user->identity->profile->name) && empty(Yii::$app->user->identity->profile->surname) ? Yii::$app->user->identity->username : Yii::$app->user->identity->profile->name . ' ' . Yii::$app->user->identity->profile->surname, ['/profile/my'], ['data-pjax' => 0]) ?>
                                <br>
                                <?php echo empty(Yii::$app->user->identity->profile->position) ? 'Сотрудник МЧС России' : Yii::$app->user->identity->profile->position; ?>
                                <!--                                <small>Member since Nov. 2012</small>-->
                            </p>
                        </li>
                        <!--                         Menu Body-->
                        <li class="user-body">
                            <div class="col-xs-12 text-center">
                                <?= Html::a('Личный кабинет', ['/profile/my'], ['class' => 'btn btn-default btn-flat', 'data-pjax' => 0]) ?>
                            </div>
                        </li>
                        <!--                         Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Backup БД</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выход',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>





                <li class="dropdown messages-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<!--                        <i class="fa fa-hourglass-half" title="Часы"></i>-->
<!--                        &nbsp;-->
<!--                        <span id="doc_time"></span>-->

<!--                        <i class="fa fa-hourglass-half" title="Часы"></i>-->
                        <span id="doc_time"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="header">
                            Точное время
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu" style="padding: 10px 0px 10px 0px; font-size: 16px;">
                                <li><div id="doc_date_time" style="text-align: center"></div></li>
                                <script type="text/javascript">clock();</script>
                            </ul>
                        </li>
                        <!--                        <li class="footer"><a href="#">See All Messages</a></li>-->
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
<!--                                <li>-->
<!--                                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
<!--                                </li>-->
                <li class="dropdown messages-menu">
                    <?= Html::a(
                        '<i class="fa fa-power-off" title="Выход"></i>',
                        ['/site/logout'],
                        ['data-method' => 'post', 'class' => 'dropdown-toggle']
                    ) ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
