<?php
declare(strict_types=1);

namespace App\Command;

use App\Utils\MissedStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PaydayCommand extends Command
{

    public function __construct()
    {
        parent::__construct();

        // TODO: inject and initialize any services needed for the command here
    }

    protected function configure()
    {
        $this->setName('payday')
            ->setDescription('Generate CSV to determine the dates to pay salaries to the sales department.')
            ->setHelp('run php app payday.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dayOfSalary = '10';
        $dayOfBonus = 11;
        $paydaySalaryMissedStrategy = MissedStrategy::LastFriday;
        $paydayBonusMissedStrategy = MissedStrategy::NextWednesday;

        $today = strtotime('today');
        $thisMonth = date('n', $today);

        $output->writeln($today);
        $output->writeln($thisMonth);

        for ($month = $thisMonth; $month <= 12; $month++) {

            $output->writeln("doing the month: $month");
            $paydaySalary = strtotime(date("Y-$month-$dayOfSalary", $today));
            $paydayBonus = strtotime(date("Y-$month-$dayOfBonus", $today));

            $output->writeln("time of salary: $paydaySalary");
            $output->writeln('date of salary:' . date('d-m-Y', $paydaySalary));
            $output->writeln("time of Bonus: $paydayBonus");
            $output->writeln('date of Bonus:' . date('d-m-Y', $paydayBonus));

            $output->writeln('======== SALARY =========');
            if($paydaySalary >= $today) {
                switch (date('N', $paydaySalary)) {
                    case 6:
                    case 7:
                        $output->writeln('weekend');
                        // next monday
                        $paydaySalary = strtotime($paydaySalaryMissedStrategy, $paydaySalary);
                        $output->writeln("payday $paydaySalaryMissedStrategy: $paydaySalary");
                        $output->writeln(date('N', $paydaySalary));
                        $output->writeln('date of salary:' . date('d-m-Y', $paydaySalary));
                        break;
                    default:
                        $output->writeln('workday');
                        $output->writeln(date('N', $paydaySalary));
                        $output->writeln('date of salary:' . date('d-m-Y', $paydaySalary));
                }
            }

            $output->writeln('======== BONUS =========');
            if($paydayBonus >= $today) {
                switch (date('N', $paydayBonus)) {
                    case 6:
                    case 7:
                        $output->writeln('weekend');
                        // next wednesday
                        $paydayBonus = strtotime($paydayBonusMissedStrategy, $paydayBonus);
                        $output->writeln("payday $paydayBonusMissedStrategy: $paydayBonus");
                        $output->writeln(date('N', $paydayBonus));
                        $output->writeln('date of Bonus:' . date('d-m-Y', $paydayBonus));
                        break;
                    default:
                        $output->writeln('workday');
                        $output->writeln(date('N', $paydayBonus));
                        $output->writeln('date of Bonus:' . date('d-m-Y', $paydayBonus));
                }
            }
        }
    }
}

