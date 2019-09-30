<?php
namespace cinema\repositories\cinema;

use cinema\entities\Cinema\Ticket;

class TicketRepository
{
    public function get($id):Ticket
    {
        if (!$ticket = Ticket::findOne($id)) {
            throw new \DomainException("Ticket not found");
        }
        return $ticket;
    }

    public function find($id): ?Ticket
    {
        return Ticket::find()->andWhere(['id' => $id])->andWhere(['status' => Ticket::STATUS_NEW])->one();
    }

    public function save(Ticket $ticket):void
    {
        if(!$ticket->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }
}