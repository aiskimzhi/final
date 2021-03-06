<?php

use yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $pictures app\models\Pictures */
/* @var $trash */
/* @var $buttons[] */
/* @var $model app\models\Advert */
?>

<div class="gallery">
    <?php for ($i = 0; $i < $pictures->imageAmount($model->id); $i++) : ?>
    <div class="border">
        <div>
            <form action="" method="post" id="trash">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <?php $span = '<span class="glyphicon glyphicon-trash trash"></span>'; ?>
                <?= Html::submitButton($span, [
                    'class' => 'del', 'name' => 'delete_pic', 'value' => 'delete'
                ]) ?>
            </form>
        </div>

        <?php Modal::begin([
            'size' => 'my-modal',
            'toggleButton' => [
                'label' => '',
                'style' => 'background: url(' . $pictures->imgList(Yii::$app->request->get('id'))[$i] . ') no-repeat 50%; background-size: cover;',
                'class' => 'toggle-button',
                'onclick' => 'carouselOpen(' . $i . ')',
            ],
        ]);

        $items = $pictures->carouselItems($i, Yii::$app->request->get('id'));
        echo Carousel::widget([
            'id' => 'car' . $i,
            'items' => $items,
            'options' => [
                'class' => 'modal-carousel',
                'data-interval' => 'false',
            ],
        ]); ?>

        <div class="button-mod">
            <?= Html::button('Set as the main picture', [
                'class' => 'btn btn-primary btn-modal',
                'id' => 'av_' . $i,
                'onmouseover' => 'getImage(' . $i . ')',
                'onclick' => 'setAvatar(' . $model->id . ',' . $i . ')',
            ]) ?>
            <form action="" method="post" id="del-modal">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <?= Html::button('Delete picture', [
                    'class' => 'btn btn-danger btn-modal',
                    'onmouseover' => 'getImage(' . $i . ')',
                    'name' => 'del',
                ]) ?>
                <input type="hidden" name="delete" value="HIDDEN" id="avatar_<?= $i ?>">
            </form>
        </div>


        <?php Modal::end(); ?>
    </div>
<?php endfor; ?>
</div>
