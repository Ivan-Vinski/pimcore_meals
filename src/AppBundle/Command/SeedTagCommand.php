<?php


namespace AppBundle\Command;


use AppBundle\Seeders\TagSeeder;
use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedTagCommand extends AbstractCommand
{
    private $tagSeeder;

    public function __construct(TagSeeder $tagSeeder)
    {
        $this->tagSeeder = $tagSeeder;
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('seed:tag')
            ->setDescription('Populates database table defined in arguments with faker data')
            ->addArgument('count', null, 'Data object count', null);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $count = $input->getArgument('count');

        if (!$count || $count < 0) {
            $output->writeln('Invalid argument: count');
            return 0;
        }

        $this->tagSeeder->seed($count);
        return 0;
    }
}
