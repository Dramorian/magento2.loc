<?php

namespace Alex\Homework11\Model;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileLister
{
    /**
     * @return array
     */
    public function listFilesAndFolders(): array
    {
        $directory = new RecursiveDirectoryIterator(dirname(__DIR__, 2), FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $info) {
            $list[] = [
                'filename' => $info->getFilename(),
                'type' => $info->getType(),
                'created' => date('Y-m-d H:i:s', $info->getCTime()),
                'modified' => date('Y-m-d H:i:s', $info->getATime())
            ];
        }

        return $list;
    }
}
