{if $compounds}
    <div class="pad-s of-auto">
        <table class="list">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Name</th>
                <th>Alternative Name</th>
                <th>Abbreviation</th>
                <th>Note</th>
            </tr>
            </thead>
            <tbody>
            {foreach $compounds as $item}
                <tr>
                    <td></td>
                    <td></td>
                    <td>{$item.compound_id}</td>
                    <td>{$item.name}</td>
                    <td>{$item.name_alt}</td>
                    <td>{$item.abbrev}</td>
                    <td>{$item.note}</td>
                </tr>
            {/foreach}

            </tbody>
        </table>
    </div>
{else}
    <div>No such compound</div>
{/if}
