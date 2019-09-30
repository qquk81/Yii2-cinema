<?php

namespace cinema\entities\Cinema;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Price
 * @package cinema\entities\Cinema
 *
 * @property int $id;
 * @property int $seance_id
 * @property int $sector_id
 * @property int $price;
 *
 */
class Price extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%prices}}';
    }

    public function getSeance(): ActiveQuery
    {
        return $this->hasOne(Seance::class, ['id' => 'seance_id']);
    }

    public function getSector(): ActiveQuery
    {
        return $this->hasOne(Sector::class, ['id' => 'sector_id']);
    }

}