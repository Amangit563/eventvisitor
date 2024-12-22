<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users,email',
        'phone' => 'required|string',
        'company_name' => 'required|string',
        'company_location' => 'required|string',
        'event_name' => 'required|string',
        'event_location' => 'required|string',
        'parent_id' => 'nullable|integer',
        'col1' => 'nullable|string',
        'col2' => 'nullable|string',
        'col3' => 'nullable|string',
        'role' => 'required|string',
        'status' => 'nullable|in:0,1', // Nullable, will default to 1 if not provided
        'designation' => 'required|string',
        'password' =>'required|string'
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation errors',
            'error' => $validator->errors(),
        ], 422);
    }

    // Add default value for `status` if not provided
    $data = $request->all();
    $data['status'] = $request->input('status', 1); // Default to 1 if not provided
    $data['parent_id'] = $request->input('parent_id', 1); // Default parent_id to 1

    // Proceed to create the user
    $user = User::create($data); // Adjust to your actual model and fields

    // Return a successful response
    return response()->json([
        'status'=> 200,
        'message' => 'Registration successful',
        'data' => $user,
    ], 201);
}


// *******************************   Login Api  **********************************************

public function login(Request $request){
    $validator = Validator::make($request->all(),[
        'phone' => 'required|string',
        'password' => 'required|min:4'
    ]);

    if($validator->fails()){
        return response()->json([
            'massage' => "Validation Error!!!",
            'error' => $validator->errors()
        ], 422);
    }

    // $phone = $request->input('phone');
    // $password = $request->input('password');

    if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password])){
        $user = Auth::user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        return response()->json([
            'massage' => "Login Successfully!",
            'token' => $token,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'company_name' => $user->company_name,
            'company_location' => $user->company_location,
            'event_name' => $user->event_name,
            'event_location' => $user->event_location,
            'parent_id' => $user->parent_id,
            'status' => $user->status,
            'desigenation' => $user->desigenation,
            'user' => $user
        ]);
    }

    return response()->json([
        'massage' => "Phone or Password Invalid!!!",

    ], 401);


}


// ************************  Comman Function  ***********************

    public function getUserCommanDetail(){
        $user = Auth::user();
        $admin_id = $user->id;
        $role = $user->role;
        $name = $user->name;
        
        return compact('user', 'admin_id', 'role', 'name');
    }

    // ***********************  Get Admin User Details  *****************************
    public function userDetail(){
        $userData = $this->getUserCommanDetail();
        $user = Auth::user();
        $admin_id = $user->id;

        $getUsers = User::where('parent_id', $admin_id)
                        ->where('role', 'user')
                        ->get();

        return view('ManageUser', compact('getUsers', 'userData'));

    }



    // ****************************  Change Password  *************************
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:users,id',
            'newpassword' => 'required|string|min:4',
            'password_confirmation' => 'required|string|same:newpassword',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Validation Errors!!!",
                'error' => $validator->errors()
            ], 422);
        }

        $id = $request->input('id');
        $password = $request->input('newpassword');

        // Fetch the user by ID
        $user = User::find($id);

        if ($user) {
            // Update the password and save
            $user->password = Hash::make($password);
            $user->save();

            return response()->json(['status'=> 200, 'message' => 'Password updated successfully']);
        }

        // Fallback for user not found (though validation should already ensure this doesn't happen)
        return response()->json(['message' => 'User not found'], 404);
    }
    
    
    
    // *******************************************************************************    D E L E T E    **************************************************************************************************

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return back();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }


// ******************************************************************************   S T A T U S   U P D A T E   ******************************************************************************************

    public function userstatus(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
                // Toggle the admin's status
                $user->status = !$user->status;
                $user->save();
        
                // If the user is an admin and the status is set to 0 (inactive), 
                // set the status of all users under this admin to 0 as well.
                if ($user->status == 0) {
                    // Update all users with the same parent_id as the admin's id to status 0
                    User::where('parent_id', $user->id)
                        ->update(['status' => 0]);
                }
        
                return response()->json([
                    'message' => '✅️ Status updated successfully', 
                    'userstatus' => $user->status
                ]);
            }
        
            // Return error response if the user (admin) is not found
            return response()->json(['error' => '😔 User not found'], 404);
    }
    
    
    // *******************************  User Create Page  Show  ******************************************
public function getUserCreatePage(){
    try {
        $userData = $this->getUserCommanDetail();
        return view('CreateUser', compact('userData'));
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Failed to load user details.']);
    }
    
}

// **********************  Get User Name and Password  *****************************
public function getUserNamePassword($id)
    {
        $user = User::select('phone', 'password')->where('id', $id)->first();

        if ($user) {
            return response()->json(['success' => true, 'data' => [
                'phone' => $user->phone,
                'password' => $user->password, // Return hashed password
            ]
            
            ]);
        }

        return response()->json(['success' => false, 'message' => 'User not found']);
    }


}
