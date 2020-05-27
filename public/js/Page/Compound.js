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

// Load batches when click on compound row
$(function () {
    'use strict';

    // Click on compounds
    $('#compound-list').on('click', 'tr[level=compound]', function () {

        let $compoundRow = $(this);
        let $batchRow = $compoundRow.find('div[level=batch]');

        // If batch row empty --> fetch
        if (!$.trim($batchRow.html())) {
            $.ajaxWrap.retrieve('/batch/' + $compoundRow.attr('compound'), $batchRow);
        }
        $batchRow.toggle();
    });
});
