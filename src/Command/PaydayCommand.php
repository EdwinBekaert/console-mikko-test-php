<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Payday;
use App\Util\MissedStrategy;
use App\Util\Util;
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
        $dayOfSalary = 't'; // t is last day of month
        $dayOfBonus = '15';
        $paydaySalaryMissedStrategy = MissedStrategy::LastFriday;
        $paydayBonusMissedStrategy = MissedStrategy::NextWednesday;
        $dateFormat = 'd-m-Y';
        $filename = 'out/paydates.csv';
        $filepath = realpath(__DIR__ . '/../../' . $filename);

        $today = Util::strtotime('today');
        $thisMonth = (int)date('n', $today);

        try {

            $file = Util::fopen($filepath, 'w');

            for ($month = $thisMonth; $month <= 12; $month++) {
                $paydaySalary = $this->payday->getPaydayForMonth($month, $dayOfSalary, $paydaySalaryMissedStrategy);
                $paydayBonus = $this->payday->getPaydayForMonth($month, $dayOfBonus, $paydayBonusMissedStrategy);
                $monthName = date('F', Util::strtotime("2019-$month-1"));
                $paydaySalaryFormatted = $paydaySalary == null ? $paydaySalary : date($dateFormat, $paydaySalary);
                $paydayBonusFormatted = $paydayBonus == null ? $paydayBonus : date($dateFormat, $paydayBonus);
                $csvData = [$monthName, $paydaySalaryFormatted, $paydayBonusFormatted];
                fputcsv($file, $csvData);
            }
            fclose($file);
            $msg = count(file($filepath));
            $msg .= " months added in $filename";
            $output->write($msg);

        } catch (Throwable $t) {
            $output->writeln($t->getMessage());
        }

    }
}

