<?php

namespace App\Services\Factory;

use App\Services\Reader\FtpFileReader;
use App\Services\Reader\LocalFileReader;
use App\Services\Reader\ReaderInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;

class ReaderFactory
{
    public function getReader(InputInterface $input): ReaderInterface
    {
        return match ($input->getOption('source')) {
            'local' => new LocalFileReader(storage_path('data/' . $input->getOption('localPath'))),
            'ftp' => new FtpFileReader($input->getOption('ftpServer'), $input->getOption('ftpPath'),  $input->getOption('ftpUser'),  $input->getOption('ftpPassword'), ),
            default => throw new InvalidArgumentException('Unknown source type'),
        };
    }
}
