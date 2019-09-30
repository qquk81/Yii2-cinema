<?php

namespace cinema\entities\Cinema;
use yii\db\ActiveRecord;

/**
 * Class Film
 * @package cinema\entities\Cinema
 *
 * @property int $id;
 * @property string $name
 * @property string $description
 *
 */
class Film extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%films}}';
    }
}