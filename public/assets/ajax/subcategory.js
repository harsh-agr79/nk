$(document).ready(function(){

    fetchsubCategory();
      function fetchsubCategory(){
          $.ajax({
              type:"GET",
              url:"/subcategoryget",
              dataType:"json",
              success:function(response){
                  $('tbody').html("");
                  $.each(response.subcategories, function(key, item){
                    $('tbody').append(
                        '<tr>\
                            <td>'+item.sub+'</td>\
                            <td>'+item.parent+'</td>\
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
            var subc_id = $(this).val();
            $('#editsubcmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editsubcategory/"+subc_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#editsubcategory').val(response.subcategory.sub);
                    $('#editparent').val(response.subcategory.parent);
                    $('#editid').val(response.subcategory.id);
                }
            })
      })
      $(document).on('click', '.deletebtn', function(e){
          e.preventDefault();
            var subc_id = $(this).val();
            $('#deletesubcmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editsubcategory/"+subc_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#deleteid').val(response.subcategory.id);
                    $('#subcname').html(response.subcategory.sub);
                }
            })
      })


    $('#addform').submit(function(e){
    e.preventDefault();
        $('#usernameerror').text('')
        $('#emailerror').text('')
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/subcategoryadd",
        data:$('#addform').serialize(),
        type:'post',
        success:function(response){
            if(response.message == 'SubCategory Already Exists in Parent Category'){
                M.toast({html:response.message, classes:'red'})
            }
            else{
                $('#addform')['0'].reset();
                fetchsubCategory();
                M.toast({html: 'Sub-Category Added!'})
            }  
        },
        // error:function (response) {
        //   if(response.responseJSON.errors.category){
        //     var unerr = response.responseJSON.errors.category;  
        //     M.toast({html: unerr, classes: 'red'})
        //   }
        // }
    })
  });
  $('#editform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/subcategoryupdate",
        data:$('#editform').serialize(),
        type:'post',
        success:function(result){
            if(result.message == 'SubCategory Already Exists in Parent Category'){
                M.toast({html:result.message, classes:'red'})
            }
            else{
                fetchsubCategory();
                M.toast({html: 'Sub-Category Updated!'})
            }
            
        },
        // error:function (response) {
        //   if(response.responseJSON.errors.category){
        //     var unerr = response.responseJSON.errors.category;  
        //     M.toast({html: unerr, classes: 'red'})
        //   }
        // }
    })
  });
  $('#deleteform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/deletesubcategory",
        data:$('#deleteform').serialize(),
        type:'post',
        success:function(result){
            fetchsubCategory();
            M.toast({html: 'Sub-Category Deleted!'})
        }
    })
  });
  })