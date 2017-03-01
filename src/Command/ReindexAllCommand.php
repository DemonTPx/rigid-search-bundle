<?php

namespace Demontpx\RigidSearchBundle\Command;

use Demontpx\RigidSearchBundle\Search\SearchManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ReindexAllCommand
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class ReindexAllCommand extends Command
{
    /** @var SearchManager */
    private $manager;

    public function __construct(SearchManager $manager)
    {
        $this->manager = $manager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('demontpx:search:reindex:all');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->manager->reindexAll();
    }
}
