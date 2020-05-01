<?php

namespace Awssat\Tailwindo\Framework;

interface Framework
{
    function defaultCSS(): array;
    function supportedVersion(): string;
    function get(): \Generator;
}