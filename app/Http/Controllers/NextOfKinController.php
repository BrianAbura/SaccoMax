<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NextOfKin;

class NextOfKinController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        $nextOfKin = new NextOfKin();
        $nextOfKin->user_id = $request->member_id;
        $nextOfKin->first_name = $request->first_name;
        $nextOfKin->last_name = $request->last_name;
        $nextOfKin->phone_number = $request->phone_number;
        $nextOfKin->email = $request->email;
        $nextOfKin->address = $request->address;
        $nextOfKin->save();

        logAudit('Added Next of Kin', 'next_of_kin', $nextOfKin->id, [], $nextOfKin->toArray());

        return redirect()->back()->with('success', 'Next of kin added successfully');
    }

    public function update(Request $request, NextOfKin $nextOfKin)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        $nextOfKin = NextOfKin::findOrFail($nextOfKin->id);
        $old_nextOfKin = $nextOfKin->toArray();
        $nextOfKin->first_name = $request->first_name;
        $nextOfKin->last_name = $request->last_name;
        $nextOfKin->phone_number = $request->phone_number;
        $nextOfKin->email = $request->email;
        $nextOfKin->address = $request->address;
        $nextOfKin->save();

        logAudit('Updated Next of Kin', 'next_of_kin', $nextOfKin->id, $old_nextOfKin, $nextOfKin->toArray());

        return redirect()->back()->with('success', 'Next of kin updated successfully');
    }

    public function destroy(NextOfKin $nextOfKin)
    {
        $nextOfKin->delete();

        return redirect()->back()->with('success', 'Next of kin deleted successfully');
    }
}
