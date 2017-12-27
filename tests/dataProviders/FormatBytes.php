<?php

namespace Dockent\Tests\dataProviders;

/**
 * Trait FormatBytes
 * @package Dockent\Tests\dataProviders
 */
trait FormatBytes
{
    /**
     * @return array
     */
    public function dataProviderFormatBytes(): array
    {
        return [
            [111111, '108.51 KB'],
            [11132223321, '10.37 GB']
        ];
    }
}