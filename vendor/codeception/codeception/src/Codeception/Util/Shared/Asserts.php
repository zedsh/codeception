<?php
namespace Codeception\Util\Shared;

trait Asserts
{
    protected function assert($arguments, $not = false)
    {
        $not = $not ? 'Not' : '';
        $method = ucfirst(array_shift($arguments));
        if (($method === 'True') && $not) {
            $method = 'False';
            $not = '';
        }
        if (($method === 'False') && $not) {
            $method = 'True';
            $not = '';
        }

        call_user_func_array(['\PHPUnit\Framework\Assert', 'assert' . $not . $method], $arguments);
    }

    protected function assertNot($arguments)
    {
        $this->assert($arguments, true);
    }

    /**
     * Checks that two variables are equal.
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     * @param float  $delta
     */
    protected function assertEquals($expected, $actual, $message = '', $delta = 0.0)
    {
        \PHPUnit\Framework\Assert::assertEquals($expected, $actual, $message, $delta);
    }

    /**
     * Checks that two variables are not equal
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     * @param float  $delta
     */
    protected function assertNotEquals($expected, $actual, $message = '', $delta = 0.0)
    {
        \PHPUnit\Framework\Assert::assertNotEquals($expected, $actual, $message, $delta);
    }

    /**
     * Checks that two variables are same
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     */
    protected function assertSame($expected, $actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertSame($expected, $actual, $message);
    }

    /**
     * Checks that two variables are not same
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     */
    protected function assertNotSame($expected, $actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertNotSame($expected, $actual, $message);
    }

    /**
     * Checks that actual is greater than expected
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     */
    protected function assertGreaterThan($expected, $actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertGreaterThan($expected, $actual, $message);
    }

    /**
     * @deprecated
     */
    protected function assertGreaterThen($expected, $actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertGreaterThan($expected, $actual, $message);
    }

    /**
     * Checks that actual is greater or equal than expected
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     */
    protected function assertGreaterThanOrEqual($expected, $actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertGreaterThanOrEqual($expected, $actual, $message);
    }

    /**
     * @deprecated
     */
    protected function assertGreaterThenOrEqual($expected, $actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertGreaterThanOrEqual($expected, $actual, $message);
    }

    /**
     * Checks that actual is less than expected
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     */
    protected function assertLessThan($expected, $actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertLessThan($expected, $actual, $message);
    }

    /**
     * Checks that actual is less or equal than expected
     *
     * @param        $expected
     * @param        $actual
     * @param string $message
     */
    protected function assertLessThanOrEqual($expected, $actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertLessThanOrEqual($expected, $actual, $message);
    }


    /**
     * Checks that haystack contains needle
     *
     * @param        $needle
     * @param        $haystack
     * @param string $message
     */
    protected function assertContains($needle, $haystack, $message = '')
    {
        \PHPUnit\Framework\Assert::assertContains($needle, $haystack, $message);
    }

    /**
     * Checks that haystack doesn't contain needle.
     *
     * @param        $needle
     * @param        $haystack
     * @param string $message
     */
    protected function assertNotContains($needle, $haystack, $message = '')
    {
        \PHPUnit\Framework\Assert::assertNotContains($needle, $haystack, $message);
    }

    /**
     * Checks that string match with pattern
     *
     * @param string $pattern
     * @param string $string
     * @param string $message
     */
    protected function assertRegExp($pattern, $string, $message = '')
    {
        \PHPUnit\Framework\Assert::assertRegExp($pattern, $string, $message);
    }
    
    /**
     * Checks that string not match with pattern
     *
     * @param string $pattern
     * @param string $string
     * @param string $message
     */
    protected function assertNotRegExp($pattern, $string, $message = '')
    {
        \PHPUnit\Framework\Assert::assertNotRegExp($pattern, $string, $message);
    }

    /**
     * Checks that a string starts with the given prefix.
     *
     * @param string $prefix
     * @param string $string
     * @param string $message
     */
    protected function assertStringStartsWith($prefix, $string, $message = '')
    {
        \PHPUnit\Framework\Assert::assertStringStartsWith($prefix, $string, $message);
    }

    /**
     * Checks that a string doesn't start with the given prefix.
     *
     * @param string $prefix
     * @param string $string
     * @param string $message
     */
    protected function assertStringStartsNotWith($prefix, $string, $message = '')
    {
        \PHPUnit\Framework\Assert::assertStringStartsNotWith($prefix, $string, $message);
    }


    /**
     * Checks that variable is empty.
     *
     * @param        $actual
     * @param string $message
     */
    protected function assertEmpty($actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertEmpty($actual, $message);
    }

    /**
     * Checks that variable is not empty.
     *
     * @param        $actual
     * @param string $message
     */
    protected function assertNotEmpty($actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertNotEmpty($actual, $message);
    }

    /**
     * Checks that variable is NULL
     *
     * @param        $actual
     * @param string $message
     */
    protected function assertNull($actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertNull($actual, $message);
    }

    /**
     * Checks that variable is not NULL
     *
     * @param        $actual
     * @param string $message
     */
    protected function assertNotNull($actual, $message = '')
    {
        \PHPUnit\Framework\Assert::assertNotNull($actual, $message);
    }

    /**
     * Checks that condition is positive.
     *
     * @param        $condition
     * @param string $message
     */
    protected function assertTrue($condition, $message = '')
    {
        \PHPUnit\Framework\Assert::assertTrue($condition, $message);
    }

    /**
     * Checks that the condition is NOT true (everything but true)
     *
     * @param        $condition
     * @param string $message
     */
    protected function assertNotTrue($condition, $message = '')
    {
        \PHPUnit\Framework\Assert::assertNotTrue($condition, $message);
    }

    /**
     * Checks that condition is negative.
     *
     * @param        $condition
     * @param string $message
     */
    protected function assertFalse($condition, $message = '')
    {
        \PHPUnit\Framework\Assert::assertFalse($condition, $message);
    }

    /**
     * Checks that the condition is NOT false (everything but false)
     *
     * @param        $condition
     * @param string $message
     */
    protected function assertNotFalse($condition, $message = '')
    {
        \PHPUnit\Framework\Assert::assertNotFalse($condition, $message);
    }

    /**
     *
     * @param        $haystack
     * @param        $constraint
     * @param string $message
     */
    protected function assertThat($haystack, $constraint, $message = '')
    {
        \PHPUnit\Framework\Assert::assertThat($haystack, $constraint, $message);
    }

    /**
     * Checks that haystack doesn't attend
     *
     * @param        $haystack
     * @param        $constraint
     * @param string $message
     */
    protected function assertThatItsNot($haystack, $constraint, $message = '')
    {
        $constraint = new \PHPUnit\Framework\Constraint\LogicalNot($constraint);
        \PHPUnit\Framework\Assert::assertThat($haystack, $constraint, $message);
    }

    
    /**
     * Checks if file exists
     *
     * @param string $filename
     * @param string $message
     */
    protected function assertFileExists($filename, $message = '')
    {
        \PHPUnit\Framework\Assert::assertFileExists($filename, $message);
    }
    
        
    /**
     * Checks if file doesn't exist
     *
     * @param string $filename
     * @param string $message
     */
    protected function assertFileNotExists($filename, $message = '')
    {
        \PHPUnit\Framework\Assert::assertFileNotExists($filename, $message);
    }

    /**
     * @param $expected
     * @param $actual
     * @param $description
     */
    protected function assertGreaterOrEquals($expected, $actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertGreaterThanOrEqual($expected, $actual, $description);
    }

    /**
     * @param $expected
     * @param $actual
     * @param $description
     */
    protected function assertLessOrEquals($expected, $actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertLessThanOrEqual($expected, $actual, $description);
    }

    /**
     * @param $actual
     * @param $description
     */
    protected function assertIsEmpty($actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertEmpty($actual, $description);
    }

    /**
     * @param $key
     * @param $actual
     * @param $description
     */
    protected function assertArrayHasKey($key, $actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertArrayHasKey($key, $actual, $description);
    }

    /**
     * @param $key
     * @param $actual
     * @param $description
     */
    protected function assertArrayNotHasKey($key, $actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertArrayNotHasKey($key, $actual, $description);
    }

    /**
     * Checks that array contains subset.
     *
     * @param array  $subset
     * @param array  $array
     * @param bool   $strict
     * @param string $message
     */
    protected function assertArraySubset($subset, $array, $strict = false, $message = '')
    {
        \PHPUnit\Framework\Assert::assertArraySubset($subset, $array, $strict, $message);
    }

    /**
     * @param $expectedCount
     * @param $actual
     * @param $description
     */
    protected function assertCount($expectedCount, $actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertCount($expectedCount, $actual, $description);
    }

    /**
     * @param $class
     * @param $actual
     * @param $description
     */
    protected function assertInstanceOf($class, $actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertInstanceOf($class, $actual, $description);
    }

    /**
     * @param $class
     * @param $actual
     * @param $description
     */
    protected function assertNotInstanceOf($class, $actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertNotInstanceOf($class, $actual, $description);
    }

    /**
     * @param $type
     * @param $actual
     * @param $description
     */
    protected function assertInternalType($type, $actual, $description = '')
    {
        \PHPUnit\Framework\Assert::assertInternalType($type, $actual, $description);
    }
    
    /**
     * Fails the test with message.
     *
     * @param $message
     */
    protected function fail($message)
    {
        \PHPUnit\Framework\Assert::fail($message);
    }
}
