<?php
namespace cinema\forms\Cinema;

use cinema\entities\Cinema\Ticket;
use yii\base\Model;

class AddToCartForm extends Model
{

    public $id;

    private $_ticket;

    public function __construct(Ticket $ticket, $config = [])
    {
        $this->_ticket = $ticket;
        parent::__construct($config);
    }


}