<?php

namespace Dockent\ci;

/**
 * Class Frontend
 * @package Dockent\ci
 */
class Frontend
{
    const FE_BUILD_URL = 'https://bitbucket.org/scary_develop/dockent-frontend/downloads/build.zip';
    const RUNTIME_DIR = __DIR__ . '/../runtime';
    const DESTINATION_DIR = __DIR__ . '/../src';

    public static function download()
    {
        require_once __DIR__ . '/../src/app/components/functions.php';

        echo self::FE_BUILD_URL . PHP_EOL;
        if (!is_dir(self::RUNTIME_DIR)) {
            mkdir(self::RUNTIME_DIR);
        }
        file_put_contents(self::RUNTIME_DIR . '/build.zip', file_get_contents(self::FE_BUILD_URL));
        $zip = new \ZipArchive();
        if ($zip->open(self::RUNTIME_DIR . '/build.zip')) {
            $zip->extractTo(self::RUNTIME_DIR);
            $zip->close();
            if (is_dir(self::DESTINATION_DIR . '/static')) {
                rmDirRecursive(self::DESTINATION_DIR . '/static');
            }
            rename(self::RUNTIME_DIR . '/build/static', self::DESTINATION_DIR . '/static');
            rename(self::RUNTIME_DIR . '/build/asset-manifest.json', self::DESTINATION_DIR . '/asset-manifest.json');
            rename(self::RUNTIME_DIR . '/build/service-worker.js', self::DESTINATION_DIR . '/service-worker.js');
            rmDirRecursive(self::RUNTIME_DIR);
        }
    }
}