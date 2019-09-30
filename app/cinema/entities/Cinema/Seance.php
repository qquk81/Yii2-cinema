<?php

namespace cinema\entities\Cinema;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Seance
 * @package cinema\entities\Cinema
 *
 * @property int $id
 * @property int $hall_id
 * @property int $film_id
 * @property string $datetime
 *
 */
class Seance extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%seances}}';
    }

    public function getHall(): ActiveQuery
    {
        return $this->hasOne(Hall::class, ['id' => 'hall_id']);
    }

    public function getFilm(): ActiveQuery
    {
        return $this->hasOne(Film::class, ['id' => 'film_id']);
    }

}