@extends('admin/layout')

<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('main')
<style>
    .field-icon {
    float: right;
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
    z-index: 2;
}
</style>
    
    <div class="container">
        <div class="red-text center-align" style="font-size: 15px;" id="usernameerror"></div>
        <div class="red-text center-align" style="font-size: 15px;" id="emailerror"></div>
        <span class="center-align"><h4>Customers List</h4></span>
        <div class="center"><a href="#add" class="theme btn waves-effect modal-trigger">ADD <i class="material-icons right">add</i></a></div>
        <div id="add" class="modal">
            <div class="modal-content">
              <h4>Add Customer</h4>
              <form id="addform" class="row">
                  @csrf
                  <div class="col s12 m6">
                    <input type="text" name="name" placeholder="Name" required>
                  </div>
                  <div class="col s12 m6">
                    <input type="text" name="username" placeholder="username" required>
                  </div>
                  <div class="col s12 m6">
                    <input type="text" name="phone" placeholder="Phone Number" required>
                  </div>
                  <div class="col s12 m6">
                    <input type="text" name="address" placeholder="address" required>
                  </div>
                  <div class="input-filed col s12 m6">
                    <select name="type" id="custype" required>
                        <option value="" disabled selected>Type</option>
                        <option value="wholesaler">WholeSaler</option>
                        <option value="retailer">Retailer</option>
                        <option value="interior">Interior</option>
                      </select>
                  </div>
                  <div class="input-filed col s12 m6">
                    <select name="code" required>
                        <option value="+91" selected>Country Code</option>
                        <option value="+91">+91</option>
                        <option value="+977">+977</option>
                      </select>
                  </div>
                  <div class='row col s12 m6'>
                    <div class='input-field col s12'>
                      <input class='validate' type='password' name='password' placeholder="password" id='password' />
                      <span toggle="#password" class="field-icon toggle-password"><span class="material-icons">visibility</span></span>
                     </div>
                 </div>
                 <div id="forinterior" style="display: none;">
                  <div class="col s12 row">
                    <div class="col s6" style="font-weight: 800;">Category</div>
                    <div class="col s6" style="font-weight: 800;">Commision</div>
                   </div>
                   @foreach ($category as $item)
                   <div class="col s12 row">
                    <div class="col s6"><input type="text" name="category[]" value="{{$item->category}}" readonly></div>
                    <div class="col s6"><input type="text" name="commission[]" value="5"></div>
                   </div>
                   @endforeach
                 </div>
                
                  <div class="center col s12" style="margin-top:5vh;">
                    <button class="btn theme waves-effect modal-close" id="addbtn" type="submit">Submit<i class="material-icons right">send</i></button>
                  </div>
              </form>
            </div>
            <div class="modal-footer">

            </div>
          </div>
        <div style="overflow-x: scroll">
            <table>
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Username</td>
                        <td>Phone</td>
                        <td>Type</td>
                        <td>Address</td>
                        <td>Edit</td>
                        <td>Delete</td>
                    </tr>
                </thead>
                <tbody id="main">
                    
                </tbody>
            </table>
        </div>
        
    </div>

    <div class="editmodal">
        <div id="editcustmodal" class="modal">
            <div class="modal-content">
              <h4>Edit Customer</h4>
              <form id="editform" class="row">
                  @csrf
                  <input type="hidden" id="editid" name="id">
                  <div class="col s12 m6">
                    <input type="text" name="name" id="editname" placeholder="Name" required>
                  </div>
                  <div class="col s12 m6">
                    <input type="text" name="username" id="editusername" placeholder="username" required>
                  </div>
                  <div class="col s12 m6">
                    <input type="text" name="phone" id="editphone" placeholder="Phone Number" required>
                  </div>
                  <div class="col s12 m6">
                    <input type="text" name="address" id="editaddress" placeholder="address" required>
                  </div>
                  <div class="input-filed col s12 m6">
                    <select name="type" class="browser-default" id="edittype" required>
                        <option value="" disabled selected>Type</option>
                        <option value="wholesaler">WholeSaler</option>
                        <option value="retailer">Retailer</option>
                        <option value="interior">Interior</option>
                      </select>
                  </div>
                  <div class="input-filed col s12 m6">
                    <select name="code" class="browser-default" id="editcode" required>
                        <option value="" disabled selected>Country Code</option>
                        <option value="+91">+91</option>
                        <option value="+977">+977</option>
                      </select>
                  </div>
                
                  <div class='row col s12 m6'>
                    <div class='input-field col s12'>
                      <input class='validate' type='password' placeholder="password" name='password' id='editpw' />
                      <span toggle="#editpw" class="field-icon toggle-password"><span class="material-icons">visibility</span></span>
                    </div>

                 </div>
                 <div id="forinterior2">

                </div>
                  <div class="center col s12" style="margin-top:5vh;">
                    <button class="btn theme waves-effect modal-close" id="upbtn" type="submit">Update<i class="material-icons right">send</i></button>
                  </div>
              </form>
            </div>
            <div class="modal-footer">

            </div>
          </div>
    </div>
    <div class="deletemodal">
        <div id="deletecustmodal" class="modal">
            <div class="modal-content">
              <h4>Are you sure you want to delete <span id="custname"></span> from Customers?</h4>
              <form id="deleteform" class="row">
                  @csrf
                  <input type="hidden" id="deleteid" name="id">
                  <div class="center col s12" style="margin-top:5vh;">
                    <span class="btn grey darken-2 waves-effect modal-close">Cancel<i class="material-icons right">close</i></span>
                    <button class="btn red waves-effect modal-close" id="delbtn" type="submit">delete<i class="material-icons right">delete</i></button>
                  </div>
              </form>
            </div>
            <div class="modal-footer">

            </div>
          </div>
    </div>
    <script src="{{asset('assets/ajax/customer.js')}}"></script>
    <script>
      
    </script>
@endsection