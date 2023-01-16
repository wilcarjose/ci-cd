<?php

namespace Ampliffy\CiCd\Domain\Services;

use Ampliffy\CiCd\Infrastructure\Log;
use Doctrine\Common\Collections\ArrayCollection;
use Ampliffy\CiCd\Domain\Exceptions\DoesNotExistComposerFileException;

class ComposerJsonService
{
    public function getComposerFile(string $path, $relativePath = false) : string
    { 
        $file = $relativePath
            ? $_ENV['BASE_PATH'] . $path . '/composer.json'
            : $path . '/composer.json';

        if (!file_exists($file)) {
            throw new DoesNotExistComposerFileException('Composer file does not exists: ' . $file); 
        }

        return $file;
    }

    public function composerFileModifiedAt(string $path, $relativePath = false) : int
    {
        return filemtime($this->getComposerFile($path, $relativePath));
    }

    public function getComposerContent(string $path, $relativePath = false) : array
    {
        $content = file_get_contents($this->getComposerFile($path, $relativePath));
        
        return json_decode($content, true);
    }

    public function librariesRequired(string $path, $relativePath = false) : ArrayCollection
    {
        $content = $this->getComposerContent($path, $relativePath);

        $libraries = ($content['require'] ?? []) + ($content['require-dev'] ?? []);

        return new ArrayCollection(array_keys($libraries));
    }

    public function getComposerName(string $path, $relativePath = false) : string
    {
        $content = $this->getComposerContent($path, $relativePath);

        return $content['name'] ?? '';
    }
}