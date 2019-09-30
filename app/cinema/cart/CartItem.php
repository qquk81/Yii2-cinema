<?php
namespace cinema\cart;

use cinema\entities\Cinema\Ticket;

class CartItem
{
    private $ticket;

    public function __construct(Ticket $ticket)
    {
        if (!$ticket->canBeCheckOut()){
            throw new \DomainException('Ticket is not available');
        }
        $this->ticket = $ticket;
    }

    public function getCost(): int
    {
        return $this->ticket->getPrice();
    }

    public function getId()
    {
        return $this->ticket->id;
    }

    public function getTicket()
    {
        return $this->ticket;
    }

}