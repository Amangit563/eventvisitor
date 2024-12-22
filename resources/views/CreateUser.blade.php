@extends('Layout.layout')
@section('title','User Create Form')
@section('content')

<style>
    .form-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}
.validate{
    color: red;
}
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
</style>
<div class="container">
    <div class="form-container">
        <h3 class="text-center mb-4">User Registration</h3>
         <!--<div class="alert alert-success" id="success_message" style="display:none"></div>-->
        <form id="registerForm" >
            @csrf
            <!-- Name Field -->
            <input type="hidden" id="parent_id" value="{{ auth()->user()->id }}">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your full name" >
                <span id="errname" class="validate"></span>
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email_Id</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" >
                <span id="erremail" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Phone_Number</label>
                <input type="text" class="form-control" id="phone" placeholder="Enter your Phone number" >
                <span id="errphone" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="company" class="form-label">Company_Name</label>
                <input type="text" class="form-control" id="company_name" placeholder="Enter your Company Name" >
                <span id="errcompany_name" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="company" class="form-label">Company_location</label>
                <input type="text" class="form-control" id="company_location" placeholder="Enter your Company Location" >
                <span id="errcompany_location" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="event" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="event_name" placeholder="Enter your Event Name" >
                <span id="errevent_name" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="event" class="form-label">Event Location</label>
                <input type="text" class="form-control" id="event_location" placeholder="Enter your Event Location" >
                <span id="errevent_location" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <span id="errrole" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" class="form-control" id="designation" placeholder="Enter your Designation" >
                <span id="errdesignation" class="validate"></span>
            </div>



            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" >
                <span id="errpassword" class="validate"></span>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>

    <div id="success_message_box" class="success-message-box" style="display: none;">
        <span id="success_message"></span>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    // Bind submit event to the form
    $(document).ready(function () {
        $('#registerForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            var parent_id = $('#parent_id').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var company_name = $('#company_name').val();
            var company_location = $('#company_location').val();
            var event_name = $('#event_name').val();
            var event_location = $('#event_location').val();
            var role = $('#role').val();
            var designation = $('#designation').val();
            var password = $('#password').val();

            // AJAX request
            $.ajax({
                url: "{{ url('/register') }}",
                type: "POST", // Corrected the typo
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                data: {
                    parent_id: parent_id,
                    name: name,
                    email: email,
                    phone: phone,
                    company_name: company_name,
                    company_location: company_location,
                    event_name: event_name,
                    event_location: event_location,
                    role: role,
                    designation: designation,
                    password: password
                },
                success: function (response) {
                    if (response.status == 200) {
                        $('#success_message').text("✅ User Created Successfully!");
                        $('#success_message_box').fadeIn();

                        $('#registerForm')[0].reset();

                        setTimeout(() => {
                            $('#success_message_box').fadeOut();
                        }, 5000);
                    } else {
                        alert(response.error);
                    }
                },
                error: function (xhr, status, error) {
                    const parsedResponse = JSON.parse(xhr.responseText);
                    let keys = ['name', 'email', 'phone', 'company_name', 'company_location', 'event_name', 'event_location', 'role', 'designation', 'password'];

                    keys.forEach((key) => {
                        if (parsedResponse.error.hasOwnProperty(key)) {
                            $(`#err${key}`).text(parsedResponse.error[key][0]);
                            setTimeout(() => {
                                $(`#err${key}`).text(''); // Reset error message after 5 seconds
                            }, 5000);
                        }
                    });

                }
            });
        });
    });
</script>

@endsection
