@extends('Layout.layout')
@section('title','User Create Form')
@section('content')

<style>
    .success-message-box {
    position: fixed;
    bottom: 45px;
    right: 30px;
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border: 3px solid #c3e6cb;
    border-radius: 5px;
    font-size: 20px;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .error-message-box {
        position: fixed;
        bottom: 45px;
        right: 30px;
        background-color: #f3edea;
        color: #f01b1b;
        padding: 15px;
        border: 3px solid #f82112;
        border-radius: 5px;
        font-size: 20px;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }   
</style>
<div class="heading">
    <h4 class="mt-3">Managers Users</h4>
</div>

<div class="row mt-4 table-responsive">
    <table id="exampleTable" class="table table-hover table-responsive" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Role</th>
                <th>Staus</th>
                <th>User Report</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($getUsers as $getUser)
                <tr>
                    <td>{{ $getUser->id }}</td>
                    <td>{{ $getUser->name }}</td>
                    <td>{{ $getUser->phone }}</td>
                    <td>{{ $getUser->role }}</td>
                    <td>
                            <form id="statusForm-{{ $getUser->id  }}" action="{{ route('userStatus') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $getUser->id  }}">
                                <button type="button" class="btn btn-sm btn-{{ $getUser->status ? 'success' : 'danger' }}" onclick="toggleStatus({{ $getUser->id }})">
                                    {{ $getUser->status ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success userpanal" onclick="openNewTab(this)" data-id="{{$getUser->id}}" >User Panal</button>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-secondary btnedit" data-id="{{$getUser->id}}" data-bs-toggle="modal" data-bs-target="#editModal" >Edit</button>
                                                    
                        <form action="{{ route('user.destroy', ['id' => $getUser->id]) }}" method="POST" style="display:inline;" id="deleteForm{{ $getUser->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="confirmDelete({{ $getUser->id }})">
                                    Delete
                                </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



{{-- ************************  Edit Modal  ********************** --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" value="" id="hiddenUserID"/>
                <h5 class="modal-title" id="exampleModalLabel">Update Login Credentials</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveChangesButton" >Save changes</button>
            </div>
        </div>
    </div>
</div>


<div id="success_message_box" class="success-message-box" style="display: none;">
    <span id="success_message"></span>
</div>

<div id="error_message_box" class="error-message-box" style="display: none;">
    <span id="error_message"></span>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).on('click', '.btnedit', function(){
        var userID = $(this).data('id');
        $('#hiddenUserID').val(userID);
    })

    document.getElementById('saveChangesButton').addEventListener('click', function() {
        saveChanges(); // Call the function
    });

    // Define the function
    function saveChanges() {
        var id = $('#hiddenUserID').val();
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        $.ajax({
            url: "{{ url('/updatePassword') }}", // Endpoint URL
            method: 'POST', // HTTP method
            data: {
                id: id,
                newpassword: newPassword,
                password_confirmation: confirmPassword,
                _token: '{{ csrf_token() }}' // Add CSRF token if using Laravel
            },
            success: function(response) {
                if(response.status == 200){
                    // *** Modal Empty
                    $('#newPassword').val('');
                    $('#confirmPassword').val('');
                    $('#hiddenUserID').val('');
                    // *** Modal Hide
                    $('#editModal').modal('hide');
                    //    Message Show
                    $('#success_message').text("✅ Password Updated Successfully!");
                    $('#success_message_box').fadeIn();
                    setTimeout(() => {
                        $('#success_message_box').fadeOut();
                    }, 8000);
                }
            },
            error: function(xhr, status, error) {
                if(xhr.status==422){
                    $('#editModal').modal('hide');

                    $('#error_message').text("❌ Password Confirmation Not Match!!!");
                    $('#error_message_box').fadeIn();
                    setTimeout(() => {
                        $('#error_message_box').fadeOut();
                    }, 4000);
                }
                // console.error('Error updating password:', error);
                // alert('Failed to update password. Please try again.');
            }
        });

    }
    
    
        //***************************************************************** User Active And Deactive ************************************************************************-->
    function toggleStatus(userId) 
    {
        var form = $('#statusForm-' + userId);
            var button = form.find('button');
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    if (response.userstatus) { // Use 'status' instead of 'userstatus'
                        button.removeClass('btn-danger').addClass('btn-success').text('Active');
                    } else {
                        button.removeClass('btn-success').addClass('btn-danger').text('Inactive');
                    }
                },
                error: function() {
                    alert('An error occurred while updating the status.');
                }
        });
    }
    
    
    
         function confirmDelete(userId) {
            // Show confirmation dialog
            if (confirm("Are you sure you want to delete this user?")) {
                // If confirmed, submit the form
                document.getElementById('deleteForm' + userId).submit();
            }
        }
        
        
        // *************************  User Panal With New tab  **********************************
        
    function openNewTab(button) {
        const userId = $(button).data('id');
        
        if (userId) {
            $.ajax({
                url: `/get-username-password/${userId}`, // Laravel route
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const { phone, password } = response.data;
                        alert(`Phone: ${phone}, Password: ${password}`);
                        
                        // Example of opening a new tab with the fetched details
                        const url = `https://eventvisitors.acural.in/login/?phone=${phone}&password=${password}`;
                        window.open(url, '_blank');
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while fetching user details.');
                }
            });
        } else {
            alert('User ID not found.');
        }
    }




</script>

@endsection
