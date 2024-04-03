@extends('customer/layout')

@section('main')
    @php
        function getcom($orderid,$user){
            $order = DB::table('orders')->where('orderid', $orderid)->selectRaw('*, SUM(quantity * price) as sum, SUM(quantity * price * discount * 0.01) as dis')->groupBy('orderid')->groupBy('category')->get();
            $category = explode(",", $user->category); 
            $commission = explode(",", $user->commission);
            $totalcom = 0;
            foreach ($order as $item) {
                $key = array_search($item->category, $category);
                $totalcom = $totalcom + (($item->sum - $item->dis) * $commission[$key] * 0.01);
            }
            return $totalcom;
        }

        $order = DB::table('orders')->where('userid', $user->id)->selectRaw('*, SUM(quantity * price) as sum, SUM(quantity * price * discount * 0.01) as dis')->groupBy('orderid')->groupBy('category')->get();
            $category = explode(",", $user->category); 
            $commission = explode(",", $user->commission);
            $totalcom = 0;
            foreach ($order as $item) {
                $key = array_search($item->category, $category);
                $totalcom = $totalcom + (($item->sum - $item->dis) * $commission[$key] * 0.01);
            }
        @endphp
<div class="container">
    <div class="center"><h5>Total Commission: {{$totalcom}}</h5></div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>date</th>
                    <th>Site</th>
                    <th>orderid</th>
                    <th>voucher</th>
                    <th>Total</th>
                    <th>commission</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <tr>
                        <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                        <td>{{$item->site}}</td>
                        <td>{{$item->orderid}}</td>
                        <td><span onclick="$('#{{$item->orderid}}2').materialbox('open');" class="btn grey darken-2">img</span></td>
                        <span class="mbox"><img class="materialboxed" id="{{$item->orderid}}2" height="0.0000000000001px" src="{{asset('voucher/'.$item->voucher)}}" alt="">
                        </span>
                        <td>{{$item->sum-(int)$item->cash_discount}}</td>
                        <td>{{getcom($item->orderid,$user)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection