<?php

namespace Alex\Homework11\Model;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileLister
{
    /**
     * @return array
     */
    public function listFilesAndFolders(): array
    {
        $directory = new RecursiveDirectoryIterator(dirname(__DIR__, 3));
        $iterator = new RecursiveIteratorIterator($directory);

        $list = [];
        foreach ($iterator as $info) {
            $list[] = [
                'name' => $info->getFilename(),
                'type' => $info->getType(),
                'created' => date('Y-m-d H:i:s', $info->getATime()),
                'modified' => date('Y-m-d H:i:s', $info->getMTime())
            ];
        }

        return $list;
    }
}
