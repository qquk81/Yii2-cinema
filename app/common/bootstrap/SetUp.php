<?php

namespace common\bootstrap;

use cinema\cart\Cart;
use cinema\cart\cost\calculator\SimpleCalculator;
use cinema\cart\storage\HybridStorage;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = \Yii::$container;

        $container->setSingleton(Cart::class, function () use ($app) {
            return new Cart(
                new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
                new SimpleCalculator()
            );
        });

    }
}