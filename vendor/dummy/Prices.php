<?php
namespace dummy;

class Prices
{
    /**
     * @param int $id
     * @return float
     */
    public function getPrice(int $id): float
    {
        return round(rand(100, 1000) / 33.33, 2);
    }
}