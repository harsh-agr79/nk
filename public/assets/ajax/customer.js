
$(document).ready(function(){
  $('#custype').change(function(){
    if($('#custype').val() == 'interior'){
      $('#forinterior').show();
    }
    else
    {
      $('#forinterior').hide();
    }
   
  // console.log($('#custype').val());
})
 $('#edittype').change(function(){
    if($('#edittype').val() == 'interior'){
      $('#forinterior2').show();
    }
    else
    {
      $('#forinterior2').hide();
    }
   
  // console.log($('#edittype').val());
})
    fetchCustomer();
      function fetchCustomer(){
          $.ajax({
              type:"GET",
              url:"/customerget",
              dataType:"json",
              success:function(response){
                  $('tbody').html("");
                  $.each(response.customers, function(key, item){
                    $('tbody#main').append(
                        '<tr>\
                            <td>'+item.name+'</td>\
                            <td>'+item.username+'</td>\
                            <td>'+item.phone+'</td>\
                            <td>'+item.type+'</td>\
                            <td>'+item.address+'</td>\
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
            var cust_id = $(this).val();
            $('#editcustmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editcustomer/"+cust_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#editname').val(response.customer.name);
                    $('#editusername').val(response.customer.username);
                    $('#editpw').val(response.customer.password);
                    $('#editid').val(response.customer.id);
                    $('#edittype').val(response.customer.type);
                    $('#editphone').val(response.customer.phone);
                    $('#editcode').val(response.customer.code);
                    $('#editaddress').val(response.customer.address);
                    
                  
                    var category2 = response.category2
                    if(response.customer.category != null){
                      var category = response.customer.category.split(",");
                      var commission = response.customer.commission.split(",");
                      var difference = category2.filter(x => !category.includes(x));
                    }
                    else{
                      var category = null;
                    }
                    // console.log(difference);
                    // console.log(category2);
                    if(response.customer.type == 'interior'){
                      if(category != null){
                        $('#forinterior2').html("");
                        $('#forinterior2').show();
                        $('#forinterior2').append(
                        '<div class="row col s12">\
                        <div class="col s6" style="font-weight: 800;">Category</div>\
                        <div class="col s6" style="font-weight: 800;">Commision</div>\
                       </div>\
                        ');
                        for(var i=0; i<category.length; i++){
                          // console.log(category[i]);
                          $('#forinterior2').append(
                            '<div class="row col s12">\
                            <div class="col s6"><input type="text" name="category[]" value="'+ category[i] +'" readonly/></div>\
                            <div class="col s6"><input type="text" name="commission[]" value="'+ commission[i] +'"/></div>\
                           </div>\
                           ')
                         }
                         for(var i=0; i<difference.length; i++){
                          $('#forinterior2').append(
                            '<div class="row col s12">\
                            <div class="col s6"><input type="text" name="category[]" value="'+ difference[i] +'" readonly/></div>\
                            <div class="col s6"><input type="text" name="commission[]" value="5"/></div>\
                           </div>\
                           ')
                         }
                      }
                      else{
                        $('#forinterior2').html("");
                        $('#forinterior2').show();
                        $('#forinterior2').append(
                          '<div class="row col s12">\
                          <div class="col s6" style="font-weight: 800;">Category</div>\
                          <div class="col s6" style="font-weight: 800;">Commision</div>\
                         </div>\
                          ');
                        for(var i=0; i<category2.length; i++){
                          $('#forinterior2').append(
                            '<div class="row col s12">\
                            <div class="col s6"><input type="text" name="category[]" value="'+ category2[i] +'" readonly/></div>\
                            <div class="col s6"><input type="text" name="commission[]" value="5"/></div>\
                           </div>\
                           ')
                         }
                      }
                    }
                    else{
                      $('#forinterior2').html("");
                        $('#forinterior2').hide();
                        $('#forinterior2').append(
                          '<div class="row col s12">\
                          <div class="col s6" style="font-weight: 800;">Category</div>\
                          <div class="col s6" style="font-weight: 800;">Commision</div>\
                         </div>\
                          ');
                        for(var i=0; i<category2.length; i++){
                          $('#forinterior2').append(
                            '<div class="row col s12">\
                            <div class="col s6"><input type="text" name="category[]" value="'+ category2[i] +'" readonly/></div>\
                            <div class="col s6"><input type="text" name="commission[]" value="5"/></div>\
                           </div>\
                           ')
                         }
                    }
                    
                }
            })
      })
      $(document).on('click', '.deletebtn', function(e){
          e.preventDefault();
            var cust_id = $(this).val();
            $('#deletecustmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editcustomer/"+cust_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#deleteid').val(response.customer.id);
                    $('#custname').html(response.customer.name);
                }
            })
      })


    $('#addform').submit(function(e){
    e.preventDefault();
        $('#usernameerror').text('')
        $('#emailerror').text('')
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/customeradd",
        data:$('#addform').serialize(),
        type:'post',
        success:function(response){
            $('#addform')['0'].reset();
            fetchCustomer();
            M.toast({html: 'Customer Added!'})
        },
        error:function (response) {
          if(response.responseJSON.errors.username){
            var unerr = response.responseJSON.errors.username;  
            M.toast({html: unerr})
          }
          if(response.responseJSON.errors.phone){
            var emerr = response.responseJSON.errors.phone;  
            M.toast({html: emerr})
          }
        }
    })
  });
  $('#editform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/customerupdate",
        data:$('#editform').serialize(),
        type:'post',
        success:function(result){
            fetchCustomer();
            M.toast({html: 'Customer Updated!'})
        },
        error:function (response) {
          if(response.responseJSON.errors.username){
            var unerr = response.responseJSON.errors.username;  
            M.toast({html: unerr, classes: 'red'})
          }
          if(response.responseJSON.errors.phone){
            var emerr = response.responseJSON.errors.phone;  
            M.toast({html: emerr, classes: 'red'})
          }
        }
    })
  });
  $('#deleteform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/deletecustomer",
        data:$('#deleteform').serialize(),
        type:'post',
        success:function(result){
            fetchCustomer();
            M.toast({html: 'Customer Deleted!'})
        }
    })
  });

  var clicked = 0;

  $(".toggle-password").click(function (e) {
     e.preventDefault();

    $(this).toggleClass("toggle-password");
      if (clicked == 0) {
        $(this).html('<span class="material-icons">visibility_off</span >');
         clicked = 1;
      } else {
         $(this).html('<span class="material-icons">visibility</span >');
          clicked = 0;
       }

    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
       input.attr("type", "text");
    } else {
       input.attr("type", "password");
    }
});
  })