<?php

use cinema\helpers\OrderHelper;
use cinema\helpers\PriceHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $order cinema\entities\Order\Order */

$this->title = 'Order ' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $order->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $order->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $order,
                'attributes' => [
                    'id',
                    'created_at:datetime',
                    [
                        'attribute' => 'current_status',
                        'value' => OrderHelper::statusName($order->current_status),
                        'format' => 'raw',
                    ],
                    'cost',
                    'note:ntext',
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom: 0">
                    <thead>
                    <tr>
                        <th class="text-left">Film</th>
                        <th class="text-left">Date</th>
                        <th class="text-left">Raw</th>
                        <th class="text-right">Pos</th>
                        <th class="text-right">Cost</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order->items as $item): ?>
                        <tr>
                            <td class="text-left">
                                <?= Html::encode($item->ticket->seance->film->name) ?>
                            </td>
                            <td class="text-left">
                                <?= Yii::$app->formatter->asDate($item->ticket->seance->datetime, 'long') ?>
                            </td>
                            <td class="text-left">
                                <?= Html::encode($item->ticket->place->raw) ?>
                            </td>
                            <td class="text-right"><?= Html::encode($item->ticket->place->number) ?></td>
                            <td class="text-right"><?= PriceHelper::format($item->price) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
