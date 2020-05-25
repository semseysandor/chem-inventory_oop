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
{config_load "elements.conf"}
<!DOCTYPE html>
<html lang="en">
<head>
    {include file='base/head.tpl'}
</head>
<body>
<div id="response"></div>
{block body}{/block}

{* Footer *}
{include file='base/footer.tpl'}
</body>
</html>
