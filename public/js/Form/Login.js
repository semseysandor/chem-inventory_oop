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
 * Submit login form
 */
$(function () {
    'use strict';
    $('#login-form-submit').click(function (event) {
        event.preventDefault();
        Inventory.AJAX.submit('login-form', 'response', Inventory.redirect, ['/']);
    });
});
