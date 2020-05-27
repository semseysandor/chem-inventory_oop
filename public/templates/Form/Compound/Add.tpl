{extends "base/form.tpl"}
{block id}add-compound-form{/block}
{block action}compound/add{/block}
{block form_content}
    <div class="card">
        <div class="block">
            <span class="float-left"><h3>Vegyszer hozzáadása</h3></span>
        </div>
        <div class="block">
            <div class="float-left pad-m">
                <table class="form">
                    <caption>Identification</caption>
                    <tr>
                        <th>Name</th>
                        <td><input type="text" name="name"/></td>
                    </tr>
                    <tr>
                        <th>Alternative name</th>
                        <td><input type="text" name="nameAlt"/></td>
                    </tr>
                    <tr>
                        <th>Abbreviation</th>
                        <td><input type="text" name="abbrev"/></td>
                    </tr>
                    <tr>
                        <th>CAS</th>
                        <td><input type="text" name="cas" {literal}pattern="[0-9]{2,7}-[0-9]{2}-[0-9]"{/literal} title="xxxxxxx-xx-x"/></td>
                    </tr>
                    <tr>
                    <tr>
                        <th>SMILES</th>
                        <td><input type="text" name="smiles"/></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>
                            <select name="subCategory">
                                <option>5</option>
                                <option>6</option>
                                <option>17</option>
                                <option>9</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="float-left pad-m">
                <table class="form">
                    <caption>Information</caption>
                    <tr>
                        <th>T<sub>olv</sub> [°C]</th>
                        <td><input type="text" name="meltPoint"/></td>
                    </tr>
                    <tr>
                        <th>OEB</th>
                        <td>
                            <select name="oeb">
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <table class="form">
                    <caption>Note</caption>
                    <tr>
                        <td><textarea name="note" cols="30"></textarea></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
{/block}
{block form_submit}
    {include #button_submit# id="add-compound-submit" title="Add"}
{/block}
{block form_js}
    <script src="js/Form/Compound/Add.js"></script>
{/block}
