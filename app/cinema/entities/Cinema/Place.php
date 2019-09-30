<?php

namespace cinema\entities\Cinema;

use yii\db\ActiveRecord;

/**
 * Class Place
 * @package cinema\entities\Cinema
 *
 * @property int $id
 * @property int $hall_id
 * @property int $raw
 * @property int $number
 *
 */
class Place extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%places}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHall() {
        return $this->hasOne(Hall::class, ['id' => 'hall_id']);
    }
}