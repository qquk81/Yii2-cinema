<?php

namespace cinema\forms\manage;

use cinema\entities\Order\Order;
use cinema\forms\CompositeForm;

/**
 * @property CustomerForm $customer
 */
class OrderEditForm extends CompositeForm
{
    public $note;

    public function __construct(Order $order, array $config = [])
    {
        $this->note = $order->note;
        $this->customer = new CustomerForm($order);
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['note'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['customer'];
    }
}