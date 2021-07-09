<?php

use Perfumer\Helper\Text;

class AccessCest
{
    public function _before(\ApiTester $I)
    {
    }

    /**
     * @depends ClientCest:create
     * @depends CollectionCest:create
     */
    public function create(\ApiTester $I)
    {
        // сохраняем c неверным заголовком
        $I->haveHttpHeader('Api-Secret', '2');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/access', [
            'collection' => \Tests\api\Vars::$collection_id,
            'client' => \Tests\api\Vars::$client_id,
            'level' => 'read',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);

        $this->createAccess($I, 'read');
        $this->deleteAccess($I);
        $this->createAccess($I, 'write');

        // проверим коллекцию доступов
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/accesses');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }

    private function createAccess($I, $level)
    {
        // сохраняем
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/access', [
            'collection' => \Tests\api\Vars::$collection_id,
            'client' => \Tests\api\Vars::$client_id,
            'level' => $level,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
    }

    private function deleteAccess($I)
    {
        // сохраняем
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/access', [
            'collection' => \Tests\api\Vars::$collection_id,
            'client' => \Tests\api\Vars::$client_id,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
