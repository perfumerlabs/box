<?php

use Perfumer\Helper\Text;

class ClientDisabledCest
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
        $client_name = Text::generateString();
        $secret = Text::generateString();
        $is_admin = false;

        // сохраняем выключенную клиента
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/client', [
            'name' => $client_name,
            'secret' => $secret,
            'is_admin' => $is_admin,
            'is_disabled' => true,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'client' => [
                    'name' => $client_name,
                    'secret' => $secret,
                    'is_admin' => $is_admin,
                    'is_disabled' => true,
                ]
            ]
        ]);

        $response = $I->grabResponse();
        $response = json_decode($response, true);
        $client_id = $response['content']['client']['id'];

        // создаем коллекцию
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/collection', [
            'name' => $name,
            'type' => $type,
            'handler' => $handler,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'collection' => [
                    'name' => $name,
                    'type' => $type,
                    'handler' => $handler,
                ]
            ]
        ]);

        $response = $I->grabResponse();
        $response = json_decode($response, true);
        $collection_id = $response['content']['collection']['id'];

        // даем права
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/access', [
            'collection' => $collection_id,
            'client' => $client_id,
            'level' => 'write',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();

        // пушим документ
        $uuid = Text::generateString();
        $event = Text::generateString();
        $webhook = Text::generateString();
        $data = ['foo' => 'bar'];

        $I->haveHttpHeader('Api-Secret', $secret);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'collection' => $name,
            'uuid' => $uuid,
            'event' => $event,
            'webhook' => $webhook,
            'data' => $data,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);
    }
}
