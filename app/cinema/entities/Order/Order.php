<?php
namespace cinema\entities\Order;

use cinema\entities\Order\CustomerData;
use cinema\entities\Order\OrderItem;
use cinema\entities\Order\Status;
use cinema\entities\User\User;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Order
 * @package cinema\entities\Order
 *
 * @property int $id
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $customer_phone
 * @property int $cost
 * @property int $note
 * @property int $current_status
 * @property int $created_at
 * @property CustomerData $customerData
 *
 * @property OrderItem[] $items
 * @property Status[] $statuses
 *
 */
class Order extends ActiveRecord
{

    public $customerData;
    public $statuses;

    public static function create($userId, CustomerData $customerData, array $items, $cost, $note)
    {
        $order = new static();
        $order->customer_id = $userId;
        $order->customerData = $customerData;
        $order->items = $items;
        $order->cost = $cost;
        $order->note = $note;
        $order->created_at = date("Y-m-d H:i:s");
        $order->addStatus(Status::NEW);
        return $order;
    }

    public function edit(CustomerData $customerData, $note): void
    {
        $this->customerData = $customerData;
        $this->note = $note;
    }

    public function canBePaid(): bool
    {
        return $this->isNew();
    }

    public function isNew(): bool
    {
        return $this->current_status == Status::NEW;
    }

    public function isPaid(): bool
    {
        return $this->current_status == Status::PAID;
    }

    public function addStatus($value): void
    {
        $this->statuses[] = new Status($value, time());
        $this->current_status = $value;
    }

    public function getUser()
    {
        return $this->hasMany(User::class, ['id' => 'user_id']);
    }


    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['items'],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterFind(): void
    {
        $this->statuses = array_map(function ($row) {
            return new Status(
                $row['value'],
                $row['created_at']
            );
        }, Json::decode($this->getAttribute('statuses_json')));

        $this->customerData = new CustomerData(
            $this->getAttribute('customer_phone'),
            $this->getAttribute('customer_name')
        );

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('statuses_json', Json::encode(array_map(function (Status $status) {
            return [
                'value' => $status->value,
                'created_at' => $status->created_at,
            ];
        }, $this->statuses)));

        $this->setAttribute('customer_phone', $this->customerData->phone);
        $this->setAttribute('customer_name', $this->customerData->name);

        return parent::beforeSave($insert);
    }
    public static function tableName()
    {
        return '{{orders}}';
    }

}