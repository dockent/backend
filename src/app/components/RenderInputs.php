<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 01.12.17
 * Time: 17:49
 */

namespace Dockent\components;

use Phalcon\Validation\MessageInterface;

/**
 * Class RenderInputs
 * @package Dockent\components
 */
class RenderInputs
{
    /**
     * @param string $value
     * @param MessageInterface[] $errors
     * @param array $options
     * @return string
     */
    public static function inputText(string $value, array $errors, array $options): string
    {
        $html = '<input type="text" class="form-control col-md-7 col-xs-12 ' . empty($errors) ?: 'parsley-error' . '" value="' . $value . '" ';
        $preparedOptions = [];
        foreach ($options as $option => $value) {
            $preparedOptions[] = "$option=\"$value\"";
        }
        $html .= implode(' ', $preparedOptions) . '>';
        if (!empty($errors)) {
            $html .= '<ul class="parsley-error-list filled">';
            foreach ($errors as $error) {
                $html .= '<li class="parsley-required">' . $error->getMessage() . '</li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }
}