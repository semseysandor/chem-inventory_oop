{if $batches}
    <div class="pad-s of-auto">
        <table class="list">
            <thead>
            <tr>
                <th>Manufacturer</th>
                <th>Name</th>
                <th>LOT</th>
                <th>Arrived</th>
                <th>Opened</th>
                <th>Expire</th>
                <th>Note</th>
            </tr>
            </thead>
            <tbody>
            {foreach $batches as $item}
                <tr>
                    <td>{$item.manfac_name}</td>
                    <td>{$item.name}</td>
                    <td>{$item.lot}</td>
                    <td>{$item.date_arr}</td>
                    <td>{$item.date_open}</td>
                    <td>{$item.date_exp}</td>
                    <td>{$item.note}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
{else}
    <div class="card">There are no batches</div>
{/if}
