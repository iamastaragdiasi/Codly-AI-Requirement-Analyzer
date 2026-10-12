<?php

namespace App;

class DocumentExtractor
{
    public function extract(string $format): never
    {
        throw new \InvalidArgumentException('File extraction is not supported. Submit text or structured forms.');
    }
}
