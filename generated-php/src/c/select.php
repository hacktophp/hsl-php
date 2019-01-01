<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\C;

use HH\Lib\_Private;
use HH\Lib\Str;
/**
 * @psalm-template T
 *
 * @param iterable<mixed, T> $traversable
 * @param \Closure(T):bool $value_predicate
 *
 * @return null|T
 */
function find(iterable $traversable, \Closure $value_predicate)
{
    foreach ($traversable as $value) {
        if ($value_predicate($value)) {
            return $value;
        }
    }
    return null;
}
/**
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 * @param \Closure(Tv):bool $value_predicate
 *
 * @return null|Tk
 */
function find_key(iterable $traversable, \Closure $value_predicate)
{
    foreach ($traversable as $key => $value) {
        if ($value_predicate($value)) {
            return $key;
        }
    }
    return null;
}
/**
 * @psalm-template T
 *
 * @param iterable<mixed, T> $traversable
 *
 * @return null|T
 */
function first(iterable $traversable)
{
    foreach ($traversable as $value) {
        return $value;
    }
    return null;
}
/**
 * @psalm-template T
 *
 * @param iterable<mixed, T> $traversable
 *
 * @return T
 */
function firstx(iterable $traversable)
{
    foreach ($traversable as $value) {
        return $value;
    }
    invariant_violation('%s: Expected at least one element.', __FUNCTION__);
}
/**
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return null|Tk
 */
function first_key(iterable $traversable)
{
    if ($traversable !== null) {
        foreach ($traversable as $key => $_) {
            return $key;
        }
    }
    return null;
}
/**
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return Tk
 */
function first_keyx(iterable $traversable)
{
    foreach ($traversable as $key => $_) {
        return $key;
    }
    invariant_violation('%s: Expected at least one element.', __FUNCTION__);
}
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return null|Tv
 */
function last(iterable $traversable)
{
    if (\is_array($traversable)) {
        return count($traversable) === 0 ? null : $traversable[count($traversable) - 1];
    } else {
        if (_Private\is_any_array($traversable)) {
            return $traversable ? \end($traversable) : null;
        } else {
            if ($traversable instanceof Iterable) {
                return $traversable->lastValue();
            }
        }
    }
    $value = null;
    foreach ($traversable as $value) {
    }
    return $value;
}
/**
 * @psalm-template Tv
 *
 * @param iterable<mixed, Tv> $traversable
 *
 * @return Tv
 */
function lastx(iterable $traversable)
{
    if (\is_array($traversable)) {
        $count = count($traversable);
        invariant($count > 0, '%s: Expected non-empty input', __FUNCTION__);
        return $traversable[$count - 1];
    }
    if (_Private\is_any_array($traversable)) {
        invariant($traversable, '%s: Expected non-empty input', __FUNCTION__);
        return \end($traversable);
    }
    // There is no way to directly check whether an Iterable is empty,
    // so check if it is a builtin and, if so, do the check intelligently
    if ($traversable instanceof \ConstCollection) {
        invariant(!$traversable->isEmpty(), '%s: Expected non-empty input', __FUNCTION__);
        return $traversable->lastValue();
    }
    $value = null;
    $did_iterate = false;
    foreach ($traversable as $value) {
        $did_iterate = true;
    }
    invariant($did_iterate, '%s: Expected non-empty input', __FUNCTION__);
    // the foreach may not run. But the invariant above ensures it does.
    return $value;
}
/**
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return null|Tk
 */
function last_key(iterable $traversable)
{
    if (\is_array($traversable)) {
        return count($traversable) === 0 ? null : count($traversable) - 1;
    } else {
        if (_Private\is_any_array($traversable)) {
            if (!$traversable) {
                return null;
            }
            \end($traversable);
            return \key($traversable);
        } else {
            if ($traversable instanceof KeyedIterable) {
                return $traversable->lastKey();
            }
        }
    }
    $key = null;
    foreach ($traversable as $key => $_) {
    }
    return $key;
}
/**
 * @psalm-template Tk
 * @psalm-template Tv
 *
 * @param iterable<Tk, Tv> $traversable
 *
 * @return Tk
 */
function last_keyx(iterable $traversable)
{
    $last_key = last_key($traversable);
    invariant($last_key !== null, '%s: Expected non-empty input', __FUNCTION__);
    return $last_key;
}
/**
 * @psalm-template T
 *
 * @param iterable<mixed, T>|null $traversable
 *
 * @return null|T
 */
function nfirst(?iterable $traversable)
{
    if ($traversable !== null) {
        foreach ($traversable as $value) {
            return $value;
        }
    }
    return null;
}
/**
 * @psalm-template T
 *
 * @param iterable<mixed, T> $traversable
 * @param mixed $format_args
 *
 * @return T
 */
function onlyx(iterable $traversable, ?Str\SprintfFormatString $format_string = null, ...$format_args)
{
    $first = true;
    $result = null;
    foreach ($traversable as $value) {
        invariant($first, '%s', $format_string === null ? Str\format('Expected exactly one element%s.', $traversable instanceof Container ? ' but got ' . count($traversable) : '') : \vsprintf($format_string, $format_args));
        $result = $value;
        $first = false;
    }
    invariant($first === false, '%s', $format_string === null ? 'Expected non-empty Traversable.' : \vsprintf($format_string, $format_args));
    return $result;
}

