<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use app\components\{
    AppException,
    prices\DummyPrices,
    AppErrors
};

class BasketController extends Controller
{

    public function actionCalculate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [
            'errorCode' => null,
            'errorText' => null,
            'data' => []
        ];

        try {
            $requestData = Json::decode(Yii::$app->request->rawBody);
            if(empty($requestData['data']['basket'])) {
                throw new AppException(AppErrors::INVALID_REQUEST);
            }

            $basketObj = $requestData['data']['basket'];

            if(!empty($basketObj['items'])) {

                $dummyPrices = new DummyPrices();
                $basketObj['total'] = 0;
                foreach($basketObj['items'] as &$item) {
                    $item = array_map('intval', $item);

                    $basketObj['total'] += $item['price'] = round($item['count'] * $dummyPrices->getPrice($item['id']), 2);
                }
                $response['data']['basket'] = $basketObj;
            }
        } catch(AppException $e) {
            $response['errorCode'] = ($error = $e->getMessage());
            $response['errorText'] = AppErrors::getText($error);

            Yii::$app->response->statusCode = $e->getCode();
        } catch(\Exception $e) {
            $response['errorCode'] = ($error = AppErrors::SYSTEM_FAULT);
            $response['errorText'] = AppErrors::getText($error);

            Yii::$app->response->statusCode = AppErrors::getStatusCode($error);
        }

        return $response;
    }
}