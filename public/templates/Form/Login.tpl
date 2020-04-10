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
{extends "form.tpl"}
{block action}log-in{/block}
{block form_content}{strip}
  <label>User Name
    <input type="text" name="user" autofocus required/>
  </label>
{/strip}{/block}
{block form_submit}
    {include #button_submit# name=Login}
{/block}
