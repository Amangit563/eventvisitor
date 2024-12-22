<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticketscann;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TicketscannController extends Controller
{
    // *******************************************  Comman Function  ***********************************
    
    public function userDetail(){
        $user = Auth::user();
        $userId = $user->id;
        $role = $user->role;
        
        return compact('user', 'userId','role');
    }
    // ************************************  Scyn Ticket Scann *********************************************
    
    public function scynTicket(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'sycnticket' => 'required|array',
        'sycnticket.*.user_id' => 'required|integer',
        'sycnticket.*.ticket_id' => 'required|string',
        'sycnticket.*.name' => 'nullable|string',
        'sycnticket.*.date' => 'nullable|string',
        'sycnticket.*.time' => 'nullable|string',
        'sycnticket.*.device_no' => 'nullable|string',
        'sycnticket.*.phone' => 'nullable|string',
        'sycnticket.*.email' => 'nullable|string',
        'sycnticket.*.designation' => 'nullable|string',
        'sycnticket.*.company_name' => 'nullable|string',
        'sycnticket.*.company_location' => 'nullable|string',
        'sycnticket.*.event_name' => 'nullable|string',
        'sycnticket.*.event_location' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => "Validation Errors",
            'errors' => $validator->errors()
        ], 422);
    }

    if (isset($request->sycnticket) && is_array($request->sycnticket)) {
        $sycnticket_ids = [];

        foreach ($request->sycnticket as $ticketData) {
            $createdTicket = Ticketscann::create([
                'user_id' => $ticketData['user_id'],
                'ticket_id' => $ticketData['ticket_id'],
                'name' => $ticketData['name'] ?? null,
                'date' => $ticketData['date'] ?? null,
                'time' => $ticketData['time'] ?? null,
                'device_no' => $ticketData['device_no'] ?? null,
                'phone' => $ticketData['phone'] ?? null,
                'email' => $ticketData['email'] ?? null,
                'designation' => $ticketData['designation'] ?? null,
                'company_name' => $ticketData['company_name'] ?? null,
                'company_location' => $ticketData['company_location'] ?? null,
                'event_name' => $ticketData['event_name'] ?? null,
                'event_location' => $ticketData['event_location'] ?? null,
            ]);

            $sycnticket_ids[] = $createdTicket->ticket_id;
        }

        return response()->json([
            'status' => true,
            'message' => "Data Synced Successfully",
            'ticket_ids' => $sycnticket_ids
        ], 200);
    } else {
        return response()->json([
            'status' => false,
            'message' => "Invalid data provided."
        ], 400);
    }
}



    // *************************  Get All Tickets Data *****************************
    public function getAllTickets(){
        $userData = $this->userDetail();
        $userId = $userData['userId'];
        $role = $userData['role'];
         if($role == "admin"){
             $tickets = Ticketscann::all();
         }else{
            $tickets = Ticketscann::where('user_id', $userId)->get();   
         }

        return view('Admin Report.Report', Compact('tickets','userData'));
    }
    
    
}
