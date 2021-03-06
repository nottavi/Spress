<?php

/*
 * This file is part of the Yosymfony\Spress.
 *
 * (c) YoSymfony <http://github.com/yosymfony>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Yosymfony\Spress\Command;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yosymfony\Spress\Application;

class BuildCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('site:build')
            ->setDescription('Build your site')
            ->addOption(
                'source',
                's',
                InputOption::VALUE_OPTIONAL,
                'Directory where Spress will read your files'
            )
            ->addOption(
                'timezone',
                null,
                InputOption::VALUE_OPTIONAL,
                'Timezone for the site generator'
            )
            ->addOption(
                'drafts',
                null,
                InputOption::VALUE_NONE,
                'Parse your draft post'
            )
            ->addOption(
                'safe',
                null,
                InputOption::VALUE_NONE,
                'Disable your template plugins'
            );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timezone = $input->getOption('timezone');
        $drafts = $input->getOption('drafts');
        $safe = $input->getOption('safe');
        
        $output->writeln('<comment>Starting...</comment>');
        
        if($drafts)
        {
            $output->writeln('<comment>With posts drafts active.</comment>');
        }
        
        if($safe)
        {
            $output->writeln('<comment>Plugins disabled.</comment>');
        }
        
        $app = new Application();
        
        $resultData = $app->parse(
            $input->getOption('source'),
            $timezone,
            $drafts,
            $safe
        );
        
        $output->writeln(sprintf('Total posts: %d', $resultData['total_post']));
        $output->writeln(sprintf('Processed posts: %d', $resultData['processed_post']));
        $output->writeln(sprintf('Drafts post: %d', $resultData['drafts_post']));
        $output->writeln(sprintf('Total pages: %d', $resultData['total_pages']));
        $output->writeln(sprintf('Processed pages: %d', $resultData['processed_pages']));
        $output->writeln(sprintf('Other resources: %d', $resultData['other_resources']));
    }
}