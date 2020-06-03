{if $compounds}
    <div class="pad-s of-auto">
        <table id="compound-list" class="list">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Alternative Name</th>
                <th>Abbreviation</th>
                <th>Note</th>
            </tr>
            </thead>
            <tbody>
            {foreach $compounds as $item}
                {$id=$item.compound_id}
                <tr compound="{$id}" class="cursor-pointer" level="compound">
                    <td></td>
                    <td>{$item.name}</td>
                    <td>{$item.name_alt}</td>
                    <td>{$item.abbrev}</td>
                    <td>{$item.note}</td>
                </tr>
                <tr class="no-show">
                    <td colspan="5" class="no-show"></td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <script src="js/Page/Compound.js"></script>
{else}
    <div class="card">No such compound</div>
{/if}
