<?php

namespace Eightfold\String\Tests;

trait TestStrings
{
    private function plainText(): string
    {
        return 'Hello, World!';
    }

    private function unicode(): string
    {
        return '😀😇🌍😍😌';
    }

    private function plainTextWithUnicode(): string
    {
        return 'Hello, 🌍!';
    }
}
