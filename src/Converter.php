<?php

namespace Awssat\Tailwindo;

class Converter
{
    protected $givenContent = '';

    protected $isCssClassesOnly = false;

    protected $changes = 0;

    protected $lastSearches = [];

    /** @var \Awssat\Tailwindo\Framework */
    protected $framework;


    public function __construct(?string $content = null)
    {
        if (!empty($content)) {
            $this->givenContent = $content;
        }

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->givenContent = $content;

        return $this;
    }

    public function setFramework(string $framework): self
    {
        $framework = 'Awssat\\Tailwindo\\Framework\\' . ucfirst($framework).'Framework';

        $this->framework = new $framework;

        return $this;
    }

    /**
     * Is the given content a CSS content or HTML content.
     */
    public function classesOnly(bool $value): self
    {
        $this->isCssClassesOnly = $value;

        return $this;
    }

    public function convert(): self
    {
        foreach($this->framework->get() as $item) {
           foreach ($item as $search => $replace) {
               $this->searchAndReplace($search, $replace);
           }
        }

        return $this;
    }

    /**
     * Get the converted content.
     */
    public function get(): string
    {
        return $this->givenContent;
    }

    /**
     * Get the number of committed changes.
     */
    public function changes(): int
    {
        return $this->changes;
    }

    /**
     * search for a word in the last searches.
     */
    protected function isInLastSearches(string $searchFor, int $limit = 0): bool
    {
        $i = 0;

        foreach ($this->lastSearches as $search) {
            if (strpos($search, $searchFor) !== false) {
                return true;
            }

            if ($i++ >= $limit && $limit > 0) {
                return false;
            }
        }

        return false;
    }

    /**
     * Search the given content and replace.
     *
     * @param string $search
     * @param string|\Closure $replace
     */
    protected function searchAndReplace($search, $replace): void
    {
        $currentContent = $this->givenContent;

        if($replace instanceof \Closure) {
            $callableReplace = \Closure::bind($replace, $this, self::class);
            $replace = $callableReplace();
        }

        $regexStart = !$this->isCssClassesOnly ? '(?<start>class\s*=\s*["\'].*?)' : '(?<start>\s*)';
        $regexEnd = !$this->isCssClassesOnly ? '(?<end>.*?["\'])' : '(?<end>\s*)';

        $search = preg_quote($search);

        $currentSubstitute = 0;

        while (true) {
            if (strpos($search, '\{regex_string\}') !== false || strpos($search, '\{regex_number\}') !== false) {
                $currentSubstitute++;
                foreach (['regex_string'=> '[a-zA-Z0-9]+', 'regex_number' => '[0-9]+'] as $regeName => $regexValue) {
                    $search = preg_replace('/\\\{'.$regeName.'\\\}/', '(?<'.$regeName.'_'.$currentSubstitute.'>'.$regexValue.')', $search, 1);
                    $replace = preg_replace('/{'.$regeName.'\}/', '${'.$regeName.'_'.$currentSubstitute.'}', $replace, 1);
                }

                continue;
            }

            break;
        }

        //class=" given given-md something-given-md"
        $this->givenContent = preg_replace_callback(
            '/'.$regexStart.'(?<given>(?<![\-_.\w\d])'.$search.'(?![\-_.\w\d]))'.$regexEnd.'/i',
             function ($match) use ($replace) {
                 $replace = preg_replace_callback('/\$\{regex_(\w+)_(\d+)\}/', function ($m) use ($match) {
                     return $match['regex_'.$m[1].'_'.$m[2]];
                 }, $replace);

                 return $match['start'].$replace.$match['end'];
             },
             $this->givenContent
         );

        if (strcmp($currentContent, $this->givenContent) !== 0) {
            $this->changes++;

            $this->lastSearches[] = stripslashes($search);

            if (count($this->lastSearches) >= 10) {
                $this->lastSearches = array_slice($this->lastSearches, -10, 10, true);
            }
        }
    }
}
