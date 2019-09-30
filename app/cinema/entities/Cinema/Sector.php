<?php

namespace cinema\entities\Cinema;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Sector
 * @package cinema\entities\Cinema
 * @property int $id
 * @property int $hall_id
 * @property string $name
 * @property int $start_raw
 * @property int $end_raw
 *
 */
class Sector extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%sectors}}';
    }

    public function getHall(): ActiveQuery
    {
        return $this->hasOne(Hall::class, ['id' => 'hall_id']);
    }

}