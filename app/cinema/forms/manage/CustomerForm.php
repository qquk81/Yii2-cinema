<?php

namespace cinema\forms\manage;

use cinema\entities\Order\Order;
use yii\base\Model;

class CustomerForm extends Model
{
    public $phone;
    public $name;

    public function __construct(Order $order, array $config = [])
    {
        $this->phone = $order->customerData->phone;
        $this->name = $order->customerData->name;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['phone', 'name'], 'required'],
            [['phone', 'name'], 'string', 'max' => 255],
        ];
    }
}