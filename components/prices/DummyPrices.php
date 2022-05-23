<?php
namespace app\components\prices;

use app\components\AppException;
use app\components\AppErrors;
use dummy\Prices as DummyPricesProvider;
use Yii;
use yii\caching\CacheInterface;

class DummyPrices implements Prices
{
    private DummyPricesProvider $provider;

    protected ?CacheInterface $cache;

    public function __construct()
    {
        $this->cache = Yii::$app->pcache ?? null;
        $this->provider = new DummyPricesProvider();
    }

    /**
     * @param int $id
     * @return float
     * @throws AppException
     */
    public function getPrice(int $id): float
    {
        try {
            if($this->cache) {

                $price = $this->cache->get($id);
                if($price === false) {
                    $price = $this->provider->getPrice($id);
                    $this->cache->set($id, $price);
                }
            } else {
                $price = $this->provider->getPrice($id);
            }

            return $price;

        } catch(\Exception $ex) {
            throw new AppException(AppErrors::SYSTEM_FAULT);
        }
    }
}