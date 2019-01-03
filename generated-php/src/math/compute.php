<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\Math;

use HH\Lib\{C, Str};
use const HH\Lib\_Private\ALPHABET_ALPHANUMERIC;
/**
 * @template T as numeric
 *
 * @param T $number
 *
 * @return T
 */
function abs($number)
{
    return $number < 0 ? -$number : $number;
}
function base_convert(string $value, int $from_base, int $to_base) : string
{
    invariant($value !== '', 'Unexpected empty string, expected number in base %d', $from_base);
    invariant($from_base >= 2 && $from_base <= 36, 'Expected $from_base to be between 2 and 36, got %d', $from_base);
    invariant($to_base >= 2 && $to_base <= 36, 'Expected $to_base to be between 2 and 36, got %d', $to_base);
    invariant(\bcscale(0) === true, 'Unexpected bcscale failure');
    $from_alphabet = Str\slice(ALPHABET_ALPHANUMERIC, 0, $from_base);
    $result_decimal = '0';
    $place_value = \bcpow((string) $from_base, (string) (\strlen($value) - 1));
    foreach (Str\chunk($value) as $digit) {
        $digit_numeric = Str\search_ci($from_alphabet, $digit);
        invariant($digit_numeric !== null, 'Invalid digit %s in base %d', $digit, $from_base);
        $result_decimal = \bcadd($result_decimal, \bcmul((string) $digit_numeric, $place_value));
        $place_value = \bcdiv((string) $place_value, (string) $from_base);
    }
    if ($to_base === 10) {
        return $result_decimal;
    }
    $to_alphabet = Str\slice(ALPHABET_ALPHANUMERIC, 0, $to_base);
    $result = '';
    do {
        $result = $to_alphabet[\bcmod($result_decimal, (string) $to_base)] . $result;
        $result_decimal = \bcdiv((string) $result_decimal, (string) $to_base);
    } while (\bccomp($result_decimal, '0') > 0);
    return $result;
}
function ceil($value) : float
{
    return \ceil($value);
}
function cos($arg) : float
{
    return \cos($arg);
}
function from_base(string $number, int $from_base) : int
{
    $result_string = base_convert($number, $from_base, 10);
    $result = Str\to_int($result_string);
    invariant($result !== null, 'Unexpected integer overflow parsing %s from base %d', $number, $from_base);
    return $result;
}
function exp($arg) : float
{
    return \exp($arg);
}
function floor($value) : float
{
    return \floor($value);
}
function int_div(int $numerator, int $denominator) : int
{
    if ($denominator === 0) {
        throw new DivisionByZeroException();
    }
    return \intdiv($numerator, $denominator);
}
function log($arg, $base = null) : float
{
    invariant($arg > 0, 'Expected positive argument for log, got %f', $arg);
    if ($base === null) {
        return \log($arg);
    }
    invariant($base > 0, 'Expected positive base for log, got %f', $base);
    invariant($base !== 1, 'Logarithm undefined for base 1');
    return \log($arg, $base);
}
function round($val, int $precision = 0) : float
{
    return \round($val, $precision);
}
function sin($arg) : float
{
    return \sin($arg);
}
function sqrt($arg) : float
{
    invariant($arg >= 0, 'Expected non-negative argument to sqrt, got %f', $arg);
    return \sqrt($arg);
}
function tan($arg) : float
{
    return \tan($arg);
}
function to_base(int $number, int $to_base) : string
{
    invariant($to_base >= 2 && $to_base <= 36, 'Expected $to_base to be between 2 and 36, got %d', $to_base);
    invariant($number >= 0, 'Expected non-negative base conversion input, got %d', $number);
    return base_convert((string) $number, 10, $to_base);
}

