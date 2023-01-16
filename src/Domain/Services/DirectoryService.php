<?php

namespace Ampliffy\CiCd\Domain\Services;

use Doctrine\Common\Collections\ArrayCollection;

class DirectoryService
{
    public function getDirectoriesNamesFromBasePath() : ArrayCollection
    {
        $directories = scandir($_ENV['BASE_PATH']);

        if ($directories === false) {
            return new ArrayCollection();
        }

        return (new ArrayCollection($directories))
            ->filter(fn ($dir) => $this->isDirectory($dir))
            ->map(fn ($dir) => $this->getDirectory($dir));
    }

    protected function isDirectory(string $name) : bool
    {
        return is_dir($_ENV['BASE_PATH'] . $name);
    }

    protected function getDirectory(string $name) : string
    {
        return $_ENV['BASE_PATH'] . $name;
    }
}