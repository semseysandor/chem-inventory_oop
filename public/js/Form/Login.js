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

    $.pubsub.connect({
        publisher: $('#login-form-submit'),
        subscriber: $form,
        browserEvent: 'click',
        publishEvent: 'publish:submit',
        callBack: function () {
            Inventory.AJAX.submit($form, Inventory.responseContainer, function () {
                Inventory.redirect('/');
            });
        },
    });
});
