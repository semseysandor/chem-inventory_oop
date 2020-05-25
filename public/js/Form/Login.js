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
 * Login form
 */
$(document).ready(function () {
    'use strict';

    let $form = $('#login-form');
    let $button = $('#login-form-submit');

    // Click on submit button
    $button.click(function (event) {
        event.preventDefault();
        $form.trigger('submit:form');
    });

    // Submit form event
    $form.on('submit:form', function () {
        Inventory.AJAX.submit(this, Inventory.responseContainer, Inventory.redirect, ['/']);
    });
});
