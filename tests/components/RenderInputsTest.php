<?php

namespace Dockent\Tests\components;

use Dockent\components\RenderInputs;
use Dockent\Tests\dataProviders\RenderInputsData;
use PHPUnit\Framework\TestCase;

/**
 * Class RenderInputsTest
 * @package Dockent\Tests\components
 */
class RenderInputsTest extends TestCase
{
    use RenderInputsData;

    /**
     * @dataProvider dataProviderInputText
     * @param string $value
     * @param array $errors
     * @param array $options
     * @param string $expected
     */
    public function testInputText(string $value, array $errors, array $options, string $expected)
    {
        $this->assertEquals($expected, RenderInputs::inputText($value, $errors, $options));
    }

    /**
     * @dataProvider dataProviderInputCheckbox
     * @param bool $checked
     * @param string $title
     * @param array $errors
     * @param array $options
     * @param string $expected
     */
    public function testInputCheckbox(bool $checked, string $title, array $errors, array $options, string $expected)
    {
        $this->assertEquals($expected, RenderInputs::inputCheckbox($checked, $title, $errors, $options));
    }

    /**
     * @dataProvider dataProviderInputTextarea
     * @param string $value
     * @param array $errors
     * @param array $options
     * @param string $expected
     */
    public function testInputTextarea(string $value, array $errors, array $options, string $expected)
    {
        $this->assertEquals($expected, RenderInputs::inputTextarea($value, $errors, $options));
    }
}