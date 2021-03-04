<?php


namespace AppBundle\Command;


use AppBundle\Seeders\MealSeeder;
use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedMealCommand extends AbstractCommand
{
    private $mealSeeder;

    public function __construct(MealSeeder $mealSeeder)
    {
        $this->mealSeeder = $mealSeeder;
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('seed:meal')
            ->setDescription('Populates database table defined in argument with faker data')
            ->addArgument('count', null, 'Data object count', null);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output) : int
    {
        $count = $input->getArgument('count');

        if (!$count || $count < 1) {
            $output->writeln('Argument required: count');
            return 0;
        }

        $this->mealSeeder->seed($count);
        return 0;
    }

}
