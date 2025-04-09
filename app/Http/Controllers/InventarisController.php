<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index()
    {
        return view('inventaris.index');
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        // Logic to store data
    }

    public function show($id)
    {
        return view('inventaris.show', compact('id'));
    }

    public function edit($id)
    {
        return view('inventaris.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update data
    }

    public function destroy($id)
    {
        // Logic to delete data
    }

}
