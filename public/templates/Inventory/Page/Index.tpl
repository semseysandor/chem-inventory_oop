<!--
  +---------------------------------------------------------------------+
  | This file is part of chem-inventory.                                |
  |                                                                     |
  | Copyright (c) 2020 Sandor Semsey                                    |
  | All rights reserved.                                                |
  |                                                                     |
  | This work is published under the MIT License.                       |
  | https://choosealicense.com/licenses/mit/                            |
  |                                                                     |
  | It's a free software;)                                              |
  |                                                                     |
  | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
  | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
  | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
  | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
  | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
  | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
  | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
  | SOFTWARE.                                                           |
  +---------------------------------------------------------------------+
  -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
</head>
<body>
<table>
  <tr>
      {foreach $compounds.fields as $field}
        <th>{$field}</th>
      {/foreach}
  </tr>
    {foreach $compounds['rows'] as $row}
      <tr>
          {foreach $row as $name=>$var}
            <td>{$var}</td>
          {/foreach}
      </tr>
    {/foreach}
</table>
</body>
</html>
