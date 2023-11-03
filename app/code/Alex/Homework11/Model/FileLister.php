<?php

namespace Alex\Homework11\Model;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileLister
{
    private $upOne;

    public function __construct()
    {
        $this->upOne = dirname(__DIR__, 2);
    }

    public function getFileList(): array
    {
        $directory = $this->upOne;

        $fileList = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isDir() || $file->isFile()) {
                $filePath = $file->getPathname();
                $fileList[] = [
                    'name' => $file->getFilename(),
                    'path' => $filePath,
                    'type' => $file->isDir() ? 'directory' : 'file',
                    'created' => date('Y-m-d H:i:s', $file->getCTime()),
                    'modified' => date('Y-m-d H:i:s', $file->getMTime())
                ];
            }
        }

        return $fileList;
    }
}

// Usage
$fileList = new FileLister();
$result = $fileList->getFileList();
print_r($result);
