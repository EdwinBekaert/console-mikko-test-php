<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 14/03/2019
 * Time: 15:51
 */

namespace App\Service;

use App\Util\Util;

class Payday
{

    private $startDate;

    public function __construct(int $startDay = null)
    {
        // TODO I have no idea how to autowire a construct param :: trick with null
        $this->startDate = $startDay ?? Util::strtotime('today');
    }

    public function getStartDate(){
        return $this->startDate;
    }

    // why $missedStrategy cannot be MissedStrategy class? PHP enum must be fixed...
    public function getPaydayForMonth(int $month, String $dayOfPay, String $missedStrategy) : ?int
    {

        $today = $this->startDate;
        $firstOfMonth = Util::strtotime(date('Y',$today)."-$month-1");
        $payday = Util::strtotime(date("Y-$month-$dayOfPay", $firstOfMonth));

        if($payday < $today) return null;
        switch (date('N', $payday)) {
            case 6:
            case 7:
                // weekend
                $payday = Util::strtotime($missedStrategy, $payday);
                if($payday < $today) return null; // make sure we are still in the future
                break;
        }
        if(date("Y",$payday) > date("Y",$today)) return null;
        return $payday;
    }
}
