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

        if (!message) {
            return '';
        }

        if (flag === 'pos') { // Positive response
            response += '<div class="message positive"><i class="fas fa-smile fa-lg"></i>';
        } else {
            if (flag === 'neg') { // Negative response
                response += '<div class="message negative"><i class="far fa-frown fa-lg"></i>';
            } else {
                response += '<div class="message">';
            }
        }

        return response + message.toString() + '</div>';
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

    closePopup: function () {
        'use strict';
        Inventory.$popup.clear();
    },

    closeMessageCenter: function () {
        'use strict';
        Inventory.$responseContainer.clear();
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

    /** Page body */
    Inventory.$body = $('body');
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

$(function () {
    Inventory.$body.click(function (event) {

        let target = event.target;

        // console.log(event.target);
    });
});
