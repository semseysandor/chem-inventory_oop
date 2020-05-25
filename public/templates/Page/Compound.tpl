{if $compounds}
    <div class="pad-s of-auto">
        <table id="compound-list" class="list">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th>id</th>
                <th>Name</th>
                <th>Alternative Name</th>
                <th>Abbreviation</th>
                <th>Note</th>
            </tr>
            </thead>
            <tbody>
            {foreach $compounds as $item}
                {$id=$item.compound_id}
                <tr compound="{$id}" level="compound">
                    <td style="position: relative">
                        <div style="position: absolute;background-color: white" level="batch" class="no-show"></div>
                    </td>
                    <td></td>
                    <td class="compound-{$id}">{$id}</td>
                    <td class="compound-{$id}">{$item.name}</td>
                    <td>{$item.name_alt}</td>
                    <td>{$item.abbrev}</td>
                    <td>{$item.note}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <script src="js/Page/Compound.js"></script>
{else}
    <div>No such compound</div>
{/if}
