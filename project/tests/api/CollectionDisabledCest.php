<?php

use Perfumer\Helper\Text;

class CollectionDisabledCest
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

        // сохраняем выключенную коллекцию
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/collection', [
            'name' => $name,
            'type' => $type,
            'handler' => $handler,
            'is_disabled' => true,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => [
                'collection' => [
                    'name' => $name,
                    'type' => $type,
                    'handler' => $handler,
                    'is_disabled' => true,
                ]
            ]
        ]);

        // пушим документ
        $uuid = Text::generateString();
        $event = Text::generateString();
        $webhook = Text::generateString();
        $data = ['foo' => 'bar'];

        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'collection' => $name,
            'uuid' => $uuid,
            'event' => $event,
            'webhook' => $webhook,
            'data' => $data,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
    }
}
