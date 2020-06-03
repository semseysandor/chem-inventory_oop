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

// Submit form
$(function () {
    'use strict';

    let $form = $('#add-compound-form');

    // Submit button
    $.pubsub.submitForm($('#add-compound-submit'), $form, function () {
        $.ajaxWrap.submit($form, Inventory.$responseContainer, Inventory.closePopup);
    });

    // Cancel button
    $('#add-compound-cancel').click(function () {
        Inventory.closePopup();
    });
});
