<?php

namespace Awssat\Tailwindo\Test;

use Awssat\Tailwindo\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /** @var Awssat\Tailwindo\Converter */
    protected $converter;

    protected function setUp()
    {
        $this->converter = new Converter();
    }

    /** @test */
    public function it_return_output()
    {
        $this->assertEquals(
            'mb-2',
            $this->converter->setContent('mb-2')->convert()->get()
        );
    }
}
