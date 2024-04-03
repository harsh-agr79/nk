$(document).ready(function(){

    fetchCategory();
      function fetchCategory(){
          $.ajax({
              type:"GET",
              url:"/categoryget",
              dataType:"json",
              success:function(response){
                  $('tbody').html("");
                  $.each(response.categories, function(key, item){
                    $('tbody').append(
                        '<tr>\
                            <td>'+item.category+'</td>\
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
            var catg_id = $(this).val();
            $('#editcatgmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editcategory/"+catg_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#editcategory').val(response.category.category);
                    $('#editid').val(response.category.id);
                }
            })
      })
      $(document).on('click', '.deletebtn', function(e){
          e.preventDefault();
            var catg_id = $(this).val();
            $('#deletecatgmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editcategory/"+catg_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#deleteid').val(response.category.id);
                    $('#catgname').html(response.category.catgory);
                }
            })
      })


    $('#addform').submit(function(e){
    e.preventDefault();
        $('#usernameerror').text('')
        $('#emailerror').text('')
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/categoryadd",
        data:$('#addform').serialize(),
        type:'post',
        success:function(response){
            $('#addform')['0'].reset();
            fetchCategory();
            M.toast({html: 'Category Added!'})
        },
        error:function (response) {
          if(response.responseJSON.errors.category){
            var unerr = response.responseJSON.errors.category;  
            M.toast({html: unerr, classes: 'red'})
          }
        }
    })
  });
  $('#editform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/categoryupdate",
        data:$('#editform').serialize(),
        type:'post',
        success:function(result){
            fetchCategory();
            M.toast({html: 'Category Updated!'})
        },
        error:function (response) {
          if(response.responseJSON.errors.category){
            var unerr = response.responseJSON.errors.category;  
            M.toast({html: unerr, classes: 'red'})
          }
        }
    })
  });
  $('#deleteform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/deletecategory",
        data:$('#deleteform').serialize(),
        type:'post',
        success:function(result){
            fetchCategory();
            M.toast({html: 'Category Deleted!'})
        }
    })
  });
  })