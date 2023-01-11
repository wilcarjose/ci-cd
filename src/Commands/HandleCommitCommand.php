<?php
namespace Ampliffy\CiCd\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class HandleCommitCommand extends Command
{
    protected function configure()
    {
        $this->setName('check-commit')
            ->setDescription('Checks which repositories have been affected by a commit')
            ->setHelp('It give you a list of repositories that were affected by a commit, it require git_url, commit_id and branch as a params.')
            ->addArgument('git_url', InputArgument::REQUIRED, 'Pass the git url.')
            ->addArgument('commit_id', InputArgument::REQUIRED, 'Pass the commit id.')
            ->addArgument('branch', InputArgument::REQUIRED, 'Pass the branch name.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Getting repositories affected ... '));
        $output->writeln(sprintf('url: %s, commit id: %s, branch: %s', $input->getArgument('git_url'), $input->getArgument('commit_id'), $input->getArgument('branch')));
        return Command::SUCCESS;
    }
}