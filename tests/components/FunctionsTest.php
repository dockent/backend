<?php

namespace Dockent\Tests\components;

use Dockent\Tests\dataProviders\FormatBytes;
use PHPUnit\Framework\TestCase;

/**
 * Class FunctionsTest
 * @package Dockent\Tests\components
 */
class FunctionsTest extends TestCase
{
    use FormatBytes;

    /**
     * @dataProvider dataProviderFormatBytes
     * @param int $size
     * @param string $result
     */
    public function testFormatBytes(int $size, string $result)
    {
        $this->assertEquals($result, \formatBytes($size));
    }

    public function testRmDirRecursive()
    {
        $dir = uniqid('phpunit_docker_');
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $dir;
        mkdir($path);
        file_put_contents($path . DIRECTORY_SEPARATOR . '1.txt', '1');
        file_put_contents($path . DIRECTORY_SEPARATOR . '2.txt', '2');
        mkdir($path . DIRECTORY_SEPARATOR . 'folder');
        file_put_contents($path . DIRECTORY_SEPARATOR . 'folder' . DIRECTORY_SEPARATOR . '1.txt', '1');
        file_put_contents($path . DIRECTORY_SEPARATOR . 'folder' . DIRECTORY_SEPARATOR . '2.txt', '2');
        $this->assertTrue(rmDirRecursive($path));
        $this->assertDirectoryNotExists($path);
    }
}