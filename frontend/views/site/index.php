<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Стартовая страница | '.Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron" style="padding: 10px 0px 0px 0px;">
        <div class="row">
            <div class="col-lg-3">
                <div class="col-lg-4"></div>
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <?=Html::img('@web/images/common/logoIndex.png', ['style'=>'text-align:right','align'=>'center'])?>
                </div>
            </div>
            <div class="col-lg-9">
                <h2 style="word-break: break-all"><b>Автоматизированная система <br> организации информирования населения</b></h2>
            </div>
        </div>
    </div>

    <hr style="margin-bottom: 40px">

<!--    <hr>-->

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6" style="padding: 0px;">
                <?=Html::img('@web/images/common/certificate.jpg', ['style'=>'width: 100%'])?>
            </div>
            <div class="col-lg-6" style="margin-bottom: 30px">
                <br>
                <p class="p-index">Одной из основных функций МЧС России в соответствии с Указом Президента РФ является информирование населения через СМИ
                    и по иным каналам о прогнозируемых и возникших ЧС, и пожарах, мерах по обеспечению безопасности населения и территорий,
                    приемах и способах защиты, а также пропаганду в области ГО, защиты населения и территорий от ЧС, обеспечения пожарной
                    безопасности и безопасности людей на водных объектах.</p>
                <p class="p-index">
                    Способность оперативно получать, обрабатывать и доводить достоверную информацию до населения становится одним из ключевых
                    факторов для обеспечения безопасности жизнедеятельности населения в процессе предупреждения, возникновения и ликвидации ЧС.
                    От того, каким образом организован процесс информирования населения, как налажена система взаимодействия со СМИ, операторами
                    сотовой связи, системами оповещения, интернет-изданиями и блогосферой во многом зависит эффективность проведения работ по
                    предупреждению возникающих информационных рисков, как в период угрозы возникновения, так и при ликвидации ЧС.</p>
                <br>
                <?=Html::img('@web/images/common/specialist.jpg', ['style'=>'width: 100%'])?>
            </div>
        </div>

    </div>
</div>