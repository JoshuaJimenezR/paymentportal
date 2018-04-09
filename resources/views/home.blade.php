@extends('layouts.portal')

@section('content')
<div class="container">
    @role('admin')
        <div class="row">
            <div class="col-xs-3">
                <div class="card">
                    <div class="media">
                        <div class="media-left meida media-middle">
                            <span><i class="fa fa-usd f-s-40 color-primary"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2>${{ number_format($monthAmount, 2, '.', ',') }}</h2>
                            <p class="m-b-0">This Month Amount</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="card">
                    <div class="media">
                        <div class="media-left meida media-middle">
                            <span><i class="fa fa-shopping-cart f-s-40 color-success"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2>{{ $monthTransactions }}</h2>
                            <p class="m-b-0">This Month Transactions</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="card">
                    <div class="media">
                        <div class="media-left meida media-middle">
                            <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2>${{ number_format($todayAmount, 2, '.', ',')  }}</h2>
                            <p class="m-b-0">Today's Amount</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="card">
                    <div class="media">
                        <div class="media-left meida media-middle">
                            <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2>{{ $todayTransaction }}</h2>
                            <p class="m-b-0">Today's Transactions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @if( count($orders) > 0 )

        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                    <a href="">Excel</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped">
                    <thead>
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
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
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
                                    case 1:
                                        ?><td>Approved</td><?php
                                    break;
                                    case 2:
                                        ?><td>Rejected</td><?php
                                    break;
                                    case 2:
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
                {{ $orders->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-12" style="padding: 40px; border: 1px dashed #ccc; margin-top: 40px;">
                <div class="text-center">
                    No records found
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
