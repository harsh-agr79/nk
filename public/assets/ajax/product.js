function load(){
    $('#filterform').submit()
}
$(document).ready(function(){

    fetchProduct();
    
      function fetchProduct(){
          $.ajax({
              type:"GET",
              url:"/productget",
              dataType:"json",
              success:function(response){
                  $('tbody').html("");
                  $.each(response.products, function(key, item){
                    $('tbody').append(
                        '<tr>\
                            <td>'+item.name+'</td>\
                            <td>'+item.category+'</td>\
                            <td>'+item.stock+'</td>\
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
            var prod_id = $(this).val();
            $('#editprodmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editproduct/"+prod_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#editname').val(response.product.name);
                    $('#editcategory').val(response.product.category).change();
                    $('#editstock').val(response.product.stock).change();
                    $('#editid').val(response.product.id);
                }
            })
      })
      $(document).on('click', '.deletebtn', function(e){
          e.preventDefault();
            var prod_id = $(this).val();
            $('#deleteprodmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editproduct/"+prod_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#deleteid').val(response.product.id);
                    $('#prodname').html(response.product.name);
                }
            })
      })


    $('#addform').submit(function(e){
    e.preventDefault();
        $('#usernameerror').text('')
        $('#emailerror').text('')
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/productadd",
        data:$('#addform').serialize(),
        type:'post',
        success:function(response){
            
                $('#addform')['0'].reset();
                fetchProduct();
                M.toast({html: 'Product Added!'})
            
        },
        error:function (response) {
          if(response.responseJSON.errors.name){
            var unerr = response.responseJSON.errors.name;  
            M.toast({html: unerr, classes: 'red'})
          }
        }
    })
  });
  $('#filterform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/productget2",
        data:$('#filterform').serialize(),
        type:'post',
        success:function(response){
            $('tbody').html("");
            $.each(response.products, function(key, item){
              $('tbody').append(
                  '<tr>\
                      <td>'+item.name+'</td>\
                      <td>'+item.category+'</td>\
                      <td>'+item.stock+'</td>\
                      <td><button value="'+item.id+'" class="btn-small waves-effect theme editbtn"  style="border-radius: 20px;"><i class="material-icons small">edit</i></button></td>\
                      <td><button value="'+item.id+'" class="btn-small deletebtn waves-effect red"  style="border-radius: 20px;"><i class="material-icons small">delete</i></button></td>\
                  </tr>'
              );
            });
        },
        // error:function (response) {
        //   if(response.responseJSON.errors.name){
        //     var unerr = response.responseJSON.errors.name;  
        //     M.toast({html: unerr, classes: 'red'})
        //   }
        // }
    })
  });
  $('#editform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/productupdate",
        data:$('#editform').serialize(),
        type:'post',
        success:function(result){
                $('#filterform').submit();
                M.toast({html: 'Product Updated!'})
        },
        error:function (response) {
          if(response.responseJSON.errors.name){
            var unerr = response.responseJSON.errors.name;  
            M.toast({html: unerr, classes: 'red'})
          }
        }
    })
  });
  $('#deleteform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/deleteproduct",
        data:$('#deleteform').serialize(),
        type:'post',
        success:function(result){
            $('#filterform').submit();
            M.toast({html: 'Product Deleted!'})
        }
    })
  });
  })