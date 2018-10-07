<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . "/../../web";
require __DIR__ . "/../../web/bitrix/modules/main/include/prolog_before.php";

use Codeception\Util\Locator;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use app\model\Promocodes\PromocodesTable;
use Bitrix\Main\Type\DateTime;
use Creative\Edu\Pipedrive\PipedriveEduHelper;

class EasyEvent
{
    protected $tester;
    const REGISTER = 1;
    const BUY = 2;
    const BUY_PROMO = 3;

    const LANG_RU = 'ru';
    const LANG_EN = 'en';


    public $language_versions = ['en' => '/', 'ru' => '/ru/'];
    public $places_available = ['en' => 'Places available', 'ru' => 'Открыт набор'];
    public $go_to_course = ['en' => 'Sign Up', 'ru' => 'Узнать подробнее'];
    public $accept_agreement = ['en' => '', 'ru' => 'Согласен с условиями'];
    public $form_send_register = ['en' => 'Submit', 'ru' => 'Оставить заявку'];
    public $form_send_buy = ['en' => 'Buy tickets', 'ru' => 'Купить билет'];
    public $form_register_message = ['en' => 'Thank you!', 'ru' => 'Спасибо!'];
    public $cookies_messages = ['en' => 'Accept', 'ru' => 'Принять и закрыть'];
    public $promo = 'test123';
    public $current_event_url;

    public $cost_price;


    public $user_data = [
        'name' => 'test',
        'email' => 'test2',
        'phone' => 'test3',
        'tickets_count' => 3,
        'organization' => 'test34'
    ];

    protected $mode;

    public function __construct($scenario)
    {
        $this->tester = new AcceptanceTester($scenario);
        Loader::includeModule('creative.foundation');
        Loader::includeModule('catalog');
        Loader::includeModule('creative.pipedrive');
        Loader::includeModule('iblock');
        Loader::includeModule('creative.edu');
    }

    public function getSymCode($url)
    {
        if (preg_match('/.*\/(.*)\//', $url, $matches)) {
            return $matches[1];
        }

        return false;
    }

    protected function getCurrentUrl()
    {
        return $this->tester->executeJS('return location.href');
    }


    public function getActiveEvent($event_ids)
    {
        $arSelect = ["*"];
        $arFilter = [
            "IBLOCK_CODE" => 'events',
            'ID' => $event_ids,
            '<=ACTIVE_FROM' => new DateTime(),
            'ACTIVE' => 'Y'
        ];

        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        $element = $res->Fetch();
        //codecept_debug($element);
        return $element;

    }

    public function sendFormOnEventPage($type, $lang)
    {
        $I = $this->tester;
        $I->wantTo('Закрываем сообщение о куках');
        $I->click($this->cookies_messages[$lang]);
        $I->wantTo('Заполняем форму заявки');
        $I->scrollTo("#registration-section");
        $I->fillField('UF_NAME', $this->user_data['name']);
        $I->fillField('UF_EMAIL', $this->user_data['email']);
        $I->fillField('UF_PHONE', $this->user_data['phone']);
        $I->fillField('UF_COMPANY_NAME', $this->user_data['organization']);

        if ($type === self::BUY_PROMO) {
            $I->fillField('UF_PROMOKOD', $this->promo);
        }
        // вместо $I->fillField('UF_AMOUNT_TICKETS', $user_data['tickets_count']); мы будем кликать...
        for ($i = 1; $i < $this->user_data['tickets_count']; $i++) {
            $I->click('.field-counter__btn-increment');
        }
        //checked option
        $I->executeJS("document.querySelectorAll('input[name=\"UF_OFFERT\"]')[0].checked = true;");

        $I->wait(2);

        $costPrice = preg_replace("/\D/", '',
            $I->executeJS("return document.querySelectorAll('.register-cost__price span')[0].innerHTML"));
        codecept_debug("Cost price is $costPrice");

        if ($type === self::REGISTER) {
            $I->click($this->form_send_register[$lang]);
            $I->waitForText($this->form_register_message[$lang], 30);
        }


        if ($type === self::BUY || $type === self::BUY_PROMO) {
            $I->click($this->form_send_buy[$lang]);
            $I->wait(30);
            $I->assertContains("money.yandex.ru", $this->getCurrentUrl());
            $yandex_kassa_cost = preg_replace("/\D/", '',
                $I->executeJS("return document.querySelectorAll('.price__whole-amount')[0].innerHTML"));
            codecept_debug('Проверяем сошлась ли цена');
            $I->assertEquals($costPrice, $yandex_kassa_cost);
            $this->cost_price = $costPrice;
        }
    }

    public function sendForm($type)
    {
        $I = $this->tester;

        foreach ($this->language_versions as $lang => $root) {
            if ($type === self::BUY || $type === self::REGISTER) {
                $I->amGoingTo('Переходим на курсы ' . $lang);
                $I->amOnPage($root . "courses/");
                $I->waitForElement('body', 10);
                $I->amGoingTo('Переходим на мероприятие');
                try {
                    $product_card = Locator::contains('.product-card', $this->places_available[$lang]);
                    $I->scrollTo($product_card);
                    $I->click($this->go_to_course[$lang], $product_card);
                    $I->waitForText($this->cookies_messages[$lang], 30);
                    $this->current_event_url = $this->getCurrentUrl();
                    codecept_debug($this->current_event_url);


                } catch (\Exception $e) {
                    codecept_debug('Нет активных мероприятий на версии ' . $lang);
                    $skip = true;
                    continue;
                }

                $this->sendFormOnEventPage($type, $lang);

                $event = $this->getEventBySymbolCode($this->getSymCode($this->current_event_url));

            }

            if ($type === self::BUY_PROMO) {
                $event = $this->getEventWithPromoUrl($lang);
                if ($event === false) {
                    codecept_debug('Event not found, exit');
                    unset($event);
                } else {
                    codecept_debug($event);
                    $this->promo = $event['promo'];
                    $expectPrice = $event['expect_sum'];
                    $I->amOnPage($event['url']);
                    $this->current_event_url = $event['url'];
                    $I->waitForText($this->cookies_messages[$lang], 30);
                    $this->sendFormOnEventPage($type, $lang);
                    codecept_debug('Сравниваем цену итога с предполагаемой с учётом скидки');
                    $I->assertEquals($expectPrice, $this->cost_price);
                }


            }

        }
    }
}
