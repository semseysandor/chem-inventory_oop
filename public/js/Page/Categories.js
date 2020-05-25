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
$(function () {
    'use strict';
    $('#compound-list').on('click', 'tr', function () {
        let compoundID = $(this).attr('compound');
        $('#batch-row-' + compoundID).toggle();
        $('#batch-' + compoundID).toggle();
        Inventory.AJAX.retrieve('/batch/' + compoundID, 'batch-' + compoundID);
    });
});

