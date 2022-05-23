<?php

namespace app\components\prices;

interface Prices
{
    public function getPrice(int $id): float;
}