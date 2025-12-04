<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::latest()->paginate(10);

        $stats = [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', Booking::STATUSES),
            'admin_notes' => 'nullable|string',
        ]);

        $original = $booking->getOriginal();
        $booking->update($validated);

        $changes = AdminActivity::diffFor($booking, $original);

        AdminActivity::record(
            'Updated booking',
            $booking,
            sprintf('Updated booking for %s', $booking->name),
            $changes
        );

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $name = $booking->name;
        $booking->delete();

        AdminActivity::record(
            'Deleted booking',
            $booking,
            sprintf('Deleted booking for %s', $name)
        );

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted.');
    }
}
