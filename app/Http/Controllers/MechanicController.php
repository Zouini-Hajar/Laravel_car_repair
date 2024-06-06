<?php

namespace App\Http\Controllers;

use App\Exports\MechanicsExport;
use App\Imports\MechanicsImport;
use App\Models\Mechanic;
use App\Models\Repair;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class MechanicController extends Controller
{
    // Show all mechanics
    public function index()
    {
        return view('mechanics.index', [
            'mechanics' => Mechanic::latest('mechanics.created_at')
                ->join('users', 'users.id', '=', 'user_id')
                ->select('mechanics.id', 'first_name', 'last_name', 'cin', 'phone_number', 'picture')
                ->simplePaginate(5)
        ]);
    }

    // Show single mechanic
    public function show(Mechanic $mechanic)
    {
        $repairs = Mechanic::join('repairs', 'mechanics.id', '=', 'mechanic_id')
            ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
            ->join('repairs_details', 'repairs.repair_details_id', '=', 'repairs_details.id')
            ->where('mechanic_id', $mechanic->id)
            ->select('repairs.id', 'description', 'make', 'mechanic_notes', 'repairs.status')
            ->get();
        return view('mechanics.show', [
            'mechanic' => $mechanic,
            'user' => User::find($mechanic->user_id),
            'repairs' => $repairs
        ]);
    }

    // Show form to create new mechanic
    public function create()
    {
        return view('mechanics.create');
    }

    // Store new mechanic
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')],
            'phone_number' => ['required', 'regex:/^(?:\+212|0)([5-7]\d{8})$/', Rule::unique('mechanics', 'phone_number')],
            'cin' => ['required', 'regex:/^[A-Za-z]\d{6}$/', Rule::unique('mechanics', 'cin')],
            'recruitment_date' => 'required|date',
            'salary' => 'required|numeric',
            'picture' => 'nullable|image'
        ]);

        // Create a new user
        $user = User::create([
            'username' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['first_name'] . '_' . $data['last_name'] . '@@'),
            'role' => 'mechanic',
            'picture' => $request->hasFile('picture') ?
                $request->file('picture')->store('pictures', 'public')
                : null
        ]);

        unset($data['email']);
        $data['recruitment_date'] = Carbon::createFromFormat('m/d/Y', $data['recruitment_date'])->format('Y-m-d');

        $mechanic = new Mechanic($data);
        $mechanic->user()->associate($user);
        $mechanic->save();

        return redirect('/mechanics')->with('success', 'Mechanic created successfully!');
    }

    // Show form to edit mechanic
    public function edit(Mechanic $mechanic)
    {
        return view('mechanics.edit', [
            'mechanic' => $mechanic,
            'user' => User::find($mechanic->user_id)
        ]);
    }

    // Update mechanic
    public function update(Request $request, Mechanic $mechanic)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email'],
            'phone_number' => ['required', 'regex:/^(?:\+212|0)([5-7]\d{8})$/'],
            'cin' => ['required', 'regex:/^[A-Za-z]\d{6}$/'],
            'recruitment_date' => 'required|date',
            'salary' => 'required|numeric',
            'picture' => 'nullable|image'
        ]);

        $user = User::find($mechanic->user_id);
        $user->update([
            'email' => $data['email'],
            'picture' => $request->hasFile('picture') ?
                $request->file('picture')->store('pictures', 'public')
                : $user->picture
        ]);

        unset($data['email']);
        $data['recruitment_date'] = Carbon::createFromFormat('m/d/Y', $data['recruitment_date'])->format('Y-m-d');

        $mechanic->update($data);

        $path = '/mechanics' . '/' . $mechanic->id . (auth()->user()->role == 'mechanic' ? '/edit' : '');

        return redirect($path)->with('success', 'Mechanic updated successfully!');
    }

    // Delete mechanic
    public function destroy(Mechanic $mechanic)
    {
        $user = User::find($mechanic->user_id);
        if ($user) {
            $user->delete();
        }

        $mechanic->delete();

        return redirect('/mechanics')->with('success', 'Mechanic deleted successfully!');
    }

    public function export()
    {
        return Excel::download(new MechanicsExport, 'mechanics.xlsx');
    }

    public function import()
    {
        Excel::import(new MechanicsImport, request()->file('file'));
        return back()->with('success', 'File imported successfully!');
    }
}
