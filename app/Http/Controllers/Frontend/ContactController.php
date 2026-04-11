<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $services = Service::published()->orderBy('title')->get();

        return view('frontend.contact', compact('services'));
    }

    public function store(Request $request)
    {
        // Anti-spam: reject honeypot-filled submissions silently
        if ($request->filled('website')) {
            return redirect()->route('contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
        }

        // Anti-spam: reject submissions faster than 3 seconds (bot behaviour)
        $loadedAt = (int) $request->input('_form_loaded_at', 0);
        if ($loadedAt > 0 && now()->timestamp - $loadedAt < 3) {
            return redirect()->route('contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'message' => 'required|string',
        ]);

        // TODO: Send email or store in database
        // For now, just redirect with success message
        
        return redirect()->route('contact')
            ->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
