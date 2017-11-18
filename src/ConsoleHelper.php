<?php

namespace Awssat\Tailwindo;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleHelper
{
    protected $converter;
    protected $output;

    public function __construct(OutputInterface $output)
    {
        $this->converter = new Converter();
        $this->output = $output;
    }

    public function folderConvert($folderPath)
    {
        $this->output->writeln('<question>Start Converting Folder: </question>'.$folderPath);

        foreach (new \DirectoryIterator($folderPath) as $file) {
            if ($file->isFile() && !$file->isDot() && $this->isConvertableFile($file->getExtension())) {
                $this->fileConvert($file->getRealPath());
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

        if ($lastDotPosition !== false) {
            $newFilePath = substr_replace($filePath, '.tw', $lastDotPosition, 0);
        } else {
            $newFilePath = $filePath.'.tw';
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
        return in_array($extension, ['php', 'html']);
    }
}
