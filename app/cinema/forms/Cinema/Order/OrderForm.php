<?php

namespace cinema\forms\Cinema\Order;

use cinema\forms\CompositeForm;

/**
 * @property CustomerForm $customer
 */
class OrderForm extends CompositeForm
{
    public $note;

    public function __construct(array $config = [])
    {
        $this->customer = new CustomerForm();
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