<?php

use Perfumer\Helper\Text;

class DocumentInvalidCest
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

        // без collection
        $I->haveHttpHeader('Api-Secret', \Tests\api\Vars::$client_secret);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'event' => $event,
            'uuid' => $uuid,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);

        // без event
        $I->haveHttpHeader('Api-Secret', \Tests\api\Vars::$client_secret);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'collection' => \Tests\api\Vars::$collection_name,
            'uuid' => $uuid,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);

        // без uuid
        $I->haveHttpHeader('Api-Secret', \Tests\api\Vars::$client_secret);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'collection' => \Tests\api\Vars::$collection_name,
            'event' => $event,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);

        // сохраняем c отсутствующей data
        $I->haveHttpHeader('Api-Secret', \Tests\api\Vars::$client_secret);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/document', [
            'collection' => \Tests\api\Vars::$collection_name,
            'uuid' => $uuid,
            'event' => $event,
            'webhook' => $webhook,
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
                ]
            ]
        ]);
    }
}
