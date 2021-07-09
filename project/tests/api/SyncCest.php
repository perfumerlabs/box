<?php

use Perfumer\Helper\Text;

class SyncCest
{
    public function _before(\ApiTester $I)
    {
    }


    /**
     * тест синхронной коллекции
     *
     * @depends ClientCest:create
     */
    public function create(\ApiTester $I)
    {
        $name = strtolower(Text::generateString());
        $type = 'sync';
        $handler = 'http://127.0.0.1/mock';

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

        \Tests\api\Vars::$sync_collection_id = $collection_id;
        \Tests\api\Vars::$sync_collection_name = $name;

        // добавляем клиенту роль
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/access', [
            'collection' => \Tests\api\Vars::$sync_collection_id,
            'client' => \Tests\api\Vars::$client_id,
            'level' => 'write',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();

        // пушим документ в  коллекцию
        $uuid = Text::generateString();
        $event = Text::generateString();
        $data = ['foo' => 'bar'];

        $I->haveHttpHeader('Api-Secret', \Tests\api\Vars::$client_secret);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'collection' => \Tests\api\Vars::$sync_collection_name,
            'uuid' => $uuid,
            'event' => $event,
            'data' => $data,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'document' => [
                    'collection' => \Tests\api\Vars::$sync_collection_name,
                    'uuid' => $uuid,
                    'event' => $event,
                    'data' => $data,
                ],
                'response' => [
                    'status_code' => 201,
                    'body' => '9bb58f26192e4ba00f01e2e7b136bbd8',
                ]
            ]
        ]);
    }
}
