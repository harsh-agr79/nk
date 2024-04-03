@extends('admin/layout')

@section('main')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="{{asset('assets/script/script.js')}}"></script>
    <div class="container">
        <div class="center"><h2>Order List</h2></div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>date</th>
                        <th>name</th>
                        <th>orderid</th>
                        <th>voucher</th>
                        <th>view</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                        <tr>
                            <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->orderid}}</td>
                            <td><span onclick="$('#{{$item->orderid}}2').materialbox('open');" class="btn grey darken-2">img</span></td>
                            <span class="mbox"><img class="materialboxed" id="{{$item->orderid}}2" height="0.0000000000001px" src="{{asset('voucher/'.$item->voucher)}}" alt="">
                            </span>
                            <td><a href="{{url('detail/'.$item->orderid)}}" class="btn-small waves-effect theme editbtn"  style="border-radius: 20px;"><i class="material-icons small">visibility</i></a></td>
                            <td><div class="center"><a class='dropdown-trigger btn-flat' href='#' data-target='{{$item->orderid}}'><i class="material-icons">more_vert</i></a>
                                <!-- Dropdown Structure -->
                                <ul id='{{$item->orderid}}' class='dropdown-content'>
                                  <li><a href="{{url('editorder/'.$item->orderid)}}">Edit</a></li>
                                  <li><a href="{{url('deleteorder/'.$item->orderid)}}">Delete</a></li>
                                </ul></div>
                        </div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        
    </script>

@endsection
