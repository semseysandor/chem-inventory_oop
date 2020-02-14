<?php
/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c)  2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

if (!function_exists('sysMsg')) {
    function sysMsg(string $systemMsg)
    {
        switch ($systemMsg) {
            case 'sql_fail':
                return 'SQL operation failed';
            default:
                return $systemMsg;
        }
    }
}

