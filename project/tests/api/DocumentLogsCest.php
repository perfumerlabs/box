<?php

class DocumentLogsCest
{
    public function _before(\ApiTester $I)
    {
    }

    /**
     * @depends DocumentCest:create
     */
    public function create(\ApiTester $I)
    {
        // проверим коллекцию логов
        $I->haveHttpHeader('Api-Secret', '1');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/document/logs');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
