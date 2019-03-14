<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 14/03/2019
 * Time: 16:01
 */

namespace App\Service;


use App\Util\MissedStrategy;
use PHPUnit\Framework\TestCase;

class PaydayTest extends TestCase
{

    public function testPaydayInThePastShouldReturnNull()
    {
        $today = strtotime('-5 days');
        $payday = new Payday($today);
        $thisMonth = date('n', $today);

        $result = $payday->getPaydayForMonth($thisMonth,date('j', $today),MissedStrategy::LastFriday);

        // assert that result is null
        $this->assertEquals(null, $result);
    }

    public function testPaydayCompliesWithStrategy()
    {
        $today = strtotime('2019-03-14'); // march has last day in weekenddate('d-m-Y', $paydayBonus)date('d-m-Y', $paydayBonus)
        $payday = new Payday($today);
        $dayOfPay = 31;
        $thisMonth = date('n', $today);

        $result = $payday->getPaydayForMonth($thisMonth, $dayOfPay,MissedStrategy::LastFriday);
        // assert that payday is friday 29/03/2019
        $this->assertEquals(strtotime('2019-03-29'), $result);

        $result = $payday->getPaydayForMonth($thisMonth, $dayOfPay,MissedStrategy::NextMonday);
        // assert that payday is monday 01/04/2019
        $this->assertEquals(strtotime('2019-04-01'), $result);

        $result = $payday->getPaydayForMonth($thisMonth, $dayOfPay,MissedStrategy::NextWednesday);
        // assert that payday is monday 01/04/2019
        $this->assertEquals(strtotime('2019-04-03'), $result);

    }

    public function testPaydayNextYearShouldReturnNull()
    {
        $today = strtotime('2017-12-01'); // 31/12/2017 is a sunday -> pay next monday... not allowed...
        $payday = new Payday($today);
        $thisMonth = date('n', $today);

        $result = $payday->getPaydayForMonth($thisMonth,31,MissedStrategy::NextMonday);

        // assert that result is null
        $this->assertEquals(null, $result);
    }
}
