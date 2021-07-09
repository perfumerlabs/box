<?php

use Perfumer\Helper\Text;

class DocumentCest
{
    public function _before(\ApiTester $I)
    {
    }

    /**
     * @depends AccessCest:create
     */
    public function create(\ApiTester $I)
    {
        $uuid = Text::generateString();
        $event = Text::generateString();
        $webhook = Text::generateString();
        $data = ['foo' => 'bar'];

        // сохраняем c неверным заголовком
        $I->haveHttpHeader('Api-Secret', '2');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'collection' => \Tests\api\Vars::$collection_name,
            'uuid' => $uuid,
            'event' => $event,
            'webhook' => $webhook,
            'data' => $data,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);

        // сохраняем 1 раз
        $I->haveHttpHeader('Api-Secret', \Tests\api\Vars::$client_secret);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'collection' => \Tests\api\Vars::$collection_name,
            'uuid' => $uuid,
            'event' => $event,
            'webhook' => $webhook,
            'data' => $data,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'document' => [
                    'collection' => \Tests\api\Vars::$collection_name,
                    'uuid' => $uuid,
                    'event' => $event,
                    'webhook' => $webhook,
                    'data' => $data,
                ]
            ]
        ]);

        $response = $I->grabResponse();
        $response = json_decode($response, true);
        $document_id = $response['content']['document']['id'];

        \Tests\api\Vars::$document_id = $document_id;

        // получаем
        $I->haveHttpHeader('Api-Secret', \Tests\api\Vars::$client_secret);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/document', [
            'collection' => \Tests\api\Vars::$collection_name,
            'id' => $document_id,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'document' => [
                    'id' => $document_id,
                    'collection' => \Tests\api\Vars::$collection_name,
                    'uuid' => $uuid,
                    'event' => $event,
                    'webhook' => $webhook,
                    'data' => $data,
                ]
            ]
        ]);
    }
}
