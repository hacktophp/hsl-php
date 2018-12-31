<?php
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace HH\Lib\Str;

/**
 * @param iterable<mixed, \arraykey> $pieces
 *
 * @return string
 */
function join(iterable $pieces, string $glue)
{
    if ($pieces instanceof Container) {
        return \implode($glue, $pieces);
    }
    return \implode($glue, (array) $pieces);
}

