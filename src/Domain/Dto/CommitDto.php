<?php

namespace Ampliffy\CiCd\Domain\Dto;

use Symfony\Component\Console\Input\InputInterface;

class CommitDto
{
    public function __construct(
        public readonly string $commit_id,
        public readonly string $git_path,
        public readonly string $branch
    ) {}

    public static function fromInput(InputInterface $input): self
    {
        return new static(
            commit_id: $input->getArgument('commit_id'),
            git_path: $input->getArgument('git_path'),
            branch: $input->getArgument('branch'),
        );
    }

    public static function fromRequest($request): self
    {
        // it can be useful to make this dto from http requests
        return new static(
            commit_id: $request->commit_id,
            git_path: $request->git_path,
            branch: $request->branch,
        );
    }

    public function toArray() : array
    {
        return [
            'commit_id' => $this->commit_id,
            'git_path' => $this->git_path,
            'branch' => $this->branch
        ];
    }
}
