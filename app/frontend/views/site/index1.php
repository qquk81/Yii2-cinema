<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<div class="site-index">
    <div class="body-content">

        <?php $form = ActiveForm::begin() ?>

        <div class="panel panel-default">
            <div class="panel-heading">Customer</div>
            <div class="panel-body">
                <?= $form->field($model->customer, 'phone')->textInput() ?>
                <?= $form->field($model->customer, 'name')->textInput() ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Note</div>
            <div class="panel-body">
                <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Checkout', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
        </div>
            <?= Html::button("but", ['onclick' => 'getFormData()'])?>
        <?php ActiveForm::end() ?>


    </div>
</div>
<script>

function getFormData() {
    var form = document.querySelector('#w0');

    data = Array.from(
        new FormData(form),
        e => e.map(encodeURIComponent).join('=')
    ).join('&')
    console.log(data);
}

</script>
