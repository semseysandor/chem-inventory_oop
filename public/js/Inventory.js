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
 * Debug function
 *
 * @param message Message to log
 */
Inventory.debug = function (message) {
    'use strict';
    console.log(message);
};
/**
 * Add an event listener on click
 *
 * @param elementID ID of element to attach listener
 * @param func Listener function
 */
Inventory.addClick = function (elementID, func) {
    'use strict';
    document.getElementById(elementID).addEventListener('click', func);
};
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

    response += ' ' + message.toString() + '</div>';

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
