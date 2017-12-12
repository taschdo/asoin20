<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?=\yii\helpers\Html::a(\yii\helpers\Html::img(empty(Yii::$app->user->identity->profile->avatar) ? '/admin/images/users/ava.jpg' : '/admin/'.Yii::$app->user->identity->profile->avatar,['class'=>'img-circle','title'=>Yii::$app->user->identity->username,'alt'=>Yii::$app->user->identity->username]),['/profile/my'], ['data-pjax' => 0])?>
            </div>
            <div class="pull-left info">
                <p>
                    <?=\yii\helpers\Html::a(empty(Yii::$app->user->identity->profile->name) && empty(Yii::$app->user->identity->profile->surname) ? Yii::$app->user->identity->username : Yii::$app->user->identity->profile->name.' '.Yii::$app->user->identity->profile->surname,['/profile/my'], ['data-pjax' => 0])?>
                </p>
                <?=\yii\helpers\Html::a('<i class="fa fa-circle text-bright-green"></i> Online',['/profile/my'], ['data-pjax' => 0])?>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Поиск..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Меню АС ОИН', 'options' => ['class' => 'header','style'=>'']],
//                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'Вход', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Главная', 'icon' => 'fa fa-home text-aqua', 'url' => ['/main']],
                    ['label' => 'Мониторинг СМИ', 'icon' => 'fa fa-desktop text-lime', 'url' => ['/monitoring-media'], 'visible' => Yii::$app->user->can('monitoring-media/index') ? true : false,],
                    ['label' => 'ОКСИОН', 'icon' => 'fa fa-globe text-aqua', 'url' => ['/oksion'], 'visible' => Yii::$app->user->can('oksion/index') ? true : false,],
                    ['label' => 'Оперативный блок', 'icon' => 'glyphicon glyphicon-fire text-red', 'url' => ['#'], 'visible' => false],
                    [
                        'label' => 'Повседневный блок',
                        'icon' => 'fa fa-briefcase text-orange',
                        'url' => '#',
                        'visible' => false,
                        'items' => [
                            ['label' => 'ТВ каналы', 'icon' => 'fa fa-circle-o text-orange', 'url' => '#',],
                            ['label' => 'Бегущие строки', 'icon' => 'fa fa-circle-o text-orange', 'url' => '#',],
                            ['label' => 'Сайт МЧС России', 'icon' => 'fa fa-circle-o text-orange', 'url' => '#',],
                            ['label' => 'Соц. сети', 'icon' => 'fa fa-circle-o text-orange', 'url' => '#',],
                            ['label' => 'Негатив', 'icon' => 'fa fa-circle-o text-orange', 'url' => '#',],
                            ['label' => 'ЕТД', 'icon' => 'fa fa-circle-o text-orange', 'url' => '#',],
                        ],
                    ],
                    ['label' => 'Медиапланирование', 'icon' => 'fa fa-calendar text-teal', 'url' => ['#'], 'visible' => false],
                    [
                        'label' => 'Учебный блок',
                        'icon' => 'glyphicon glyphicon-education text-lime',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('study/index') ? true : false,
                        'items' => [
//                            ['label' => 'Тестирование', 'icon' => 'fa fa-circle-o text-lime', 'url' => '#',],
                            ['label' => 'Обучение АС ОИН', 'icon' => 'fa fa-circle-o text-lime', 'visible' => Yii::$app->user->can('study/index') ? true : false, 'url' => '/admin/study',],
                        ],
                    ],
                    [
                        'label' => 'Блок анализов',
                        'icon' => 'fa fa-file-text text-teal',
                        'url' => '#',
                        'visible' => false,
                        'items' => [
                            ['label' => 'Анализ работы ТО', 'icon' => 'fa fa-circle-o text-teal', 'url' => '#',],
                            ['label' => 'Анализ ИСОС', 'icon' => 'fa fa-circle-o text-teal', 'url' => '#',],
                            ['label' => 'Анализ УОИН', 'icon' => 'fa fa-circle-o text-teal', 'url' => '#',],
                            ['label' => 'Анализ ЕТД', 'icon' => 'fa fa-circle-o text-teal', 'url' => '#',],
                        ],
                    ],
                    [
                        'label' => 'Справочник',
                        'icon' => 'fa fa-book text-aqua',
                        'url' => '#',
                        'visible' => (!Yii::$app->user->can('subject/index') and !Yii::$app->user->can('base-media/index') and !Yii::$app->user->can('profile/index')) ? false : true,
                        'items' => [
                            ['label' => 'Пресс-службы ТО', 'icon' => 'fa fa-circle-o text-lime', 'url' => '/admin/subject', 'visible' => Yii::$app->user->can('subject/index') ? true : false,],
                            ['label' => 'База СМИ', 'icon' => 'fa fa-circle-o text-lime', 'url' => '/admin/base-media', 'visible' => Yii::$app->user->can('base-media/index') ? true : false,],
//                            ['label' => 'База знаний', 'icon' => 'fa fa-circle-o text-lime', 'url' => '#',],
                            ['label' => 'Пользователи', 'icon' => 'fa fa-group text-lime', 'url' => '/admin/profile', 'visible' => Yii::$app->user->can('profile/index') ? true : false,],
                        ],
                    ],
//                    if(Yii::$app->user->can('developer')) {
                        [
                            'label' => 'Управление правами',
                            'icon' => 'fa fa-lock text-red',
                            'url' => '#',
                            'visible' => Yii::$app->user->can('developer') ? true : false,
                            'items' => [
                                ['label' => 'Управление ролями', 'icon' => 'fa fa-circle-o text-lime', 'url' => '/admin/permit/access/role',],
                                ['label' => 'Управление правами доступа', 'icon' => 'fa fa-circle-o text-lime', 'url' => '/admin/permit/access/permission',],
                            ],
                        ],
//                    }
                ],
            ]
        ) ?>

    </section>

</aside>