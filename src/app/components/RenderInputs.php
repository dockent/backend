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
     * @param MessageInterface[] $errors
     * @return string
     */
    private static function renderErrors(array $errors): string
    {
        $html = '';
        if (!empty($errors)) {
            $html .= '<ul class="parsley-error-list filled">';
            foreach ($errors as $error) {
                $html .= '<li class="parsley-required">' . $error->getMessage() . '</li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }

    /**
     * @param string $value
     * @param MessageInterface[] $errors
     * @param array $options
     * @return string
     */
    public static function inputText(string $value, array $errors, array $options): string
    {
        $html = '<input type="text" class="form-control col-md-7 col-xs-12 ' . (empty($errors) ?: 'parsley-error') . '" value="' . $value . '" ';
        $preparedOptions = [];
        foreach ($options as $option => $value) {
            $preparedOptions[] = "$option=\"$value\"";
        }
        $html .= implode(' ', $preparedOptions) . '>';
        $html .= static::renderErrors($errors);

        return $html;
    }

    /**
     * @param bool $checked
     * @param string $title
     * @param MessageInterface[] $errors
     * @param array $options
     * @return string
     */
    public static function inputCheckbox(bool $checked, string $title, array $errors, array $options): string
    {
        $html = '<input type="checkbox" class="flat ' . (empty($errors) ?: 'parsley-error') . '" ' . (!$checked ?: 'checked') . ' ';
        $preparedOptions = [];
        foreach ($options as $option => $value) {
            $preparedOptions[] = "$option=\"$value\"";
        }
        $html .= implode(' ', $preparedOptions) . '> ' . $title;
        $html .= static::renderErrors($errors);

        return $html;
    }

    /**
     * @param string $text
     * @param MessageInterface[] $errors
     * @param array $options
     * @return string
     */
    public static function inputTextarea(string $text, array $errors, array $options): string
    {
        $html = '<textarea class="form-control ' . (empty($errors) ?: 'parsley-error') . '" ';
        $preparedOptions = [];
        foreach ($options as $option => $value) {
            $preparedOptions[] = "$option=\"$value\"";
        }
        $html .= implode(' ', $preparedOptions) . '>' . $text . '</textarea>';
        $html .= static::renderErrors($errors);

        return $html;
    }
}