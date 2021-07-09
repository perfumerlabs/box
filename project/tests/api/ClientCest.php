<?php

use Perfumer\Helper\Text;

class ClientCest
{
    public function _before(\ApiTester $I)
    {
    }

    // tests
    public function create(\ApiTester $I)
    {
        $name = Text::generateString();
        $description = Text::generateString();
        $secret = Text::generateString();
        $is_admin = false;

        // сохраняем c неверным заголовком
        $I->haveHttpHeader('Api-Secret', '2');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/client', [
            'name' => $name,
            'secret' => $secret,
            'is_admin' => $is_admin,
            'description' => $description,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);

        // сохраняем 1 раз
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/client', [
            'name' => $name,
            'secret' => $secret,
            'is_admin' => $is_admin,
            'description' => $description,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'client' => [
                    'name' => $name,
                    'secret' => $secret,
                    'is_admin' => $is_admin,
                    'description' => $description,
                ]
            ]
        ]);

        $response = $I->grabResponse();
        $response = json_decode($response, true);
        $client_id = $response['content']['client']['id'];

        \Tests\api\Vars::$client_id = $client_id;
        \Tests\api\Vars::$client_secret = $secret;

        // сохраняем 2 раз с тем же secret
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/client', [
            'name' => $name,
            'secret' => $secret,
            'is_admin' => $is_admin,
            'description' => $description,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);

        // получаем
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/client', [
            'id' => $client_id,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'client' => [
                    'id' => $client_id,
                    'name' => $name,
                    'secret' => $secret,
                    'is_admin' => $is_admin,
                    'description' => $description,
                ]
            ]
        ]);

        // обновляем
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPatch('/client', [
            'id' => $client_id,
            'name' => $name . 222,
            'secret' => $secret . 111,
            'description' => $description . 111,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'client' => [
                    'id' => $client_id,
                    'name' => $name, // name нельзя поменять
                    'secret' => $secret . 111,
                    'description' => $description . 111,
                ]
            ]
        ]);

        \Tests\api\Vars::$client_secret = $secret . 111;

        // проверим коллекцию клиентов
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/clients');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
