<?php

/**
 * @param int $size
 * @param int $precision
 * @return string
 */
function formatBytes(int $size, int $precision = 2): string
{
    $base = log($size, 1024);
    $suffixes = ['', 'KB', 'MB', 'GB', 'TB'];
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[(int)floor($base)];
}

/**
 * @param string $dir
 * @return bool
 */
function rmDirRecursive(string $dir): bool
{
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $fullPath = "$dir/$file";
        (is_dir($fullPath)) ? rmDirRecursive($fullPath) : unlink($fullPath);
    }
    return rmdir($dir);
}