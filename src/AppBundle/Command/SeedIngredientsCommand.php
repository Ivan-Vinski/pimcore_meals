<?php


namespace AppBundle\Command;


use AppBundle\Seeders\IngredientSeeder;
use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedIngredientsCommand extends AbstractCommand
{
    private $ingredientSeeder;

    public function __construct(IngredientSeeder $ingredientSeeder)
    {
        $this->ingredientSeeder = $ingredientSeeder;
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('seed:ingredients')
            ->setDescription('Description')
            ->addArgument('count', null, 'Data object count', null);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $count = $input->getArgument('count');

        if (!$count || $count < 1) {
            $output->writeln('Argument required: count');
            return 0;
        }

        $this->ingredientSeeder->seed($count);
        return 0;
    }
}
