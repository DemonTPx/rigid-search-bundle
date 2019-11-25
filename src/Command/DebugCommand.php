<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Command;

use Demontpx\RigidSearchBundle\Search\ItemSearchManagerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright 2015 Bert Hekman
 */
class DebugCommand extends Command
{
    /** @var ItemSearchManagerFactory */
    private $factory;

    public function __construct(ItemSearchManagerFactory $factory)
    {
        parent::__construct();

        $this->factory = $factory;
    }

    protected function configure()
    {
        $this->setName('demontpx:search:debug')
            ->setDescription('Show all registered item search managers and their settings');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $managerList = $this->factory->getAll();

        $output->writeln('<comment>Registered item search managers</comment>');
        foreach ($managerList as $manager) {
            $output->writeln('  <comment>' . $manager->getType() . '</comment>');
            $output->writeln('    class     <info>' . $manager->getClass() . '</info>');
            $output->writeln('    extractor <info>' . get_class($manager->getDocumentExtractor()) . '</info>');
        }

        return 0;
    }
}
