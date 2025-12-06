<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppAgent;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class WhatsAppAgentController extends Controller
{
    use LogsAdminActivity;

    public function index()
    {
        $agents = WhatsAppAgent::orderBy('order')->orderBy('name')->paginate(15);
        return view('admin.whatsapp-agents.index', compact('agents'));
    }

    public function create()
    {
        return view('admin.whatsapp-agents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $agent = WhatsAppAgent::create($validated);

        $this->logAdminActivity('created whatsapp agent', $agent->id, "Created WhatsApp agent: {$agent->name}");

        return redirect()->route('admin.whatsapp-agents.index')
            ->with('success', 'WhatsApp agent created successfully.');
    }

    public function edit(WhatsAppAgent $whatsappAgent)
    {
        return view('admin.whatsapp-agents.edit', compact('whatsappAgent'));
    }

    public function update(Request $request, WhatsAppAgent $whatsappAgent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $whatsappAgent->update($validated);

        $this->logAdminActivity('updated whatsapp agent', $whatsappAgent->id, "Updated WhatsApp agent: {$whatsappAgent->name}");

        return redirect()->route('admin.whatsapp-agents.index')
            ->with('success', 'WhatsApp agent updated successfully.');
    }

    public function destroy(WhatsAppAgent $whatsappAgent)
    {
        $name = $whatsappAgent->name;
        $whatsappAgent->delete();

        $this->logAdminActivity('deleted whatsapp agent', $whatsappAgent->id, "Deleted WhatsApp agent: {$name}");

        return redirect()->route('admin.whatsapp-agents.index')
            ->with('success', 'WhatsApp agent deleted successfully.');
    }
}
