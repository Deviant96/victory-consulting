<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use LogsAdminActivity;

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

        $booking->update($validated);

        $this->logAdminActivity('updated booking', $booking, "Updated booking #{$booking->id} status to {$booking->status}");

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $this->logAdminActivity('deleted booking', $booking, "Deleted booking #{$booking->id} ({$booking->name})");
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted.');
    }
}
