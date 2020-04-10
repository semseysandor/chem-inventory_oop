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
{config_load "elements.conf"}
  <!DOCTYPE html>
  <html lang="en">
  {* HTML Head *}
  {include file='head.tpl'}
  <body>
  {block body}{/block}
  {* Footer *}
  {include file='footer.tpl'}
  </body>
  </html>
{/strip}
