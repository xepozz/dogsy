<?php

namespace App\Commands;

use App\FileHelper;
use App\FileProvider;
use App\WrongDateHelper;
use Symfony\Component\Console\Output\OutputInterface;

class ReplaceDates extends AbstractCommand
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
    /**
     * @var \App\WrongDateHelper
     */
    private $wrongDateHelper;

    public function __construct()
    {
        $this->fileProvider = new FileProvider();
        $this->fileHelper = new FileHelper();
        $this->wrongDateHelper = new WrongDateHelper();
        $this->directory = $this->fileProvider->getTextsDirectoryPath();
    }

    public function execute(OutputInterface $output)
    {
        $peoples = $this->getPeoples();

        foreach ($peoples as $peopleId => $peopleName) {
            $files = $this->scanDir((int)$peopleId);
            $count = $this->countDatesInWrongFormat($files);
            if ($count) {
                $this->replaceDatesInWrongFormat($files);
            }
            $output->writeln('Пользователь: ' . $peopleName);
            $output->writeln('Найдно и заменено дат в неправильном формате: ' . $count);
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

    private function countDatesInWrongFormat(array $files)
    {
        $fileProvider = $this->fileProvider;
        $helper = $this->wrongDateHelper;

        return (int)array_reduce($files, static function ($carry, $fileName) use ($fileProvider, $helper) {
            $data = $fileProvider->getContent($fileName);
            $matched = $helper->matchWrongDates($data);

            return (int)$carry + (int)$matched;
        });
    }

    private function replaceDatesInWrongFormat(array $files)
    {
        $fileProvider = $this->fileProvider;
        $newDir = $this->fileProvider->getOutputTextsDirectoryPath();
        foreach ($files as $file) {
            $data = $fileProvider->getContent($file);
            if ($this->wrongDateHelper->matchWrongDates($data)) {
                $filename = $this->fileHelper->getFilename($file);
                $newPath = $newDir . DIRECTORY_SEPARATOR . $filename;
                $newContent = $this->wrongDateHelper->replaceWrongDates($data);
                $this->fileProvider->write($newPath, $newContent);
            }
        }
    }
}