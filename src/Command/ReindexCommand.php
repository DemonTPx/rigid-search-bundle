<?php

namespace Demontpx\RigidSearchBundle\Command;

use Demontpx\RigidSearchBundle\Search\SearchManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ReindexCommand
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class ReindexCommand extends Command
{
    /** @var SearchManager */
    private $manager;

    /**
     * @param SearchManager $manager
     */
    public function __construct(SearchManager $manager)
    {
        $this->manager = $manager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('demontpx:search:reindex:type')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the type which should be reindexed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $this->manager->reindex($name);
    }
}
