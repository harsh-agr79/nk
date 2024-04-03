@extends('admin/layout')

<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('main')

    
    <div class="container">
        <div class="red-text center-align" style="font-size: 15px;" id="usernameerror"></div>
        <div class="red-text center-align" style="font-size: 15px;" id="emailerror"></div>
        <span class="center-align"><h4>Sub-Category List</h4></span>
        <div class="center"><a href="#add" class="theme btn waves-effect modal-trigger">ADD <i class="material-icons right">add</i></a></div>
        <div id="add" class="modal">
            <div class="modal-content">
              <h4>Add Category</h4>
              <form id="addform" class="row">
                  @csrf
                  <div class="col s12 m6">
                    <input type="text" name="sub" placeholder="Sub-Category Name" required>
                  </div>
                  <div class="input-filed col s12 m6">
                    <select name="parent" required>
                        <option value="" disabled selected>Parent Category</option>
                        @foreach($category as $item)
                            <option value="{{$item->category}}">{{$item->category}}</option>
                        @endforeach
                      </select>
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
                        <td>Sub-Category</td>
                        <td>Parent</td>
                        <td>Edit</td>
                        <td>Delete</td>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        
    </div>

    <div class="editmodal">
        <div id="editsubcmodal" class="modal">
            <div class="modal-content">
              <h4>Edit Sub-Category</h4>
              <form id="editform" class="row">
                  @csrf
                  <input type="hidden" id="editid" name="id">
                  <div class="col s12 m6">
                    <input type="text" name="sub" id="editsubcategory" placeholder="Sub-Category" required>
                  </div>
                  <div class="input-filed col s12 m6">
                    <select name="parent" id="editparent" required>
                        <option value="" disabled selected>Parent Category</option>
                        @foreach($category as $item)
                            <option value="{{$item->category}}">{{$item->category}}</option>
                        @endforeach
                      </select>
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
        <div id="deletesubcmodal" class="modal">
            <div class="modal-content">
              <h4>Are you sure you want to delete <span id="subcname"></span> from Sub-Categories?</h4>
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
    <script src="{{asset('assets/ajax/subcategory.js')}}"></script>
@endsection