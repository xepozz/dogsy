<?php

namespace App;

class FileHelper
{
    /**
     * @var \App\FileProvider
     */
    private $fileProvider;

    public function __construct()
    {
        $this->fileProvider = new FileProvider();
    }

    public function getFilesById($directory, int $id): array
    {
        $pattern = $id . '-[0-9][0-9][0-9].txt';

        return $this->fileProvider->listFiles($directory, $pattern);
    }

    public function getPeoples(): array
    {
        $file = $this->fileProvider->getPeoplesFile();
        $peoples = [];
        $delimiter = $this->getSeparator();
        foreach ($file as $line) {
            [$id, $name] = str_getcsv($line, $delimiter);
            $peoples[$id] = $name;
        }

        return $peoples;
    }

    private function getSeparator(): string
    {
        $config = Config::getInstance();
        $separator = $config->getSeparator();

        return $separator->getValue();
    }

    public function changeDir(string $path, string $newDir)
    {
        $arrayPath = $this->splitPath($path);
        $arrayPath[count($arrayPath) - 2] = $newDir;

        return $this->concatArrayPath($arrayPath);
    }

    public function getFilename(string $path)
    {
        $path = $this->splitPath($path);

        return end($path);
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private function splitPath(string $path): array
    {
        return explode(DIRECTORY_SEPARATOR, $path);
    }

    private function concatArrayPath($arrayPath): string
    {
        return implode(DIRECTORY_SEPARATOR, $arrayPath);
    }
}