<?php

namespace App\Command;

use App\Plateau;
use App\Rover;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class MarsRoverCommand extends Command
{
    protected function configure()
    {
        $this
            ->setDescription('Simulate the movement of two rovers on a plateau.')
            ->addArgument('plateau', InputArgument::REQUIRED, 'The plateau dimensions (xMax yMax)')
            ->addArgument(
                'rover1',
                InputArgument::REQUIRED,
                'The first rover position and orientation (x y orientation)'
            )
            ->addArgument('instructions1', InputArgument::REQUIRED, 'The first rover instructions (L, R, M)')
            ->addArgument(
                'rover2',
                InputArgument::REQUIRED,
                'The second rover position and orientation (x y orientation)'
            )
            ->addArgument('instructions2', InputArgument::REQUIRED, 'The second rover instructions (L, R, M)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Get input arguments
        $plateauDimensions = $input->getArgument('plateau');
        $rover1Position = $input->getArgument('rover1');
        $rover2Position = $input->getArgument('rover2');
        $instructions1 = $input->getArgument('instructions1');
        $instructions2 = $input->getArgument('instructions2');

        if (is_string($plateauDimensions)) {
            $plateauDimensions = explode(' ', $plateauDimensions);
        } else {
            throw new InvalidArgumentException('Invalid argument for plateau.');
        }

        if (is_string($rover1Position)) {
            $rover1Position = explode(' ', $rover1Position);
        } else {
            throw new InvalidArgumentException('Invalid argument for rover1.');
        }

        if (is_string($rover2Position)) {
            $rover2Position = explode(' ', $rover2Position);
        } else {
            throw new InvalidArgumentException('Invalid argument for rover2.');
        }

        if (!is_string($instructions1)) {
            throw new InvalidArgumentException('Invalid argument for instructions1.');
        }

        if (!is_string($instructions2)) {
            throw new InvalidArgumentException('Invalid argument for instructions2.');
        }

        // Initialize the plateau and rovers
        if (count($plateauDimensions) !== 2 || (int)$plateauDimensions[0] <= 0 || (int)$plateauDimensions[1] <= 0) {
            $output->writeln('<error>Invalid plateau size.</error>');
            return Command::FAILURE;
        }

        $plateau = new Plateau((int)$plateauDimensions[0], (int)$plateauDimensions[1]);

        $rover1Position[0] = (int)$rover1Position[0];
        $rover1Position[1] = (int)$rover1Position[1];
        $rover1Position[2] = (string)$rover1Position[2];

        if (!$this->isValidRoverPosition($rover1Position, $plateau)) {
            $output->writeln('<error>Invalid rover 1 position or orientation.</error>');
            return Command::FAILURE;
        }

        $rover1 = new Rover($rover1Position[0], $rover1Position[1], $rover1Position[2], $plateau);

        $rover2Position[0] = (int)$rover2Position[0];
        $rover2Position[1] = (int)$rover2Position[1];
        $rover2Position[2] = (string)$rover2Position[2];

        if (!$this->isValidRoverPosition($rover2Position, $plateau)) {
            $output->writeln('<error>Invalid rover 2 position or orientation.</error>');
            return Command::FAILURE;
        }

        $rover2 = new Rover($rover2Position[0], $rover2Position[1], $rover2Position[2], $plateau);

        // Process the instructions for both rovers
        $result1 = $rover1->readAndProcessInstructions($instructions1);
        $result2 = $rover2->readAndProcessInstructions($instructions2);

        // Output the final positions
        $output->writeln('Rover 1 Final Position: ' . $result1);
        $output->writeln('Rover 2 Final Position: ' . $result2);

        return Command::SUCCESS;
    }

    /**
     * @param array{0: int, 1: int, 2: string} $position The rover's position [x, y, orientation].
     * @param Plateau $plateau
     * @return bool
     */
    private function isValidRoverPosition(array $position, Plateau $plateau): bool
    {
        // Check that x and y are valid numbers and within plateau limits
        $x = (int)$position[0];
        $y = (int)$position[1];
        $orientation = $position[2];
        if (!$plateau->isWithinLimits($x, $y)) {
            return false;
        }

        // Check that orientation is one of 'N', 'E', 'S', 'W'
        $validOrientations = ['N', 'E', 'S', 'W'];
        if (!in_array($orientation, $validOrientations)) {
            return false;
        }

        return true;
    }
}
