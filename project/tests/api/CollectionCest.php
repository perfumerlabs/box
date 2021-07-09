<?php

use Perfumer\Helper\Text;

class CollectionCest
{
    public function _before(\ApiTester $I)
    {
    }

    // tests
    public function create(\ApiTester $I)
    {
        $name = strtolower(Text::generateString());
        $type = 'storage';
        $handler = Text::generateString();
        $description = Text::generateString();

        // сохраняем c неверным заголовком
        $I->haveHttpHeader('Api-Secret', '2');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/collection', [
            'name' => $name,
            'type' => $type,
            'handler' => $handler,
            'description' => $description,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);

        // сохраняем 1 раз
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/collection', [
            'name' => $name,
            'type' => $type,
            'handler' => $handler,
            'description' => $description,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'collection' => [
                    'name' => $name,
                    'type' => $type,
                    'handler' => $handler,
                    'description' => $description,
                ]
            ]
        ]);

        $response = $I->grabResponse();
        $response = json_decode($response, true);
        $collection_id = $response['content']['collection']['id'];

        \Tests\api\Vars::$collection_id = $collection_id;
        \Tests\api\Vars::$collection_name = $name;

        // сохраняем 2 раз с тем же name
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/collection', [
            'name' => $name,
            'type' => $type,
            'handler' => $handler,
            'description' => $description,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);

        // получаем коллекцию
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/collection', [
            'id' => $collection_id,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        // обновляем коллекцию
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPatch('/collection', [
            'id' => $collection_id,
            'name' => $name . 222,
            'handler' => $handler . 111,
            'description' => $description . 111,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'collection' => [
                    'id' => $collection_id,
                    'name' => $name, // name нельзя обновить
                    'handler' => $handler . 111,
                    'description' => $description . 111,
                ]
            ]
        ]);

        // проверим коллекцию коллекций
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/collections');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
