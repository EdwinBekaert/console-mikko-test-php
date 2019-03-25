<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 14/03/2019
 * Time: 20:40
 */

namespace test\Command;

use App\Command\PaydayCommand;
use App\Service\Payday;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class PaydayCommandTest extends TestCase
{
    /**
     * @test
     */
    public function command_outputs_info()
    {
        $application = new Application();
        $payday = new Payday(null);
        $application->add(new PaydayCommand($payday));

        $command = $application->find('app:payday');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $output = $commandTester->getDisplay();
        $this->assertContains('10 months added in out/paydates.csv', $output);
    }
}
