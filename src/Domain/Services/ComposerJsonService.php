<?php

namespace Ampliffy\CiCd\Domain\Services;

use Ampliffy\CiCd\Infrastructure\Log;
use Doctrine\Common\Collections\ArrayCollection;
use Ampliffy\CiCd\Domain\Exceptions\DoesNotExistComposerFileException;

class ComposerJsonService
{
    public function getComposerFile(string $path) : string
    {
        $file = $_ENV['BASE_PATH'] . $path . '/composer.json';

        if (!file_exists($file)) {
            throw new DoesNotExistComposerFileException('Composer file does not exists: ' . $file); 
        }

        return $file;
    }

    public function composerFileModifiedAt(string $path) : int
    {
        return filemtime($this->getComposerFile($path));
    }

    public function getComposerContent(string $path) : array
    {
        $content = file_get_contents($this->getComposerFile($path));
        
        return json_decode($content, true);
    }

    public function librariesRequired(string $path) : ArrayCollection
    {
        $content = $this->getComposerContent($path);

        $libraries = ($content['require'] ?? []) + ($content['require-dev'] ?? []);

        return new ArrayCollection(array_keys($libraries));
    }
}