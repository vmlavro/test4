<?php

namespace App\Services\Reader;

class FtpFileReader implements ReaderInterface {

    public function __construct(
        private string $server,
        private string $path,
        private string $user,
        private string $password)
    {}

    public function getContent(): string
    {
        return file_get_contents('ftp://' . $this->user . ':' . $this->password . '@' . $this->server . '/' . $this->path);
    }

}
