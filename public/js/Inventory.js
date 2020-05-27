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
let Inventory = {

    /**
     * Translates response message to HTML
     *
     * @param message Message text
     * @param flag Message flag
     *
     * @returns {string}
     */
    messageHTML: function (message, flag) {
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
    },

    /**
     * Redirect to URL
     *
     * @param url URL to redirect to
     */
    redirect: function (url) {
        'use strict';
        window.location.assign(url);
    },

    /**
     * Reload page
     */
    reload: function () {
        'use strict';
        window.location.reload();
    },
};

/**
 * Container shortcuts
 */
$(function () {
    'use strict';

    /** Response container */
    Inventory.$responseContainer = $('#response');

    /** Main section */
    Inventory.$main = $('#main');

    /** Pop-up section */
    Inventory.$popup = $('#popup');
});

/**
 * Set cursor to progress on AJAX
 */
$(function () {
    'use strict';
    let $body = $('body');
    $(document)
        .ajaxStart(function () {
            $body.css('cursor', 'progress');
        })
        .ajaxStop(function () {
            $body.css('cursor', 'auto');
        });
});
