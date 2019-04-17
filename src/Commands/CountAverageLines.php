<?php

namespace App\Commands;

use App\FileHelper;
use App\FileProvider;
use Symfony\Component\Console\Output\OutputInterface;

class CountAverageLines extends AbstractCommand
{
    /**
     * @var \App\FileProvider
     */
    private $fileProvider;
    /**
     * @var string
     */
    private $directory;
    /**
     * @var \App\FileHelper
     */
    private $fileHelper;

    public function __construct()
    {
        $this->fileProvider = new FileProvider();
        $this->fileHelper = new FileHelper();
        $this->directory = $this->fileProvider->getTextsDirectoryPath();
    }

    public function execute(OutputInterface $output)
    {
        $peoples = $this->getPeoples();

        foreach ($peoples as $peopleId => $peopleName) {
            $files = $this->scanDir((int)$peopleId);
            $count = $this->countLines($files);
            $output->writeln('Пользователь: ' . $peopleName);
            $output->writeln('Среднее количество строк: ' . $count);
        }
    }

    private function getPeoples(): array
    {
        return $this->fileHelper->getPeoples();
    }

    private function scanDir(int $id): array
    {
        return $this->fileHelper->getFilesById($this->directory, $id);
    }

    private function countLines(array $files)
    {
        if (empty($files)) {
            return 0;
        }

        $counts = $this->countLinesForFile($files);

        return $counts / count($files);
    }

    /**
     * @param array $files
     *
     * @return int
     */
    private function countLinesForFile(array $files): int
    {
        $fileProvider = $this->fileProvider;

        return (int)array_reduce($files, static function ($carry, $fileName) use ($fileProvider) {
            return (int)$carry + (int)$fileProvider->countLines($fileName);
        });
    }
}