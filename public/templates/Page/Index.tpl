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
{block body}
    <h1>Inventory</h1>
    <h2>Welcome {$user_name}</h2>
    <button id="logout">Logout</button>
    <section id="menu">
    </section>
    <section id="popup">
    </section>
    <section>
        <div>
            <button id="add-compound-btn">Add compound</button>
        </div>
        <div id="category-selector">
            {foreach $categories as $item}
                <button category="{$item.category_id}">{$item.name}</button>
            {/foreach}
        </div>
        <div id="sub-category-selector">
            {foreach $sub_categories as $item}
                <button sub-category="{$item.sub_category_id}" parent="{$item.category_id}" class="no-show sub-category-buttons">
                    {$item.name}
                </button>
            {/foreach}
        </div>
    </section>
    <section id="main">
    </section>
    <script src="js/Page/Index.js"></script>
{/block}
