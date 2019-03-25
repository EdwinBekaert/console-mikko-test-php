<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 14/03/2019
 * Time: 16:01
 */

namespace test\Service;

use App\Service\Payday;
use App\Util\MissedStrategy;
use PHPUnit\Framework\TestCase;

class PaydayTest extends TestCase
{

    public function testPaydayWithoutConstructArgument(){
        $payday = new Payday();
        $this->assertEquals(strtotime('today'), $payday->getStartDate());
    }

    public function testPaydayInThePastShouldReturnNull()
    {
        $today = strtotime('-5 days');
        $payday = new Payday($today);
        $thisMonth = (int)date('n', $today);

        $result = $payday->getPaydayForMonth($thisMonth,date('j', $today), MissedStrategy::LastFriday);

        // assert that result is null
        $this->assertEquals(null, $result);
    }

    public function testPaydayCompliesWithStrategy()
    {
        $today = strtotime('2019-03-14'); // march has last day in weekend
        $payday = new Payday($today);
        $dayOfPay = '31';
        $thisMonth = 3; // a month of 31 days

        $result = $payday->getPaydayForMonth($thisMonth, $dayOfPay, MissedStrategy::LastFriday);
        // assert that payday is friday 29/03/2019
        $this->assertEquals(strtotime('2019-03-29'), $result);

        $result = $payday->getPaydayForMonth($thisMonth, $dayOfPay, MissedStrategy::NextMonday);
        // assert that payday is monday 01/04/2019
        $this->assertEquals(strtotime('2019-04-01'), $result);

        $result = $payday->getPaydayForMonth($thisMonth, $dayOfPay, MissedStrategy::NextWednesday);
        // assert that payday is monday 01/04/2019
        $this->assertEquals(strtotime('2019-04-03'), $result);

    }

    public function testPaydayIn30dayMonthOrLessWorks()
    {
        $today = strtotime('2019-01-14'); // march has last day in weekend
        $payday = new Payday($today);
        // assert that payday in april is 30/04/2019
        $result = $payday->getPaydayForMonth(4, 't', MissedStrategy::LastFriday);
        $this->assertEquals(strtotime('2019-04-30'), $result);
        // assert that payday in february is 28/02/2019
        $result = $payday->getPaydayForMonth(2, 't', MissedStrategy::LastFriday);
        $this->assertEquals(strtotime('2019-02-28'), $result);

    }

    public function testPaydayNextYearShouldReturnNull()
    {
        $today = strtotime('2017-12-01'); // 31/12/2017 is a sunday -> pay next monday... not allowed...
        $payday = new Payday($today);
        $thisMonth = (int)date('n', $today);

        $result = $payday->getPaydayForMonth($thisMonth,'31', MissedStrategy::NextMonday);

        // assert that result is null
        $this->assertEquals(null, $result);
    }
}
