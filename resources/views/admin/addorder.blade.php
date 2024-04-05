@extends('admin/layout')

@section('main')
<style>
    .inpbor{
        border: 1px solid black;
    }
    .input-field input{
        border: none;
        height: 30px;
        width: 100%;
    }
    .input-field input:focus {
            /* border: 1px solid rgb(255, 0, 0); */
            outline: none;
         /* background-color: yellow; */
    }


</style>
<div class="hide">
    <div class="ivrow row col s12" id="field" style="margin-top: -48px;">
          <div class="inpbor input-field col s4">
            <input placeholder="Item" class="browser-default item autocomplete" name="item[]" type="text" class="validate">
          </div> 
          <div class="inpbor input-field col s2">
            <input placeholder="Quantity" name="quantity[]" type="text" onkeyup="var main = $(this).parent().parent();
            var quantity = $(this).val();
            var price = main.find('.price').val();
            var total = quantity*price
            main.find('.total').val(total);
            calc()" class="quantity browser-default validate">
          </div>
          <div class="inpbor input-field col s2">
            <input placeholder="Price" type="text" name="price[]"
            onkeyup="var main = $(this).parent().parent();
                            var quantity = main.find('.quantity').val();
                            var price = $(this).val();
                            var total = quantity*price
                            main.find('.total').val(total);
                            calc()" class="price browser-default validate">
          </div>
          <div class="inpbor input-field col s2">
            <input placeholder="Total" value="0" type="number" onchange="calc()" class="total browser-default validate">
          </div>
          <div class="col s2 btn-small red center" style="margin-top: 13px;" onclick="this.parentNode.remove()">
            <i class="material-icons">close</i>
        </div>
      </div>
</div>

    <div class="center"><h6>Create Invoice</h6></div>
    <div style="padding: 0 3vw;">
        <form action="{{Route('createorder')}}" enctype="multipart/form-data" autocomplete="off" method="POST" class="row">
            @csrf
              <div class="input-field col s12 m6">
                <input type="text" name="username" id="username" placeholder="Customer" class="autocomplete" required>
              </div>
              {{-- <div class="input-field col s12 m6">
                <input type="number" onkeyup="calc()" name="discount" id="discount" placeholder="Discount(%)" class="autocomplete">
              </div> --}}
              
              <div class="input-field col s12 m6">
                <input type="text" name="site" id="site" style="display: none;" placeholder="Site/Project" class="autocomplete" required>
              </div>
              <div class="col s12 m6">
                <input type="date" name="date" placeholder="Date" value="{{date('Y-m-d')}}" required>
              </div>
              <div class="file-field input-field col s12 m6">
                <div class="btn grey darken-2">
                  <span>Voucher</span>
                  <input name="voucher" type="file">
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                </div>
              </div>
              <div class="col s12 z-depth-2" style="padding: 5px; border-radius: 10px;">
                <div class="ivrow row col s12">
                    <div class="inpbor input-field col s4">
                        <input placeholder="Item" class="browser-default item autocomplete" type="text" name="item[]" class="validate">
                      </div> 
                      <div class="inpbor input-field col s2">
                        <input placeholder="Quantity" type="text" 
                        onkeyup="var main = $(this).parent().parent();
                        var quantity = $(this).val();
                        var price = main.find('.price').val();
                        var total = quantity*price
                        main.find('.total').val(total);
                        calc();"  name="quantity[]" class="quantity browser-default validate">
                      </div>
                      <div class="inpbor input-field col s2">
                        <input placeholder="Price" type="text" 
                        onkeyup="var main = $(this).parent().parent();
                            var quantity = main.find('.quantity').val();
                            var price = $(this).val();
                            var total = quantity*price
                            main.find('.total').val(total);
                            calc();" name="price[]" class="price browser-default validate">
                      </div>
                      <div class="inpbor input-field col s2">
                        <input placeholder="Total" type="number" onchange="calc()" class="total browser-default validate">
                        {{-- <span class="total"></span> --}}
                      </div>
                </div>
                <div id="addedfield">

                </div>
                <div class="ivrow row col s12" style="margin-top: -48px;">
                    <div class="input-field col s4">
                      </div> 
                      <div class=" input-field col s2">
                      </div>
                      <div class="inpbor input-field col s2" style="height: 25px;">
                        <span  class="right">Total</span>
                      </div>
                      <div class="inpbor input-field col s2" style="height: 25px;">
                        <span style="height: 30px" id="total"></span>
                      </div>
                </div>
                <div class="ivrow row col s12" style="margin-top: -48px;">
                    <div class="input-field col s4">
                      </div> 
                      <div class="input-field col s1">
                      </div>
                      <div class="inpbor input-field col s3" style="height: 32px;">
                        <span class="right">Discount</span>
                      </div>
                      <div class="inpbor input-field col s2">
                        <input type="number" onkeyup="calc()" value="0" max="100" min="0" step="0.01" class="browser-default" name="discount" id="discount" placeholder="Discount(%)" >
                      </div>
                </div>
                <div class="ivrow row col s12" style="margin-top: -48px;">
                  <div class="input-field col s4">
                    </div> 
                    <div class="input-field col s1">
                    </div>
                    <div class="inpbor input-field col s3" style="height: 32px;">
                      <span class="right">Cash Discount</span>
                    </div>
                    <div class="inpbor input-field col s2">
                      <input type="number" onkeyup="calc()" value="0" class="browser-default" name="cash_discount" id="cash_discount" placeholder="Cash Discount(Rs.)" >
                    </div>
              </div>
                <div class="ivrow row col s12" style="margin-top: -48px;">
                    <div class=" input-field col s2">
                      </div> 
                      <div class=" input-field col s1">
                      </div>
                      <div class="inpbor input-field col s5"  style="height: 25px;">
                        <span class="right">Discounted-Total</span>
                      </div>
                      <div class="inpbor input-field col s2" style="height: 25px;">
                        <span style="height: 30px;" id="distot"></span>
                      </div>
                </div>
                
              </div>
              
              <div class="center col s12" style="margin-top:20px;">
                <span class="btn grey darken-2 white-text" accesskey="A" onclick="addfield()">Add <i class="material-icons left">add</i> </span>
              </div>
              <div class="center col s12" style="margin-top:20px;">
                <button class="btn-large green darken-2 white-text" type="submit">Create<i class="material-icons left">send</i> </span>
              </div>
        </form>
    </div>
    <script>
       $('input#username').keyup(function(){
        var cust = $(this).val();
        // console.log(cust)
        $.ajax({
        type:'get',
        url:'/cusgetsite/'+cust,
        success:function(response){
          if(response.type == 'interior'){
            $('#site').show()
          }
          else{
            $('#site').hide()
          }
          var datacust2 = {};
          for(var i=0; i<response.sites.length; i++){
            datacust2[response.sites[i].site] =null;
          }
          $('input#site').autocomplete({
            data: datacust2,
          });
        },
        error:function(){
          console.clear()
          $('#site').hide()
          $('input#site').val('');
        }
      })
      })
       
    </script>
    <script>
        $.ajax({
        type:'get',
        url:'/customerget2',
        success:function(response){
            // console.log(response)
        //   var custarray2 = response;
          var datacust2 = {};
          for(var i=0; i< response.length; i++){
  
            datacust2[response[i].username] =null;
          }
        //   console.log(datacust2)
          $('input#username').autocomplete({
            data: datacust2,
          });
        }
      })
      $.ajax({
        type:'get',
        url:'/itemget',
        success:function(response){
            // console.log(response)
        //   var custarray2 = response;
          var datacust2 = {};
          for(var i=0; i< response.length; i++){
  
            datacust2[response[i].name] =null;
          }
        //   console.log(datacust2)
          $('input.item').autocomplete({
            data: datacust2,
          });
        }
      })
      function addfield(){
            $("#field").clone().appendTo("#addedfield");
            $.ajax({
              type:'get',
              url:'/itemget',
              success:function(response){
                  // console.log(response)
              //   var custarray2 = response;
                var datacust2 = {};
                for(var i=0; i< response.length; i++){
                
                  datacust2[response[i].name] =null;
                }
              //   console.log(datacust2)
                $('input.item').autocomplete({
                  data: datacust2,
                });
              }
         })
        }
    </script>
    <script>
        function calc()
        {
            var total = 0;
               $('input.total').each(function(){
               total = total + parseFloat($(this).val());
           })
           var dis = parseFloat($('#discount').val());
           var dis2 = parseFloat($('#cash_discount').val());
        //    console.log(dis)
           var tot = total - total*dis*0.01-dis2;
           $('#total').text(total);
           $('#distot').text(tot);
           console.log(total)
           console.log(tot)
        }
    </script>
@endsection