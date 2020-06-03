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

// Submit login form using AJAX
$(function () {
    'use strict';

    let $form = $('#login-form');

    $.pubsub.submitForm($('#login-form-submit'), $form, function () {
        $.ajaxWrap.submit($form, Inventory.$responseContainer, Inventory.reload);
    });
});

// Close msg center on click
$(function () {
    'use strict';
    Inventory.$body.click(function () {
        Inventory.closeMessageCenter();
    });
});

