<?php

namespace Awssat\Tailwindo;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleHelper
{
    protected $converter;
    protected $output;
    protected $recursive = false;
    protected $overwrite;
    protected $extensions;

    public function __construct(OutputInterface $output, $recursive, $overwrite, $extensions)
    {
        $this->converter = new Converter();
        $this->output = $output;
        $this->recursive = $recursive;
        $this->overwrite = $overwrite;
        $this->extensions = $extensions;
    }

    public function folderConvert($folderPath)
    {
        $this->output->writeln('<question>Start Converting Folder: </question>'.$folderPath);

        if ($this->recursive) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    $folderPath, \RecursiveDirectoryIterator::SKIP_DOTS
                ),
                \RecursiveIteratorIterator::SELF_FIRST,
                \RecursiveIteratorIterator::CATCH_GET_CHILD
            );
        } else {
            $iterator = new \DirectoryIterator($folderPath);
        }

        foreach ($iterator as $path => $directory) {
            $extensions = explode('.', $directory);
            $extension = end($extensions);
            if ($directory->isFile() && $this->isConvertableFile($extension)) {
                $this->fileConvert($directory->getRealPath());
            }
        }
    }

    public function fileConvert($filePath)
    {
        //just in case
        $filePath = realpath($filePath);

        if (!is_file($filePath)) {
            $this->output->writeln('<comment>Couldn\'t convert: </comment>'.basename($filePath));

            return;
        }

        $content = file_get_contents($filePath);

        $lastDotPosition = strrpos($filePath, '.');

        if ($lastDotPosition !== false && !$this->overwrite) {
            $newFilePath = substr_replace($filePath, '.tw', $lastDotPosition, 0);
        } elseif (!$this->overwrite) {
            $newFilePath = $filePath.'.tw';
        } else {
            // Set the new path to the old path to make sure we overwrite it
            $newFilePath = $filePath;
        }

        $newContent = $this->converter
                    ->setContent($content)
                    ->convert()
                    ->get();

        if ($content !== $newContent) {
            $this->output->writeln('<info>Converted: </info>'.basename($newFilePath));

            file_put_contents($newFilePath, $newContent);
        } else {
            $this->output->writeln('<comment>Nothing to convert: </comment>'.basename($filePath));
        }
    }

    public function codeConvert($code)
    {
        $convertedCode = $this->converter
                    ->setContent($code)
                    ->classesOnly(strpos($code, '<') === false && strpos($code, '>') === false)
                    ->convert()
                    ->get();

        $this->output->writeln('<info>Converted Code: </info>'.$convertedCode);
    }

    /**
     * Check whether a file is convertable or not based on its extension.
     *
     * @param string $extension
     */
    protected function isConvertableFile($extension)
    {
        return in_array($extension, $this->extensions);
    }
}
