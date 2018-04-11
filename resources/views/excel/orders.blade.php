<table>
    <thead>
    <tr>
        <th>Name</th>
        @role('admin')
            <th>BIN</th>
            <th>Order</th>
        @endrole
        <th>Card</th>
        <th>Amount</th>
        <th>Transaction ID</th>
        <th>Status</th>
        <th>Response</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->card_holder_name }}</td>
            @role('admin')
                <td>{{ $order->user->alias  }}</td>
                <td>{{ $order->order }}</td>
            @endrole
            <td>{{ substr($order->card_number, -4) }}</td>
            <td>{{ number_format($order->amount, 2, '.', ',') }}</td>
            <td>{{ $order->transaction_id }}</td>
            <?php
                switch($order->response_code){
                    case 0:
                        ?><td>Pending</td><?php
                    break;
                    case 100:
                        ?><td>Approved</td><?php
                    break;
                    case 200:
                        ?><td>Rejected</td><?php
                    break;
                    case 3:
                        ?><td>Error in transaction data or system error</td><?php
                    break;
                }
            ?>
            <td>{{ $order->response }}</td>
            <td>{{ $order->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>