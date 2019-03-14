<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Payday;
use App\Util\MissedStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PaydayCommand extends Command
{

    private $payday;

    public function __construct(Payday $payday)
    {
        $this->payday = $payday;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:payday')
            ->setDescription('Generate CSV to determine the dates to pay salaries to the sales department.')
            ->setHelp('php app app:payday.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dayOfSalary = 't';
        $dayOfBonus = '15';
        $paydaySalaryMissedStrategy = MissedStrategy::LastFriday;
        $paydayBonusMissedStrategy = MissedStrategy::NextWednesday;

        $today = strtotime('today');
        $thisMonth = (int)date('n', $today);

        $output->writeln($today);
        $output->writeln($thisMonth);

        for ($month = $thisMonth; $month <= 12; $month++) {

            $paydaySalary = $this->payday->getPaydayForMonth($month, $dayOfSalary, $paydaySalaryMissedStrategy);
            $paydayBonus = $this->payday->getPaydayForMonth($month, $dayOfBonus, $paydayBonusMissedStrategy);
            $monthName = date('F',strtotime("2019-$month-1"));
            $output->writeln("doing the month: $month ($monthName)");
            if($paydaySalary != null) $output->writeln('date of salary:' . date('d-m-Y', $paydaySalary));
            if($paydayBonus != null) $output->writeln('date of Bonus:' . date('d-m-Y', $paydayBonus));

        }
    }
}

