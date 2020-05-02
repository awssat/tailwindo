<?php

namespace Awssat\Tailwindo\Framework;

interface Framework
{
    function defaultCSS(): array;
    function supportedVersion(): array;
    function get(): \Generator;
}