<?php

namespace api\controllers;

use cinema\repositories\cinema\TicketRepository;
use cinema\useCases\Cinema\CartService;
use cinema\cart\CartItem;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use Yii;
use yii\web\NotFoundHttpException;

class CartController extends Controller
{

    private $service;
    private $tickets;

    public function __construct($id, $module, CartService $service, TicketRepository $tickets, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->tickets = $tickets;
    }

    public function verbs(): array
    {
        return [
                'index' => ['GET'],
                'add' => ['POST'],
                'delete' => ['DELETE'],
                'clear' => ['DELETE'],
            ];
    }

    /**
     * @SWG\Get(
     *     path="/cart",
     *     tags={"Cart"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(ref="#/definitions/Cart"),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function actionIndex(): array
    {
        $cart = $this->service->getCart();
        return [
            'amount' => $cart->getAmount(),
            'cost' => $cart->getCost()->getValue(),
            'items' => array_map(function (CartItem $item) {
                $ticket = $item->getTicket();
                return [
                    'id' => $item->getId(),
                    'cost' => $item->getCost(),
                    'ticket' => [
                        'id' => $ticket->id,
                        'film' => $ticket->seance->film->name,
                        'date' => $ticket->seance->datetime,
                        'raw' => $ticket->place->raw,
                        'number' => $ticket->place->number,
                        '_links' => [
                            'film' => ['href' => Url::to(['/films', 'id' => $ticket->seance->film->id], true)],
                            ],
                        ],
                    ];
        }, $cart->getItems()),
            '_links' => ['checkout' => ['href' => Url::to(['/checkout/index'], true)],],];
    }


    /**
     * @SWG\Post(
     *     path="/cart/{ticketId}",
     *     tags={"Cart"},
     *     @SWG\Parameter(name="ticketId", in="path", required=true, type="integer"),
     *     @SWG\Response(
     *         response=201,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     *
     * @param $id
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionAdd($id)
    {
        if (!$ticket = $this->tickets->find($id)) {
            throw new NotFoundHttpException('Ticket is not available');
        }
        try {
            $this->service->add($id);
            Yii::$app->getResponse()->setStatusCode(201);
            return [];
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), null, $e);
        }
    }

    /**
     * @SWG\Delete(
     *     path="/cart/{id}",
     *     tags={"Cart"},
     *     @SWG\Parameter(name="id", in="path", required=true, type="string"),
     *     @SWG\Response(
     *         response=204,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     * @param $id
     * @throws BadRequestHttpException
     */
    public function actionDelete($id): void
    {
        try {
            $this->service->remove($id);
            Yii::$app->getResponse()->setStatusCode(204);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), null, $e);
        }
    }

    /**
     * @SWG\Delete(
     *     path="/cart",
     *     tags={"Cart"},
     *     @SWG\Response(
     *         response=204,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     * @throws BadRequestHttpException
     */
    public function actionClear(): void
    {
        try {
            $this->service->clear();
            Yii::$app->getResponse()->setStatusCode(204);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), null, $e);
        }
    }
}


/**
 * @SWG\Definition(
 *     definition="Cart",
 *     type="object",
 *     @SWG\Property(property="amount", type="integer"),
 *     @SWG\Property(property="cost", type="integer"),
 *     @SWG\Property(property="items", type="array", @SWG\Items(
 *         type="object",
 *         @SWG\Property(property="id", type="string"),
 *         @SWG\Property(property="cost", type="integer"),
 *         @SWG\Property(property="ticket", type="object",
 *             @SWG\Property(property="id", type="integer"),
 *             @SWG\Property(property="film", type="string"),
 *             @SWG\Property(property="date", type="string"),
 *             @SWG\Property(property="raw", type="string"),
 *             @SWG\Property(property="number", type="string"),
 *             @SWG\Property(property="_links", type="object",
 *                 @SWG\Property(property="film", type="object", @SWG\Property(property="href", type="string")),
 *             )
 *         ),
 *     )),
 *     @SWG\Property(property="_links", type="object",
 *         @SWG\Property(property="checkout", type="object", @SWG\Property(property="href", type="string")),
 *     )
 * )
 */