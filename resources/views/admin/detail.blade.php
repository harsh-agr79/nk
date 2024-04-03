@extends('admin/layout')

@section('main')
    <div class="container">
        <div class="right"><a class='dropdown-trigger btn-flat' href='#' data-target='{{$order[0]->orderid}}'><i class="material-icons">more_vert</i></a>
            <!-- Dropdown Structure -->
            <ul id='{{$order[0]->orderid}}' class='dropdown-content'>
              <li><a href="{{url('editorder/'.$order[0]->orderid)}}">Edit</a></li>
              <li><a href="{{url('deleteorder/'.$order[0]->orderid)}}">Delete</a></li>
            </ul>
            <br>
            
        </div>
        <div class="row right">
            <div class="col s6">Voucher:</div>
            <div class="col s6">
        <img class="materialboxed" height="60px" src="{{asset('voucher/'.$order[0]->voucher)}}" alt="">
            </div>
        </div>
        
        {{-- <div class="right">
            
        </div> --}}
        @php
            $customer = DB::table('customers')->where('id', $order[0]->userid)->first();
            $category = explode(",", $customer->category);
            $commission = explode(",",$customer->commission);   
        @endphp
        <div>
            <h6>Customer: {{$customer->name}}</h6>
            <h6>Date: {{date('d-m-Y', strtotime($order[0]->created_at))}}</h6>
            <h6>Orderid: {{$order['0']->orderid}}</h6>
            <h6>Site: {{$order['0']->site}}</h6>
        </div>
        
        {{-- </div> --}}
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>price</th>
                        <th>total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order as $item)
                        <tr>
                            <td>{{$item->item}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->price * $item->quantity}}</td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>total</td>
                            <td>Rs. {{$order2['0']->sum}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Discount</td>
                            <td>{{$order2[0]->discount}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Cash Discount</td>
                            <td>{{$order2[0]->cash_discount}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Discounted total</td>
                            <td>Rs. {{$order2['0']->sum - ($order2[0]->discount * $order2['0']->sum * 0.01) - $order2[0]->cash_discount}}</td>
                        </tr>
                    </tfoot>
                    
                </tbody>
            </table>
        </div>
        @if ($customer->type == 'interior')
        <div>         
            <div class="center" style="margin-top: 50px;">
                <h5>Commission table</h5>
            </div>
    <span class="hide">{{$totcom2 = 0}}</span>
    <div>
        <table>
            <thead>
                <tr>
                    <th>category</th>
                    <th>Commission(%)</th>
                    <th>Discounted total</th>
                    <th>commission</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order3 as $item)
                <tr>
                    <div class="hide">
                        {{$key = array_search($item->category, $category);}}
                        {{$commission[$key]}}
                    </div>
                    <td>{{$item->category}}</td>
                    <td>{{$commission[$key]}}</td>
                    <td>{{($item->sum - $item->dis)}}</td>
                    <td>{{$totcom = ($item->sum - $item->dis) * $commission[$key] * 0.01}}</td>
                    <span class="hide">{{$totcom2 = $totcom2 + $totcom}}</span>
                </tr>
            @endforeach    
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td style="font-weight:800;">TOTAL</td>
                    <td style="font-weight:800;">Rs. {{$order2['0']->sum - ($order2[0]->discount * $order2['0']->sum * 0.01)-$item->cash_discount}}</td>
                    <td style="font-weight:800;">Rs. {{$totcom2}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
        </div>
        <div style="height: 50px;">

        </div>
        @endif
       
    </div>
@endsection