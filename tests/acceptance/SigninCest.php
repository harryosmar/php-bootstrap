<?php 

class SigninCest
{
    public function loginSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('#input-username','davert');
        $I->fillField('#input-password','qwerty');
        $I->click('Login');
        $I->see('Hello, davert');
    }
}
