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
        $payday = new Payday();
        $today = strtotime('-5 days');
        $thisMonth = date('n', $today);

        $result = $payday->getPaydayForMonth($thisMonth,date('j', $today),MissedStrategy::LastFriday);

        // assert that result is null
        $this->assertEquals(null, $result);
    }

    public function testPaydayCompliesWithStrategy()
    {
        $payday = new Payday();
        $today = strtotime('2019-03-14'); // march has last day in weekenddate('d-m-Y', $paydayBonus)date('d-m-Y', $paydayBonus)
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
}
