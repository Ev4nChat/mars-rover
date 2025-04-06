<?php

namespace Tests\Command;

use App\Command\MarsRoverCommand;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class MarsRoverCommandTest extends TestCase
{
    public function testHappyPath(): void
    {
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2 N',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Rover 1 Final Position: 1 3 N', $output);
        $this->assertStringContainsString('Rover 2 Final Position: 5 1 E', $output);
    }

    public function testInvalidPlateauSize(): void
    {
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'plateau' => '-5 -5',
            'rover1' => '1 2 N',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Invalid plateau size.', $output);
    }

    public function testInvalidRoverPosition(): void
    {
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2 X',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Invalid rover 1 position or orientation', $output);

        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2 N',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3 A',
            'instructions2' => 'MMRMMRMRRM'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Invalid rover 2 position or orientation', $output);
    }

    public function testInvalidArrayPositionCount(): void
    {
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Invalid rover 1 position or orientation', $output);

        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2 N',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3',
            'instructions2' => 'MMRMMRMRRM'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Invalid rover 2 position or orientation', $output);
    }

    public function testRoverIsNotWithinLimits(): void
    {
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '6 6 N',
            'instructions1' => 'MMRMMRMRRM',
            'rover2' => '3 3 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Invalid rover 1 position or orientation.', $output);

        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2 N',
            'instructions1' => 'MMRMMRMRRM',
            'rover2' => '6 6 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Invalid rover 2 position or orientation.', $output);
    }

    public function testInvalidPlateauDimensions(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'plateau' => null,
            'rover1' => '1 2 N',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);
    }

    public function testInvalidRover1Position(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => null,
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);
    }

    public function testInvalidRover1Instructions(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2 N',
            'instructions1' => null,
            'rover2' => '3 3 E',
            'instructions2' => 'MMRMMRMRRM'
        ]);
    }

    public function testInvalidRover2Position(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2 N',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => null,
            'instructions2' => 'MMRMMRMRRM'
        ]);
    }

    public function testInvalidRover2Instructions(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $application = new Application();
        $command = new MarsRoverCommand('app:mars-rover');
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'plateau' => '5 5',
            'rover1' => '1 2 N',
            'instructions1' => 'LMLMLMLMM',
            'rover2' => '3 3 E',
            'instructions2' => null
        ]);
    }
}
