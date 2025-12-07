{{-- Bookings Index Component --}}
<div>
    {{-- Header --}}
    <div class="admin-card p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Bookings</h1>
                <p class="text-sm text-slate-600 mt-1">Manage consultation requests and inquiries</p>
            </div>
            <button 
                wire:click="$toggle('showFilters')" 
                class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filters
            </button>
        </div>

        {{-- Filters --}}
        @if($showFilters)
            <div 
                x-data
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mt-6 pt-6 border-t border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium uppercase tracking-wide text-slate-500 mb-1">Search</label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by name, email, company..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wide text-slate-500 mb-1">Status</label>
                        <select 
                            wire:model.live="status"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $statusOption)
                                <option value="{{ $statusOption }}">{{ ucfirst($statusOption) }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button 
                            wire:click="clearFilters"
                            class="w-full px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Bookings Table --}}
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <button wire:click="sortBy('name')" class="flex items-center gap-1 text-xs font-medium uppercase tracking-wide text-slate-700 hover:text-slate-900">
                                Name
                                @if($sortField === 'name')
                                    <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-700">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-700">Company</th>
                        <th class="px-6 py-3 text-left">
                            <button wire:click="sortBy('status')" class="flex items-center gap-1 text-xs font-medium uppercase tracking-wide text-slate-700 hover:text-slate-900">
                                Status
                                @if($sortField === 'status')
                                    <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-3 text-left">
                            <button wire:click="sortBy('created_at')" class="flex items-center gap-1 text-xs font-medium uppercase tracking-wide text-slate-700 hover:text-slate-900">
                                Date
                                @if($sortField === 'created_at')
                                    <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wide text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($bookings as $booking)
                        <tr wire:key="booking-{{ $booking->id }}" class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $booking->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600">{{ $booking->email }}</div>
                                <div class="text-sm text-slate-500">{{ $booking->phone }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $booking->company ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <select 
                                    wire:change="updateStatus({{ $booking->id }}, $event.target.value)"
                                    class="text-sm px-3 py-1 border-0 rounded-full font-medium bg-{{ $this->getStatusColor($booking->status) }}-100 text-{{ $this->getStatusColor($booking->status) }}-800 focus:ring-2 focus:ring-{{ $this->getStatusColor($booking->status) }}-500">
                                    @foreach($statuses as $statusOption)
                                        <option value="{{ $statusOption }}" {{ $booking->status === $statusOption ? 'selected' : '' }}>
                                            {{ ucfirst($statusOption) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $booking->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        wire:click="view({{ $booking->id }})"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button 
                                        wire:click="delete({{ $booking->id }})"
                                        wire:confirm="Are you sure you want to delete this booking?"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-lg font-semibold text-slate-900 mb-1">No bookings found</p>
                                <p class="text-sm text-slate-500">
                                    @if($search || $status)
                                        Try adjusting your filters
                                    @else
                                        Bookings will appear here when clients submit consultation requests
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $bookings->links() }}
    </div>

    {{-- Booking Detail Modal --}}
    @if($showModal && $selectedBooking)
        <div 
            x-data
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeModal"></div>
            
            <div class="flex items-center justify-center min-h-screen p-4">
                <div 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6"
                    @click.stop>
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Booking Details</h2>
                            <p class="text-sm text-slate-500 mt-1">Reference: #{{ $selectedBooking->id }}</p>
                        </div>
                        <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Name</label>
                                <p class="text-slate-900 font-medium">{{ $selectedBooking->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                                <span class="inline-flex px-3 py-1 text-sm rounded-full font-medium bg-{{ $this->getStatusColor($selectedBooking->status) }}-100 text-{{ $this->getStatusColor($selectedBooking->status) }}-800">
                                    {{ ucfirst($selectedBooking->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Email</label>
                                <a href="mailto:{{ $selectedBooking->email }}" class="text-blue-600 hover:text-blue-700">{{ $selectedBooking->email }}</a>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Phone</label>
                                <a href="tel:{{ $selectedBooking->phone }}" class="text-blue-600 hover:text-blue-700">{{ $selectedBooking->phone }}</a>
                            </div>
                        </div>
                        
                        @if($selectedBooking->company)
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Company</label>
                                <p class="text-slate-900">{{ $selectedBooking->company }}</p>
                            </div>
                        @endif
                        
                        @if($selectedBooking->service_interest)
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Service Interest</label>
                                <p class="text-slate-900">{{ $selectedBooking->service_interest }}</p>
                            </div>
                        @endif
                        
                        @if($selectedBooking->message)
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Message</label>
                                <p class="text-slate-900 bg-slate-50 p-4 rounded-xl">{{ $selectedBooking->message }}</p>
                            </div>
                        @endif
                        
                        <div class="pt-4 border-t border-slate-200">
                            <label class="block text-xs font-medium text-slate-500 mb-1">Submitted</label>
                            <p class="text-slate-900">{{ $selectedBooking->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
