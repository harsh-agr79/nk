$(document).ready(function(){

    fetchExpense();
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
      function fetchExpense(){
          $.ajax({
              type:"GET",
              url:"/expenseget",
              dataType:"json",
              success:function(response){
                  $('tbody').html("");
                  $.each(response.expenses, function(key, item){
                    $('tbody').append(
                        '<tr>\
                            <td>'+item.username+'</td>\
                            <td>'+item.expenseid+'</td>\
                            <td>'+item.particular+'</td>\
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
            var exps_id = $(this).val();
            $('#editexpsmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editexpense/"+exps_id,
                dataType:"json",
                success:function(response){
                    $('#editusername').val(response.expense.username);
                    $('#editdate').val(response.expense.date);
                    $('#editid').val(response.expense.id);
                    $('#editparticular').val(response.expense.particular);
                    $('#editamount').val(response.expense.amount);
                }
            })
      })
      $(document).on('click', '.deletebtn', function(e){
          e.preventDefault();
            var exps_id = $(this).val();
            $('#deleteexpsmodal').modal('open');
            $.ajax({
                type:"GET",
                url:"/editexpense/"+exps_id,
                dataType:"json",
                success:function(response){
                    // console.log(response)
                    $('#deleteid').val(response.expense.id);
                    $('#expenseid').html(response.expense.expenseid);
                }
            })
      })


    $('#addform').submit(function(e){
    e.preventDefault();
        $('#usernameerror').text('')
        $('#emailerror').text('')
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/expenseadd",
        data:$('#addform').serialize(),
        type:'post',
        success:function(response){
            $('#addform')['0'].reset();
            fetchExpense();
            // console.log(response)
            M.toast({html: 'Expense Added!'})
        },
    })
  });
  $('#editform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/expenseupdate",
        data:$('#editform').serialize(),
        type:'post',
        success:function(result){
            fetchExpense();
            M.toast({html: 'Expense Updated!'})
        },
    })
  });
  $('#deleteform').submit(function(e){
    e.preventDefault();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/deleteexpense",
        data:$('#deleteform').serialize(),
        type:'post',
        success:function(result){
            fetchExpense();
            M.toast({html: 'Expense Deleted!'})
        }
    })
  });
  })