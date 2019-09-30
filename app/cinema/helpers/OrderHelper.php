<?php

namespace cinema\helpers;

use cinema\entities\Order\Status;
use yii\helpers\ArrayHelper;

class OrderHelper
{
    public static function statusList(): array
    {
        return [
            Status::NEW => 'New',
            Status::PAID => 'Paid',
            Status::SENT => 'Sent',
            Status::COMPLETED => 'Completed',
            Status::CANCELLED => 'Cancelled',
            Status::CANCELLED_BY_CUSTOMER => 'Cancelled by customer',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

}