<?php

namespace App;

use RuntimeException;

class FileProvider
{
    /**
     * По хорошему, следующие 3 ф-и нужно вынести в какой-нибудь хелпер.
     * Но я не хочу этого делать сейчас.
     */


    public function getTextsDirectoryPath()
    {
        return dirname(__DIR__) . '/texts';
    }

    public function getOutputTextsDirectoryPath()
    {
        return dirname(__DIR__) . '/output_texts';
    }

    public function getPeoplesFile()
    {
        return $this->readLines(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'people.csv');
    }

    public function readLines($path)
    {
        if (!file_exists($path)) {
            throw new RuntimeException(sprintf('Файл "%s" не найден', $path));
        }

        return file($path) ?: [];
    }

    public function getContent($path): string
    {
        if (!file_exists($path)) {
            throw new RuntimeException(sprintf('Файл "%s" не найден', $path));
        }

        return (string)file_get_contents($path);
    }

    public function write($path, $data)
    {
        file_put_contents($path, $data);
    }

    public function listFiles($directory, $pattern)
    {
        $pattern = $directory . DIRECTORY_SEPARATOR . $pattern;

        return glob($pattern);
    }

    public function countLines($path)
    {
        return count($this->readLines($path));
    }
}