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
{block id}login-form{/block}
{block action}log-in{/block}
{block form_content}
    <table class="form">
        <caption>Login</caption>
        <tr>
            <th>User Name</th>
            <td><input type="text" name="user" autofocus required/></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><input type="password" name="pass" required/></td>
        </tr>
    </table>
{/block}
{block form_submit}
    {include #button_submit# id="login-form-submit" title="Login"}
{/block}
{block form_js}
    <script src="js/Form/Login.js"></script>
{/block}
