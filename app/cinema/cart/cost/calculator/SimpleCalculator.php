<?php

namespace cinema\cart\cost\calculator;

use cinema\cart\CartItem;
use cinema\cart\cost\Cost;

class SimpleCalculator implements CalculatorInterface
{

    public function getCost(array $items): Cost
    {
        $cost = 0;
        /** @var CartItem $item */
        foreach ($items as $item) {
            $cost += $item->getCost();
        }

        return new Cost($cost);
    }
}