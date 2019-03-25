<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 25/03/2019
 * Time: 11:13
 */

namespace Tests\Util;

use App\Util\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{

    public function testUnFalsifyThrows()
    {
        $errorMsg = 'not a valid date';
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage($errorMsg);
        Util::unFalsify($errorMsg, 'strtotime', ['Some illegal date']);
    }

    public function testUnFalsifyValid()
    {
        $errorMsg = 'not a valid date';
        $accepted = strtotime('today');
        $actual = Util::unFalsify($errorMsg, 'strtotime', ['today']);
        $this->assertEquals($accepted,$actual);
    }

    public function testStrToTimeThrows()
    {
        $this->expectException('InvalidArgumentException');
        Util::strtotime('illegal date as well');
    }

    public function testStrToTimeValid()
    {
        $accepted = strtotime('yesterday');
        $actual  = Util::strtotime('yesterday');
        $this->assertEquals($accepted,$actual);
    }

    public function testDateThrows()
    {
        $this->expectException('InvalidArgumentException');
        Util::date('d-m-Y', strtotime('illegal date as well'));
    }
}
