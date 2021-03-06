/*
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020                                |
 | Sandor Semsey <semseysandor@gmail.com>        |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

/**
 * jQuery utility plugin
 */
(function ($) {
    'use strict';

    /**
     * Clear contents of elements
     */
    $.fn.clear = function () {
        this.html('');
    };
}(jQuery));

