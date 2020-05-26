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
 * Inventory object
 */
let Inventory = {};

/**
 * Translates response message to HTML
 *
 * @param message Message text
 * @param flag Message flag
 *
 * @returns {string}
 */
Inventory.messageHTML = function (message, flag) {
    'use strict';

    // Put response in container
    let response = '';

    if (flag === 'pos') { // Positive response
        response += '<div class="message positive"><i class="fas fa-smile fa-lg"></i>';
    } else {
        if (flag === 'neg') { // Negative response
            response += '<div class="message negative"><i class="far fa-frown fa-lg"></i>';
        } else {
            response += '<div class="message">';
        }
    }

    if (message) {
        response += message.toString() + '</div>';
    } else {
        response += '</div>';
    }

    return response;
};

/**
 * Redirect to URL
 *
 * @param url URL to redirect to
 */
Inventory.redirect = function (url) {
    'use strict';
    window.location.replace(url);
};

/**
 * Container shortcuts
 */
$(document).ready(function () {
    'use strict';

    Inventory.responseContainer = $('#response');
    Inventory.main = $('#main');
});

/**
 * Set cursor to progress on AJAX
 */
$(function () {
    'use strict';
    // Setting up a loading indicator using Ajax Events
    $(document)
        .ajaxStart(function () {
            $('body').css('cursor', 'progress');

        })
        .ajaxStop(function () {
            console.log('end');
            $('body').css('cursor', 'auto');
        });
});
