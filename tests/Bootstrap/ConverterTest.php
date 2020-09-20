<?php

namespace Awssat\Tailwindo\Test;

use Awssat\Tailwindo\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /** @var Awssat\Tailwindo\Converter */
    protected $converter;

    protected function setUp(): void
    {
        $this->converter = (new Converter())->setFramework('bootstrap');
    }

    /** @test */
    public function it_returns_output()
    {
        $this->assertEquals(
            'sm:flex',
            $this->converter->classesOnly(true)->setContent('d-sm-flex')->convert()->get()
        );
        $this->assertEquals(
            '<a class="text-gray-700">love</a>',
            $this->converter->setContent('<a class="text-muted">love</a>')->convert()->get()
        );
    }

    /** @test */
    public function it_returns_output_with_prefix()
    {
        $this->converter->setPrefix('tw-');
        $this->assertEquals(
            'sm:tw-flex',
            $this->converter->classesOnly(true)->setContent('d-sm-flex')->convert()->get()
        );
        $this->assertEquals(
            '<a class="tw-text-gray-700">love</a>',
            $this->converter->setContent('<a class="text-muted">love</a>')->convert()->get()
        );
    }
}
