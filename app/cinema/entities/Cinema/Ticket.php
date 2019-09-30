<?php
namespace cinema\entities\Cinema;

use cinema\entities\queries\TicketQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Ticket
 * @package cinema\entities\Cinema
 *
 * @property int $id;
 * @property string $created_at
 * @property int $seance_id
 * @property int $place_id
 * @property int $status
 *
 */
class Ticket extends ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_BOOKED = 1;
    const STATUS_SOLD = 10;

    public static function create(Seance $seance, Place $place)
    {
        $ticket =  new static();
        $ticket->seance_id = $seance->id;
        $ticket->place_id = $place->id;
        $ticket->status = static::STATUS_NEW;
        return $ticket;
    }

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isBooked()
    {
        return $this->status === self::STATUS_BOOKED;
    }

    public function canBeCheckOut(): bool
    {
        return $this->isNew() || $this->isBooked();
    }

    public function checkOut()
    {
        if (!$this->canBeCheckOut()) {
            throw new \DomainException("Ticket can not be checkout");
        }
        $this->status = static::STATUS_SOLD;
    }

    public function getPrice()
    {
        /** @var Price $price */
        $price = Price::find()
            ->alias('pr')
            ->leftJoin('seances s', 'pr.seance_id = s.id')
            ->leftJoin('sectors sec', 'pr.sector_id = sec.id')
            ->leftJoin('places p', 's.hall_id = p.hall_id')
            ->andWhere('p.id = :place_id', ['place_id' => $this->place_id])
            ->andWhere('p.raw >= sec.start_raw')
            ->andWhere('p.raw <= sec.end_raw')
            ->andWhere('s.id = :seance_id', ['seance_id' => $this->seance_id])
            ->one();
        if(!$price) {
            throw new \DomainException("Price not set");
        }
        return $price->price;
    }

    public function setStatus($value): void
    {
        $this->status = $value;
    }

    public static function tableName()
    {
        return '{{%tickets}}';
    }

    public function getSeance()
    {
        return $this->hasOne(Seance::class, ['id' => 'seance_id']);
    }

    public function getPlace()
    {
        return $this->hasOne(Place::class, ['id' => 'place_id']);
    }

}