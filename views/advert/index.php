<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchAdvert */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adverts';
?>
<div class="advert-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Advert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['style' => 'width: 130px; max-width: 130px; min-width: 130px;'],
            ],
            [
                'label' => 'data',
                'format' => 'html',
                'value' => function($searchModel) {
                    $href = Url::toRoute('advert/view?id=') . $searchModel->id;
                    $text = '<div><strong style="font-size: 20px;"><a href="';
                    $text .= $href;
                    $text .= '"><font color="#000000"> ';
                    $text .= $searchModel->title;
                    $text .= '</font></a></strong></div>';
                    $text .= '<div>' . $searchModel->category->name;
                    $text .= ' » ' . $searchModel->subcategory->name;
                    $text .= '</div>';
                    $text .= '<br>';
                    $text .= '<br>';
                    $text .= '<div>' . $searchModel->region->name . ', ';
                    $text .= $searchModel->city->name . '</div>';
                    $text .= date(Yii::$app->params['dateFormat'], $searchModel->updated_at);

                    return $text;
                }
            ],
            [
                'attribute' => 'user_id',
                'options' => ['style' => 'width: 130px; max-width: 130px; min-width: 130px;'],
            ],
        ],
    ]); ?>

</div>
