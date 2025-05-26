<?php

class HomeCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->wantTo('Проверить работу главной страницы');
        $I->amOnPage('/');
        // $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->see('Главная страница');
    }
}
