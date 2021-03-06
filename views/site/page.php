<?php

use app\components\SimpleMenu;
use app\models\Categories;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Simple Blog' . '-'.$model->title;
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="index">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12; text-align: center; ">
        <h1><?= Html::encode($this->title) ?></h1><br><br>
        <hr>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (!Yii::$app->user->isGuest) {
            echo " <b>ADMIN AREA: </b>";
            echo Html::a('Posts', ['posts/'], ['class' => 'btn btn-success']);
            echo " ";
            echo Html::a('Menu', ['categories/'], ['class' => 'btn btn-success']);
            echo " ";
            //echo   Html::a('Settings', ['settings/'], ['class' => 'btn btn-success']);
            echo "<br><br><hr>";
        }
        ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><?= SimpleMenu::widget() ?></div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

        <?php


        echo "<div>";
        echo '<h3>' . Html::a($model->title, ["../?page=" . $model->id]) . '</h3>';
        echo "</div>";
        echo " created: " . $model->created_date;
        $localquery = Categories::find()->Where('id = :id', [':id' => $model->category])->one();
        if ($model->category == 0) {
            echo " category: " . "-non-";
        } else {
            echo " category: " . Html::a($localquery->title, ["../?cat=" . $localquery->alias]);
        }
        echo "<hr>";
        echo "<div>";
        echo $model->text;
        echo "</div>";


        ?>
    </div>


</div>
