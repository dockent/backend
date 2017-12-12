<?php

namespace Dockent\Tests\dataProviders;

use Phalcon\Validation\Message;

/**
 * Trait RenderInputsData
 * @package Dockent\Tests\dataProviders
 */
trait RenderInputsData
{
    /**
     * @return array
     */
    public function dataProviderInputText(): array
    {
        return [
            ['Some value', [], [], '<input type="text" class="form-control col-md-7 col-xs-12 1" value="Some value" >'],
            ['Some value', [], ['name' => 'input-name', 'required' => true],
                '<input type="text" class="form-control col-md-7 col-xs-12 1" value="Some value" name="input-name" required="1">'],
            ['Some value', [new Message('Error message')], [],
                '<input type="text" class="form-control col-md-7 col-xs-12 parsley-error" value="Some value" ><ul class="parsley-error-list filled"><li class="parsley-required">Error message</li></ul>'],
            ['Some value', [new Message('Error message'), new Message('Second error message')], [],
                '<input type="text" class="form-control col-md-7 col-xs-12 parsley-error" value="Some value" ><ul class="parsley-error-list filled"><li class="parsley-required">Error message</li><li class="parsley-required">Second error message</li></ul>'],
        ];
    }

    /**
     * @return array
     */
    public function dataProviderInputCheckbox(): array
    {
        return [
            [true, 'Title', [], [], '<input type="checkbox" class="flat 1" checked > Title'],
            [false, 'Title', [], ['name' => 'input-name', 'required' => true],
                '<input type="checkbox" class="flat 1" 1 name="input-name" required="1"> Title'],
            [true, 'Title', [new Message('Error message')], [],
                '<input type="checkbox" class="flat parsley-error" checked > Title<ul class="parsley-error-list filled"><li class="parsley-required">Error message</li></ul>'],
            [false, 'Title', [new Message('Error message'), new Message('Second error message')], [],
                '<input type="checkbox" class="flat parsley-error" 1 > Title<ul class="parsley-error-list filled"><li class="parsley-required">Error message</li><li class="parsley-required">Second error message</li></ul>'],
        ];
    }

    /**
     * @return array
     */
    public function dataProviderInputTextarea(): array
    {
        return [
            ['Some value', [], [], '<textarea class="form-control 1" >Some value</textarea>'],
            ['Some value', [], ['name' => 'input-name', 'required' => true],
                '<textarea class="form-control 1" name="input-name" required="1">Some value</textarea>'],
            ['Some value', [new Message('Error message')], [],
                '<textarea class="form-control parsley-error" >Some value</textarea><ul class="parsley-error-list filled"><li class="parsley-required">Error message</li></ul>'],
            ['Some value', [new Message('Error message'), new Message('Second error message')], [],
                '<textarea class="form-control parsley-error" >Some value</textarea><ul class="parsley-error-list filled"><li class="parsley-required">Error message</li><li class="parsley-required">Second error message</li></ul>'],
        ];
    }
}