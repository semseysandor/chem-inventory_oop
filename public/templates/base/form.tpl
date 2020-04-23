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
{strip}
    <form id="{block id}{/block}" method="post" action="{block action}{/block}">
        <div>
            {block form_meta}{/block}
        </div>
        <div>
            {block form_content}{/block}
        </div>
        <div>
            {block form_submit}{/block}
        </div>
        <div>
            {block form_js}{/block}
        </div>
    </form>
{/strip}
