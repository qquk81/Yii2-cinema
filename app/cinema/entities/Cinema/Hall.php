<?php

namespace cinema\entities\Cinema;

use yii\db\ActiveRecord;

/**
 * Class Hall
 * @package cinema\entities\Cinema
 *
 * @property int $id
 */
class Hall extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%halls}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Place::class, ['hall_id' => 'id']);
    }
}