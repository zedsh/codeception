<?php

use Creative\Edu\Pipedrive\PipedriveEduHelper;

class PipeDriveEduHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        require __DIR__ . "/../../web/local/modules/creative.edu/lib/Pipedrive/PipedriveEduHelper.php";
    }

    protected function _after()
    {
    }

    // tests
    public function testPhoneClear()
    {
        $this->assertEquals(PipedriveEduHelper::phoneClear("+7123456789"),"7123456789");
        $this->assertEquals(PipedriveEduHelper::phoneClear("+7 123 45 6 7 8 9"),"7123456789");
        $this->assertEquals(PipedriveEduHelper::phoneClear("+71++(2 3 ) )456789"),"7123456789");
        $this->assertEquals(PipedriveEduHelper::phoneClear("+71( 234) 5)6789"),"7123456789");

    }
}OD