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
                            <h2>${{ number_format($monthAmount, 0, '.', ',') }}</h2>
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
                            <h2>${{ number_format($todayAmount, 0, '.', ',')  }}</h2>
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
                    <a href="" id="filters">Filters</a>
                    &nbsp;
                    &nbsp;
                    <a href="/excel{{ (isset($_GET['startDate'])? '?startDate='.$_GET['startDate'] : '') }}{{ (isset($_GET['endDate'])? '&endDate='.$_GET['endDate'] :'') }}">Export table to Excel</a>
                </div>
            </div>
        </div>

        <div class="row" id="apply-filters" style="margin: 20px 0; {{ (isset($_GET['startDate'])? '' : 'display: none;') }}">
            <div class="pull-right">
                <form action="/" method="get" class="form-inline">
                    <div class="form-group">
                        <label for="exampleInputName2">Start Date</label>
                        <input type="date" name="startDate"
                               value="{{ (isset($_GET['startDate'])? $_GET['startDate'] : \Carbon\Carbon::yesterday()->format('Y-m-d')) }}">
                    </div>
                    &nbsp;
                    &nbsp;
                    <div class="form-group">
                        <label for="exampleInputName2">End Date</label>
                        <input type="date" name="endDate" value="{{ (isset($_GET['endDate'])? $_GET['endDate'] :  \Carbon\Carbon::now()->format('Y-m-d')) }}">
                    </div>
                    &nbsp;
                    <button type="submit" class="btn btn-default">Filter</button>
                </form>
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
                        @role('admin')
                            <td>API Response</td>
                        @endrole        
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
                            @role('admin')
                                <td>{{ $order->response_code  }}</td>
                            @endrole
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
                                    case 400:
                                    case 422:
                                        ?><td>Error</td><?php
                                    break;
                                }
                            ?>
                            <td>{{ $order->response }}</td>
                            <td>{{ $order->updated_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orders->appends($_GET)->links() }}
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

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#filters").click(function(e){
                e.preventDefault();
                $("#apply-filters").slideDown();
            });
        });
    </script> 
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>

    @if(session()->has('message.level'))
        <script>
            $.notify({
                title: '<strong>Transaction: </strong>',
                message: '{!! session('message.content') !!}:'
            },{
                type: '{{ session('message.level') }}',
                placement: {
                    from: "bottom",
                    align: "right"
                },
            });
        </script>
    @endif
@endsection
