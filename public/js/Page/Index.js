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
 * Load all compounds as default
 */
$(document).ready(function () {
    'use strict';
    Inventory.AJAX.retrieve('/category/0', Inventory.main);
});

/**
 * Category selector
 */
$(document).ready(function () {
    'use strict';
    let categoryID, buttons;

    $('#category-selector').on('click', 'button', function () {
        // Get compounds of category
        categoryID = $(this).attr('category');
        Inventory.AJAX.retrieve('/category/' + categoryID, Inventory.main);

        // Hide all sub category buttons
        $('button.sub-category-buttons').hide();

        // Show only related subcategories only if there is more than one
        buttons = $('button[parent="' + categoryID + '"]');
        if (buttons.length > 1) {
            buttons.show();
        }
    });
});

/**
 * Sub-category selector
 */
$(document).ready(function () {
    'use strict';
    $('#sub-category-selector').on('click', 'button', function () {
        Inventory.AJAX.retrieve('/subcategory/' + $(this).attr('sub-category'), Inventory.main);
    });
});

/**
 * Logout button
 */
$(document).ready(function () {
    'use strict';
    $('#logout').click(function () {
        Inventory.AJAX.execute('/log-out', Inventory.responseContainer, function () {
            Inventory.redirect('/');
        });
    });
});

