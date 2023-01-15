<?php

namespace Ampliffy\CiCd\Domain\Dto;

use Symfony\Component\Console\Input\InputInterface;

class RepositoryDto
{
    public function __construct(
        public readonly string $composer_name,
        public readonly string $git_path,
        public readonly string $type
    ) {}

    public static function fromComposerJson(array $composerData, string $path): self
    {
        return new static(
            composer_name: $composerData['name'],
            git_path: $path,
            type: $composerData['type'] ?? 'library',
        );
    }

    public function toArray() : array
    {
        return [
            'composer_name' => $this->composer_name,
            'git_path' => $this->git_path,
            'type' => $this->type
        ];
    }
}
