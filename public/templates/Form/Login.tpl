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
{extends "base/form.tpl"}
{block id}form.login{/block}
{block action}log-in{/block}
{block form_content}{strip}
  <label>User Name&amp;%&quot;
    <input type="text" name="user" autofocus/>
  </label>
{/strip}{/block}
{block form_submit}
    {include #button_submit# name=Login}
{/block}
