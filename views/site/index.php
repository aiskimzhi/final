<?php

use yii\bootstrap\Modal;

$this->title = 'Site/Index';
?>

<form action="" method="get" style="padding-top: 100px;">
    <input type="hidden" name="_csrf" value="<?= $this->title ?>">
    <input type="text" name="name">
    <input type="submit" name="submit">
</form>

<?php
echo '<pre>';
var_dump(Yii::$app->request->get());
echo '</pre>';


Modal::begin([
    'size' => 'modal-my',
    'toggleButton' => [
        'label' => 'hello',
    ],
    'header' => 'Picture',
    'footer' => '<a>Hello world</a>',
    'footerOptions' => ['class' => 'btn btn-warning']
]);

echo 'My text inside';

Modal::end(); ?>
