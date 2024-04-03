$(document).ready(function(){
    // $(document).ready(function() {
        $('select').formSelect();
    //  });
    $('input#username').change(function(){
        var cust = $(this).val();
        // console.log(cust)
        $.ajax({
        type:'get',
        url:'/cusgetoid/'+cust,
        success:function(response){
                console.log(response)
                $('#oidselect').html("")
               var oval = 0;
         $.each(response.oid, function(key, item) {
            var oval = item.sum-item.dis-item.paidamt-item.disextra; 
            if(oval > 0){
                $('#oidselect').append(
                    '<div class="row col s12">\
                <div class="input-field col s3">\
                <input type="text" name="oid[]" value="'+ item.orderid+'" placeholder="User" readonly>\
              </div>\
              <div class="input-field col s3">\
                 Rs. '+oval+'\
              </div>\
              <div class="input-field col s3">\
                <input type="text" name="amt[]" placeholder="amount">\
              </div>\
              <div class="input-field col s3">\
                    <label>\
                      <input name="closepay[]" type="checkbox" />\
                      <span>complete payment</span>\
                    </label>\
              </div>\
              </div>');
            }
          });
        },
        
        error:function(){
            $('#oidselect').html("")
        }
      })
      })
    fetchPayment();
    $.ajax({
        type:'get',
        url:'/customerget2',
        success:function(response){
            console.log(response)
        //   var custarray2 = response;
          var datacust2 = {};
          for(var i=0; i< response.length; i++){
  
            datacust2[response[i].username] =null;
          }
          console.log(datacust2)
          $('input#username').autocomplete({
            data: datacust2,
          });
        }
      })
      function fetchPayment(){
          $.ajax({
              type:"GET",
              url:"/paymentget",
              dataType:"json",
              success:function(response){
                  $('tbody').html("");
                  $.each(response.payments, function(key, item){
                    $('tbody').append(
                        '<tr>\
                            <td>'+item.username+'</td>\
                            <td>'+item.paymentid+'</td>\
                            <td>'+item.oid+'</td>\
                            <td>'+item.type+'</td>\
                            <td>'+item.amount+'</td>\
                            <td><button value="'+item.id+'" class="btn-small waves-effect theme editbtn"  style="border-radius: 20px;"><i class="material-icons small">edit</i></button></td>\
                            <td><button value="'+item.id+'" class="btn-small deletebtn waves-effect red"  style="border-radius: 20px;"><i class="material-icons small">delete</i></button></td>\
                        </tr>'
                    );
                  });
              }
          })
      }

      $(document).on('click', '.editbtn', function(e){
          e.preventDefault();
            var pay_id = $(this).val();
            $('#editpaymodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editpayment/"+pay_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#editusername').val(response.payment.username);
                    $('#editdate').val(response.payment.date);
                    $('#editid').val(response.payment.id);
                    $('#edittype').val(response.payment.type);
                    $('#editamount').val(response.payment.amount);
                }
            })
      })
      $(document).on('click', '.deletebtn', function(e){
          e.preventDefault();
            var pay_id = $(this).val();
            $('#deletepaymodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editpayment/"+pay_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#deleteid').val(response.payment.id);
                    $('#paymentid').html(response.payment.paymentid);
                }
            })
      })


    $('#addform').submit(function(e){
    e.preventDefault();
        $('#usernameerror').text('')
        $('#emailerror').text('')
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/paymentadd",
        data:$('#addform').serialize(),
        type:'post',
        success:function(response){
            $('#addform')['0'].reset();
            fetchPayment();
            console.log(response)
            $('#oidselect').html("")
            M.toast({html: 'Payment Added!'})
        },
    })
  });
  $('#editform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/paymentupdate",
        data:$('#editform').serialize(),
        type:'post',
        success:function(result){
            fetchPayment();
            M.toast({html: 'Payment Updated!'})
        },
    })
  });
  $('#deleteform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/deletepayment",
        data:$('#deleteform').serialize(),
        type:'post',
        success:function(result){
            fetchPayment();
            M.toast({html: 'Payment Deleted!'})
        }
    })
  });
  })