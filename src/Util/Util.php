<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 25/03/2019
 * Time: 10:59
 */

namespace App\Util;

use InvalidArgumentException;

class Util
{
    static function unFalsify( string $errorMsg, Callable $callback, array $args) {
        $val = call_user_func_array($callback, $args);
        if($val === false) throw new InvalidArgumentException($errorMsg);
        return $val;
    }

    /* even though PHP docs state:
        strtotime ( string $time [, int $now = time() ] ) : int
       The promised return value of int is WRONG and should look more like:
        strtotime ( string $time [, int $now = time() ] ) : int || false
    */
    static function strtotime( string $time, ?int $now = null) : int {
        return self::unFalsify("not a valid date. received: $time",'strtotime', [$time, $now ?? time()]); // if now is null then time
    }

    static function fopen(string $filename, string $mode) {
        return self::unFalsify("Sorry, can't open file: $filename",'fopen', [$filename, $mode]);
    }

    static function fclose($handle = null) {
        if($handle !== null) fclose($handle);
    }

    static function fputcsv ( $handle , array $fields, string $delimiter = ",", string $enclosure = '"', string $escape_char = "\\" ) : int {
        return self::unFalsify("Sorry, can't write to file.",'fputcsv', [$handle, $fields, $delimiter, $enclosure, $escape_char]);
    }

    static function realpath ( string $path ) : string {
        return self::unFalsify("Sorry, can't find path: $path",'realpath', [$path]);
    }
}