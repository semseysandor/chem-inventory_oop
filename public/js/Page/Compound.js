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
 * Load batches
 */
$(document).ready(function () {
    'use strict';

    // Click on compounds
    $('#compound-list').on('click', 'tr[level=compound]', function () {
        let compoundID = $(this).attr('compound');
        let batchRow = $(this).find('div[level=batch]');

        // If batch row empty --> fetch
        if (!$.trim(batchRow.html())) {
            Inventory.AJAX.retrieve('/batch/' + compoundID, batchRow);
        }
        batchRow.toggle();
    });
});

