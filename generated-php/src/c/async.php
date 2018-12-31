<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
/**
 * C is for Containers. This file contains async functions that operate on containers
 * and traversables.
 */
namespace HH\Lib\C;

/**
 * Returns the first element of the result of the given Awaitable, or null if
 * the Traversable is empty.
 *
 * For non-Awaitable Traversables, see `C\first`.
 */
/**
 * @psalm-template T
 *
 * @param \Sabre\Event\Promise<iterable<mixed, T>> $awaitable
 *
 * @return \Sabre\Event\Promise<null|T>
 */
function first_async(\Sabre\Event\Promise $awaitable)
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, null|T> */
        function () use($awaitable) : \Generator {
            $traversable = (yield $awaitable);
            return first($traversable);
        }
    );
}
/**
 * Returns the first element of the result of the given Awaitable, or throws if
 * the Traversable is empty.
 *
 * For non-Awaitable Traversables, see `C\firstx`.
 */
/**
 * @psalm-template T
 *
 * @param \Sabre\Event\Promise<iterable<mixed, T>> $awaitable
 *
 * @return \Sabre\Event\Promise<T>
 */
function firstx_async(\Sabre\Event\Promise $awaitable)
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, T> */
        function () use($awaitable) : \Generator {
            $traversable = (yield $awaitable);
            return firstx($traversable);
        }
    );
}

