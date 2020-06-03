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
{block header}{include 'base/header.tpl'}{/block}
{block body}
    <section id="menu">
    </section>
    <section id="popup">
    </section>
    <section>
        <div class="block">
            <div id="category-selector" class="float-left">
                {foreach $categories as $item}
                    <button class="button category" category="{$item.category_id}">{$item.name}</button>
                {/foreach}
            </div>
            <div class="float-right">
                <button id="add-compound-btn" class="button site">Add compound</button>
            </div>
        </div>
        <div id="sub-category-selector">
            {foreach $sub_categories as $item}
                <button class="button category no-show sub-category-buttons" sub-category="{$item.sub_category_id}" parent="{$item.category_id}">
                    {$item.name}
                </button>
            {/foreach}
        </div>
    </section>
    <section id="main">
    </section>
    <script src="js/Page/Index.js"></script>
{/block}
