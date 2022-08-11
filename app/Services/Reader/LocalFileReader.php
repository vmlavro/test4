<?php

namespace App\Services\Reader;

class LocalFileReader implements ReaderInterface
{

    public function __construct(private string $path)
    {
    }

    public function getContent(): string
    {
        return file_get_contents($this->path);
    }

}
