<?php

namespace App\Http\Controllers;

use App\Models\SMSMessages;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SMSMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function formatNumber($num)
    {
        // Only UG numbers are allowed

        $num = trim($num);
        $num = preg_replace('/^07/', '2567', $num);
        $num = preg_replace('/^7/', '2567', $num);
        $num = preg_replace('/^\+2567/', '2567', $num);
        $num = preg_replace('/^\+/', '', $num);
        return $num;
    }

    public function send_sms_api($details)
    {
        try {
            $data = [
                'client_data' => [
                    'client_id' => config('services.sms.client_id'),
                    'api_username' => config('services.sms.api_username'),
                    'api_key' => config('services.sms.api_key')
                ],
                'message_data' => [
                    'mobile_number' => $this->formatNumber($details['phone']),
                    'message' => trim($details['message'])
                ]
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post(config('services.sms.url'), $data);

            $sms = new SMSMessages();
            $sms->user_id = $details['user_id'];
            $sms->phone = $details['phone'];
            $sms->message = trim($details['message']);
            $sms->added_by = $details['added_by'];
            $sms->scheduled_date = $details['scheduled_date'] ?? null;
            $sms->scheduled_time = $details['scheduled_time'] ?? null;
            $sms->status = $response->body();
            $sms->save();

            logAudit('Sent Message', 'sms_messages', $sms->id, [], $sms->toArray());

            return $response->successful();
        } catch (\Exception $e) {
            // Log error and save failed status
            $sms = new SMSMessages();
            $sms->user_id = $details['user_id'];
            $sms->phone = $details['phone'];
            $sms->message = trim($details['message']);
            $sms->added_by = $details['added_by'];
            $sms->scheduled_date = $details['scheduled_date'] ?? null;
            $sms->scheduled_time = $details['scheduled_time'] ?? null;
            $sms->status = 'Failed: ' . $e->getMessage();
            $sms->save();

            return false;
        }
    }

    public function get_sms_balance()
    {
        try {
            $data = [
                'client_data' => [
                    'client_id' => config('services.sms.client_id'),
                    'api_username' => config('services.sms.api_username'),
                    'api_key' => config('services.sms.api_key')
                ],
                'message_data' => [
                    'balance' => 'getBalance',
                ]
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post(config('services.sms.url'), $data);

            return $response;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function index()
    {
        $messages = SMSMessages::orderBy('created_at', 'desc')->get();

        // Get current SMS balance from the latest successful message
        $smsBalance = $this->get_sms_balance();
        return view('staff.sms-messages.index', compact('messages', 'smsBalance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = User::all();
        return view('staff.sms-messages.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message_body' => 'required',
        ]);

        $scheduledDate = $request->filled('schedule_toggle') ? $request->schedule_date : null;
        $scheduledTime = $request->filled('schedule_toggle') ? $request->schedule_time : null;

        if (in_array("ALL", $request->members)) {
            $members = User::all();
            foreach ($members as $member) {
                $details = [
                    'user_id' => $member->id,
                    'phone' => $member->phone_number,
                    'message' => $request->message_body,
                    'added_by' => Auth::user()->id ?? 1,
                    'scheduled_date' => $scheduledDate,
                    'scheduled_time' => $scheduledTime,
                ];

                $this->send_sms_api($details);
            }
        } else {
            $members = $request->members;
            foreach ($members as $member) {
                $user = User::find($member);
                $details = [
                    'user_id' => $user->id,
                    'phone' => $user->phone_number,
                    'message' => $request->message_body,
                    'added_by' => Auth::user()->id ?? 1,
                    'scheduled_date' => $scheduledDate,
                    'scheduled_time' => $scheduledTime,
                ];

                $this->send_sms_api($details);
            }
        }

        return redirect()->route('sms-messages.index')->with('success', 'Action completed successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SMSMessages $sMSMessages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SMSMessages $sMSMessages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SMSMessages $sMSMessages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SMSMessages $sMSMessages)
    {
        //
    }
}
