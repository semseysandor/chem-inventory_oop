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
{block id}inv-login-form{/block}
{block action}log-in{/block}
{block form_content}
    {strip}
        <div>
            <label>
                User Name
                <input type="text" name="user" autofocus required/>
            </label>
        </div>
        <div>
            <label>
                Password
                <input type="password" name="pass" required/>
            </label>
        </div>
    {/strip}
{/block}
{block form_submit}
    {include #button_submit# id="inv-login-form-submit" name="Login"}
{/block}
{block form_js}
{literal}
    <script>
        Inventory.addClick('inv-login-form-submit', function (event) {
            event.preventDefault();
            Inventory.AJAX.submit('inv-login-form', 'inv-response', Inventory.redirect, ['/index']);
        });
    </script>
{/literal}
{/block}
