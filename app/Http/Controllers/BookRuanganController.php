<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BookRuangan;
use Illuminate\Http\Request;

class BookRuanganController extends Controller
{
    //
    public function index()
    {
        // Logic to display the list of booked rooms
        return view('ruangan.book_ruangan.index');
    }
    public function create()
    {
        // Logic to show the form for booking a room
        return view('ruangan.book_ruangan.create');
    }
    public function store(Request $request)
    {
        // Logic to store the booking details
        $validatedData = $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'id_jadwal' => 'required|exists:jadwal_ruangan,id',
            'status_book' => 'required|in:0,1', // 0: Pending, 1: Confirmed
            'expired_at' => 'required|date',
        ]);

        // Store the booking in the database
        BookRuangan::create($validatedData);

        return redirect()->route('book_ruangan.index')->with('success', 'Room booked successfully!');
    }
    public function show($id)
    {
        // Logic to display the details of a specific booking
        $booking = BookRuangan::findOrFail($id);
        return view('ruangan.book_ruangan.show', compact('booking'));
    }
    public function edit($id)
    {
        // Logic to show the form for editing a booking
        $booking = BookRuangan::findOrFail($id);
        return view('ruangan.book_ruangan.edit', compact('booking'));
    }
    public function update(Request $request, $id)
    {
        // Logic to update the booking details
        $validatedData = $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'id_jadwal' => 'required|exists:jadwal_ruangan,id',
            'status_book' => 'required|in:0,1', // 0: Pending, 1: Confirmed
            'expired_at' => 'required|date',
        ]);

        // Update the booking in the database
        $booking = BookRuangan::findOrFail($id);
        $booking->update($validatedData);

        return redirect()->route('book_ruangan.index')->with('success', 'Booking updated successfully!');
    }
    public function destroy($id)
    {
        // Logic to delete a booking
        $booking = BookRuangan::findOrFail($id);
        $booking->delete();

        return redirect()->route('book_ruangan.index')->with('success', 'Booking deleted successfully!');
    }
}
