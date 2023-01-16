<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Ampliffy\CiCd\Domain\Services\ComposerJsonService;
use Ampliffy\CiCd\Domain\Exceptions\DoesNotExistComposerFileException;

class ComposerJsonServiceTest extends TestCase
{

    /** @test */
    public function throw_exception_when_composer_file_does_not_exists() : void
    {
        $this->expectException(DoesNotExistComposerFileException::class);

        $composerJsonService = new ComposerJsonService;

        $repositoryFolderName = 'wrong_folder_name';
        $composerJsonService->getComposerFile($repositoryFolderName);     
    }
 }