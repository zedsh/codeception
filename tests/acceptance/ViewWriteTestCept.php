<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Проверяем доступность главной страницы');
$I->amOnPage('/');
$I->see('Найти');
$I->wantTo('Отправляем форму');
$I->fillField('text', 'test test test');
$I->click('Найти');
$I->wantTo('Видим логотип');
if(method_exists($I,'waitForElement')){
    $I->waitForElement('.logo', 10);
}else{
    $I->see('.logo');
}
