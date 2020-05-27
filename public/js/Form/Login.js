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
$(function () {
    'use strict';

    let $form = $('#login-form');

    $.pubsub.connect({
        publisher: $('#login-form-submit'),
        subscriber: $form,
        browserEvent: 'click',
        publishEvent: 'publish:submit',
        callBack: function () {
            $.ajaxWrap.submit($form, Inventory.$responseContainer, Inventory.reload);
        },
    });
});
