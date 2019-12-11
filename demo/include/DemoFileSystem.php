<?php
declare(strict_types=1);

namespace KnotModule\Stk2kEventStream\Demo;

use Calgamo\Kernel\FileSystem\AbstractFileSystem;
use Calgamo\Kernel\FileSystem\Dir;

final class DemoFileSystem extends AbstractFileSystem
{
    /**
     * Get directory path
     *
     * @param int $dir
     *
     * @return string
     */
    public function getDirectory(int $dir) : string
    {
        switch($dir){
            case Dir::CACHE:
                return dirname(__DIR__) . '/cache';
        }
        return '';
    }

}