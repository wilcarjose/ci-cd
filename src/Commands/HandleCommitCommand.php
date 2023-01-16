<?php
namespace Ampliffy\CiCd\Commands;

use Ampliffy\CiCd\Infrastructure\Log;
use Ampliffy\CiCd\Domain\Dto\CommitDto;
use Symfony\Component\Console\Command\Command;
use Ampliffy\CiCd\Domain\Services\CommitService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Ampliffy\CiCd\Domain\Services\RepositoryService;
use Symfony\Component\Console\Output\OutputInterface;
 
class HandleCommitCommand extends Command
{
    public function __construct(protected RepositoryService $repositoryService, protected CommitService $commitService)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('check-commit')
            ->setDescription('Checks which repositories have been affected by a commit')
            ->setHelp('It give you a list of repositories that were affected by a commit, it require git_path, commit_id and branch as a params.')
            ->addArgument('git_path', InputArgument::REQUIRED, 'Pass the git path.')
            ->addArgument('commit_id', InputArgument::REQUIRED, 'Pass the commit id.')
            ->addArgument('branch', InputArgument::REQUIRED, 'Pass the branch name.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Getting affected repositories... '));
        $output->writeln('git_path: ' . $input->getArgument('git_path'));
        $output->writeln('commit_id: ' . $input->getArgument('commit_id'));
        $output->writeln('branch: ' . $input->getArgument('branch'));
        $commitDto = CommitDto::fromInput($input);
        $affectedRepositories = $this->repositoryService->getAffectedByCommit($commitDto);
        $commit = $this->commitService->store($commitDto);
        $this->commitService->attachAffectedRepositories($commit, $affectedRepositories);

        $affectedRepositories->map(function($repository) use ($output){
            $output->writeln('Affected repository: ' . $repository->getComposerName());
            Log::debug('Repositorio afectado: ' . $repository->getComposerName());
        });
        
        return Command::SUCCESS;
    }
}