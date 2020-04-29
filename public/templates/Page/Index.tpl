{*
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
*}
{extends file='base/page.tpl'}
{block body}{strip}
    <h1>Inventory</h1>
    <h2>Welcome {$user_name}</h2>
    <a href="log-out">
        <button>Logout</button>
    </a>
    <section id="inv-menu">
    </section>
    <section id="inv-popup">
    </section>
    <section id="inv-category-selector">
        {foreach $categories as $item}
            <button id="inv-category-button_{$item.category_id}">{$item.name}</button>
            <script>
                Inventory.addClick('inv-category-button_{$item.category_id}', function () {
                    Inventory.AJAX.retrieve('/category/{$item.category_id}', 'main');
                });
            </script>
        {/foreach}
    </section>
    <section id="main">
    </section>
    <script>
        window.addEventListener('load', function () {
            Inventory.AJAX.retrieve('/category/0', 'main');
        });
    </script>
{/strip}{/block}
