<?php

namespace api\controllers;

use cinema\cart\Cart;
use cinema\forms\Cinema\Order\OrderForm;
use cinema\useCases\Cinema\OrderService;
use Yii;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class CheckoutController extends Controller
{
    private $cart;
    private $service;
    //{"grant_type":"password","username" :"admin","password":"111111","client_id":"testclient","client_secret":"testpass"}
    public function __construct($id, $module, OrderService $service, Cart $cart, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cart = $cart;
        $this->service = $service;
    }

    public function verbs(): array
    {
        return [
            'index' => ['POST'],
        ];
    }
//{"grant_type":"password","username" :"admin","password":"111111","client_id":"testclient","client_secret":"testpass"}
//CustomerForm%5Bphone%5D=83242342342&CustomerForm%5Bname%5D=vasya&OrderForm%5Bnote%5D=privet
    public function actionIndex()
    {
        $form = new OrderForm();

        $form->load(Yii::$app->request->getBodyParams(), '');

        if ($form->validate()) {
            try {
                $order = $this->service->checkout(Yii::$app->user->id, $form);
                $response = Yii::$app->getResponse();
                $response->setStatusCode(204);
                $response->getHeaders()->set('Location', Url::to(['/order/view', 'id' => $order->id], true));
                return [];
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }
        }

        return $form;
    }
}