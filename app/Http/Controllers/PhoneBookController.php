<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneBookRequest;
use App\PhoneBook;
use Illuminate\Http\Request;

class PhoneBookController extends Controller
{

    public function index()
    {
        $phonebooks = PhoneBook::orderBy('name', 'ASC')->get();
        return response()->json($phonebooks, 200);
    }


    public function create()
    {
        //
    }


    public function store(PhoneBookRequest $request)
    {
        $pb = new PhoneBook();
        $pb->name = $request->name;
        $pb->email = $request->email;
        $pb->phone = $request->phone;
        $pb->save();
        return $pb;
    }


    public function show(PhoneBook $phoneBook)
    {
        //
    }


    public function edit(PhoneBook $phoneBook)
    {
        //
    }


    public function update(PhoneBookRequest $request, $id)
    {
        $phoneBook = PhoneBook::findOrfail($id);
        $phoneBook->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        return ;
    }


    public function destroy($id)
    {
        $phoneBook = PhoneBook::findOrfail($id);
        $phoneBook->delete();
        return ;
    }
}
