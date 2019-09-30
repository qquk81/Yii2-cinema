<?php
namespace cinema\useCases\Cinema;
use cinema\cart\Cart;
use cinema\cart\CartItem;
use cinema\entities\Cinema\Ticket;
use cinema\entities\Order\Status;
use cinema\repositories\cinema\TicketRepository;
use cinema\services\TransactionManager;

class CartService
{

    private $cart;
    /**
     * @var TicketRepository
     */
    private $tickets;

    private $transactionManager;


    public function __construct(Cart $cart, TicketRepository $tickets, TransactionManager $transactionManager)
    {
        $this->cart = $cart;
        $this->tickets = $tickets;
        $this->transactionManager = $transactionManager;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function add($id)
    {
        $ticket = $this->tickets->get($id);
        $ticket->setStatus(Ticket::STATUS_BOOKED);
        $this->cart->add(new CartItem($ticket));
        $this->tickets->save($ticket);
    }

    public function remove($id): void
    {
        $ticket = $this->tickets->get($id);
        $ticket->setStatus(Ticket::STATUS_NEW);
        $this->cart->remove($id);
        $this->tickets->save($ticket);
    }
////
    public function clear(): void
    {
        $items = $this->getCart()->getItems();
        $this->transactionManager->wrap(function () use ($items) {
            foreach ($items as $item) {
                $ticket = $item->getTicket();
                $ticket->setStatus(Ticket::STATUS_NEW);
                $this->tickets->save($ticket);
            }
            $this->cart->clear();
        });

    }

}