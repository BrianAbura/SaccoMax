<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\MessagesNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('staff.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = User::all();
        return view('staff.messages.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message_body' => 'required',
            'message_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        if ($request->message_body == "<p><br></p>") {
            return redirect()->back()->with('error', 'Message body cannot be empty');
        }

        // save the message file
        if ($request->hasFile('message_file')) {
            $file = $request->file('message_file');
            $fileName = 'Message_' . $request->subject . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('message_files'), $fileName);
            $message_file_path = 'message_files/' . $fileName;
        } else {
            $message_file_path = null;
        }

        // send the notification
        if (in_array("ALL", $request->members)) {
            $members = User::all();
            foreach ($members as $member) {
                $details = [
                    'fullname' => $member->first_name . ' ' . $member->last_name,
                    'message_body' => $request->message_body,
                    'message_file' => $message_file_path,
                ];

                // Save to the DB
                $message = new Message();
                $message->user_id = $member->id;
                $message->subject = $request->subject;
                $message->body = strip_tags($request->message_body);
                $message->file_path = $message_file_path;
                $message->added_by = Auth::user()->id;
                $message->save();

                logAudit('Sent Message', 'messages', $message->id, [], $message->toArray());

                $member->notify(new MessagesNotice($request->subject, $details));
            }
        } else {
            $members = $request->members;
            foreach ($members as $member) {
                $user = User::find($member);
                $details = [
                    'fullname' => $user->first_name . ' ' . $user->last_name,
                    'message_body' => $request->message_body,
                    'message_file' => $message_file_path,
                ];

                // Save to the DB
                $message = new Message();
                $message->user_id = $user->id;
                $message->subject = $request->subject;
                $message->body = strip_tags($request->message_body);
                $message->file_path = $message_file_path;
                $message->added_by = Auth::user()->id;
                $message->save();

                logAudit('Sent Message', 'messages', $message->id, [], $message->toArray());

                $user->notify(new MessagesNotice($request->subject, $details));
            }
        }

        return redirect()->route('messages.index')->with('success', 'Message sent successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
