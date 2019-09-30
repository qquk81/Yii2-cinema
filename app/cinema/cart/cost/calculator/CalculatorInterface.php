<?php
namespace cinema\cart\cost\calculator;

use cinema\cart\cost\Cost;

interface CalculatorInterface
{

    public function getCost(array $items): Cost;

}