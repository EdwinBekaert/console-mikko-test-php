<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 14/03/2019
 * Time: 15:51
 */

namespace App\Service;

use App\Util\MissedStrategy;

class Payday
{

    private $today;

    public function __construct(int $startDay = null)
    {
        // TODO I have no idea how to autowire a construct param :: trick with null
        $this->today = $startDay == null ? strtotime('today') : $startDay;
    }

    public function getPaydayForMonth(int $month, String $dayOfPay, string $missedStrategy) // why $missedStrategy cannot be MissedStrategy class?
    {
        $today = $this->today; // strtotime('today');
        $firstOfMonth = strtotime(date('Y',$today)."-$month-1");
        $payday = strtotime(date("Y-$month-$dayOfPay", $firstOfMonth));

        if($payday < $today) return null;
        switch (date('N', $payday)) {
            case 6:
            case 7:
                // weekend
                $payday = strtotime($missedStrategy, $payday);
                if($payday < $today) return null; // make sure we are still in the future
                break;
        }
        if(date("Y",$payday) > date("Y",$today)) return null;
        return $payday;
    }
}
