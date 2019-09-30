<?php

namespace cinema\useCases\Cinema;
use cinema\cart\Cart;
use cinema\cart\CartItem;
use cinema\entities\Order\CustomerData;
use cinema\entities\Order\Order;
use cinema\entities\Order\OrderItem;
use cinema\forms\Cinema\Order\OrderForm;
use cinema\repositories\cinema\TicketRepository;
use cinema\repositories\OrderRepository;
use cinema\repositories\UserRepository;
use cinema\services\TransactionManager;

class OrderService
{
    private $tickets;
    private $orders;
    private $users;
    private $transactionManager;
    private $cart;

    public function __construct(
        TicketRepository $tickets,
        OrderRepository $orders,
        UserRepository $users,
        TransactionManager $transactionManager,
        Cart $cart
    )
    {
        $this->tickets = $tickets;
        $this->orders = $orders;
        $this->users = $users;
        $this->transactionManager = $transactionManager;
        $this->cart = $cart;
    }

    public function checkout($userId, OrderForm $form)
    {
        $user = $this->users->get($userId);

        $tickets = [];

        $items = array_map(function (CartItem $item) use (&$tickets) {
            $ticket = $item->getTicket();
            $ticket->checkOut();
            $tickets[] = $ticket;
            return OrderItem::create(
                $ticket
            );
        }, $this->cart->getItems());

        $order = Order::create(
            $user->id,
            new CustomerData(
                $form->customer->phone,
                $form->customer->name
            ),
            $items,
            $this->cart->getCost()->getValue(),
            $form->note
        );

        $this->transactionManager->wrap(function () use ($order, $tickets) {
            $this->orders->save($order);
            foreach ($tickets as $ticket) {
                $this->tickets->save($ticket);
            }
            $this->cart->clear();
        });
        return $order;
    }

}