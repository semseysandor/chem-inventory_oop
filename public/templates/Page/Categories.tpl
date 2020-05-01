{if $compounds}
    <div class="pad-s of-auto">
        <table class="list">
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
                <tr id="inv-compound-row-{$id}">
                    <td></td>
                    <td></td>
                    <td class="compound-{$id}">{$id}</td>
                    <td class="compound-{$id}">{$item.name}</td>
                    <td>{$item.name_alt}</td>
                    <td>{$item.abbrev}</td>
                    <td>{$item.note}</td>
                </tr>
                <tr id="inv-batch-row-{$id}" class="no-show">
                    <td colspan="2" style="padding:0; border:none"></td>
                    <td colspan="5" style="padding:0; border:none">
                        <div id="inv-batch-{$id}" class="no-show"></div>
                    </td>
                </tr>
            {strip}
                <script>
                    $('.compound-{$id}').click(function () {
                        $('#inv-batch-row-{$id}').toggle();
                        $('#inv-batch-{$id}').toggle();
                        Inventory.AJAX.retrieve('/batch/{$id}', 'inv-batch-{$id}');
                    });
                </script>
            {/strip}
            {/foreach}
            </tbody>
        </table>
    </div>
{else}
    <div>No such compound</div>
{/if}
