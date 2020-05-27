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
$(function () {
    'use strict';
    $.ajaxWrap.retrieve('/category/0', Inventory.$main);
});

/**
 * Category selector
 */
$(function () {
    'use strict';
    let categoryID, buttons;

    // Click on a category selector button
    $('#category-selector').on('click', 'button', function () {
        // Get compounds of category
        categoryID = $(this).attr('category');
        $.ajaxWrap.retrieve('/category/' + categoryID, Inventory.$main);

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
$(function () {
    'use strict';
    // Click on a sub-category selector button
    $('#sub-category-selector').on('click', 'button', function () {
        $.ajaxWrap.retrieve('/subcategory/' + $(this).attr('sub-category'), Inventory.$main);
    });
});

/**
 * Logout button
 */
$(function () {
    'use strict';
    $('#logout').click(function () {
        $.ajaxWrap.execute('/log-out', Inventory.$responseContainer, Inventory.reload);
    });
});

/**
 * Add compound
 */
$(function () {
    'use strict';
    $('#add-compound-btn').click(function () {
        Inventory.$popup.clear();
        $.ajaxWrap.retrieve('/form/add/compound', Inventory.$popup);
    });
});
