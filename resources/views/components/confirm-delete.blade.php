{{-- Confirm Delete Modal Component --}}
@props(['title' => 'Confirm Deletion', 'message' => 'Are you sure you want to delete this item?'])

<div
    x-data="{ show: false, deleteAction: null }"
    x-show="show"
    @confirm-delete.window="
        show = true;
        deleteAction = $event.detail.action;
    "
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
    @keydown.escape.window="show = false"
>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="show = false"></div>

    <!-- Modal -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6"
            @click.stop
        >
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <!-- Content -->
            <div class="text-center mb-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">
                    {{ $title }}
                </h3>
                <p class="text-sm text-slate-600">
                    {{ $message }}
                </p>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button
                    type="button"
                    @click="show = false"
                    class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-medium"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    @click="
                        if (deleteAction) {
                            if (typeof deleteAction === 'function') {
                                deleteAction();
                            } else {
                                window.location.href = deleteAction;
                            }
                        }
                        show = false;
                    "
                    class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-medium"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
