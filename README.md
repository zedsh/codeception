Основы codeception
====================
Codeception позволяет выполнять полный спектр тестов на проекте. 
Это как юнит-тесты, так и тесты в реальном браузере. 
Если ставится цель тестирования в реальном браузере - нужно развернуть соответствующее окружение, 
а для тестов форм и т.п. тестов, где не нужны проверки работы js-а на сайте - можно обойтись имитацией браузера на базе php. 
За реализацию всего функционала тестов отвечают МОДУЛИ.
Конфигурация модулей находится в файлах tests/*.suite.yml
Функционал, который можно использовать в тестах, зависит от модулей, которые подключены и настроены. 



Установка codeception:
====================
composer require codeception/codeception --dev
php vendor/bin/codecept bootstrap

Установка Chrome Webdriver (linux):
=======================
Пример установки webdriver для Linux (debian-based, systemd) находится в setup_scripts/webdriver_install.sh

Если хочется иметь возможность при тестировании видеть, что происходит на экране:
в файле /etc/systemd/system/chromedriver.service
замените `User=chromedriver` на `User=ваше_имя_пользователя`
сохраните и выполните команды:
```
systemctl daemon-reload
systemctl restart chromedriver
```

Настройка тестового окружения и параметров
=======================
В tests/acceptance.suite.yml находится несколько вариантов настройки ПРИЁМОЧНЫХ ТЕСТОВ. Такие тесты (в отличие от юнит-тестов)
предполагают тестирование финального продукта (сайта) - переходы по нему, отправка форм и реакция на это и т.п.

Среды `dev_window` и dev в примере отличаются тем, что в `dev_window` можно видеть, что происходит на экране (за это отвечает флаг --headless хрома).
Среда `dev_base` включает только базовый браузер PHP


Примеры тестов
=======================

`tests/acceptance/ViewWriteTestCept.php` - простой тест на переходы по сайту и заполнеие формы
`tests/acceptance/StrongSomeTest.php` - пример включения теста в сторонний скрипт (из реального проекта, часть кода вырезана, показывает как делать 
ряд вещей через браузер и подключить битрикс.  Не запустится.
`tests/unit/SomeHelperTest.php` - юнит-тест для класса, который приводит телефоны к стандартному варианту. Не запустится. Показывает пример юнит-теста.


Как выводить информацию для дебага
======================
функция `codecept_debug()` и при запуске теста параметр --debug


Как запускать тесты
======================
`php vendor/bin/codecept run --env dev --debug` # запустить тесты со средой dev с выводом debug info
`php vendor/bin/codecept run acceptance` # запустить только acceptance тесты
`php vendor/bin/codecept run acceptance SigninCest.php` #запустить конкретный файл теста. Вместо названия файла может быть путь до него.

Больше инфы: https://codeception.com/docs/02-GettingStarted

Форматы тестов
====================
Accepance тесты бывают в форматах Cept и Cest.
Unit - стандартный формат PhpUnit тестов (Test).

Именование:
codeception определяет формат теста по имени файла
ViewWriteTestCept.php - значит ожидается Cept, 
ViewWriteCest.php - значит cest.
Юнит тесты именуются ViewWriteTest.php

Различия: 
Cept - просто тест-скрипт
Cest - тест-класс. Каждый метод будет выполняться отдельно в заранее подготовленном окружении (от метода к методы окружение будет обнуляться)

Больше информации: https://codeception.com/docs/

Особенности работы тестов
===================
Тесты в браузере не всегда работают ожидаемо. Например, чтобы нажать на кнопку - нужно, чтобы она была видна в окне браузера (даже по классу).
Есть зависимость от размера окна браузера)
Иногда требуется выполнять JS на странице, чтобы поставить чекбокс и т.п. манипуляции (см `test_data/EasyEvent.php`)
Страницы загружаются некоторое время - нельзя ожидать на них элементов сразу после отправки формы - это нужно учитывать. 




