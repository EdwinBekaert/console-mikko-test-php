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
    public function getPaydayForMonth(int $month, int $dayOfPay, string $missedStrategy) // why $missedStrategy cannot be MissedStrategy class?
    {
        $today = strtotime('today');
        $payday = strtotime(date("Y-$month-$dayOfPay", $today));
        if($payday < $today) return null;
        switch (date('N', $payday)) {
            case 6:
            case 7:
                // weekend
                $payday = strtotime($missedStrategy, $payday);
                if($payday < $today) return null; // make sure we are still in the future
                break;
        }
        return $payday;
    }
}