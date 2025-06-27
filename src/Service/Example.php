<?php

namespace Demo\Service;

class Example implements ExampleInterface
{
    public function message(bool $isCaps): string
    {
        return $isCaps ? 'HELLO WORLD!!!!' : 'Hello World!!!!';
    }

    public function color(string $name): string
    {
        // TODO: check if this is a real color name
        return $name;
    }
}
