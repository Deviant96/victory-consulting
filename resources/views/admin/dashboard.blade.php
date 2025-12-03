@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Services Card -->
        <div x-data="collapsibleCard('stats-services')" class="admin-card p-5">
            <div class="admin-card-header items-center pb-3">
                <div>
                    <p class="text-sm font-medium text-slate-500">Services</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">0</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="p-3 bg-blue-100 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle services card">
                        <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="admin-card-body" x-show="!collapsed" x-transition>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                    Manage Services
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>

        <!-- Team Members Card -->
        <div x-data="collapsibleCard('stats-team')" class="admin-card p-5">
            <div class="admin-card-header items-center pb-3">
                <div>
                    <p class="text-sm font-medium text-slate-500">Team Members</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">0</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="p-3 bg-green-100 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle team card">
                        <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="admin-card-body" x-show="!collapsed" x-transition>
                <a href="#" class="text-sm text-green-600 hover:text-green-700 inline-flex items-center gap-1">
                    Manage Team
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>

        <!-- FAQs Card -->
        <div x-data="collapsibleCard('stats-faqs')" class="admin-card p-5">
            <div class="admin-card-header items-center pb-3">
                <div>
                    <p class="text-sm font-medium text-slate-500">FAQs</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">0</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="p-3 bg-amber-100 rounded-xl text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle FAQs card">
                        <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="admin-card-body" x-show="!collapsed" x-transition>
                <a href="#" class="text-sm text-amber-600 hover:text-amber-700 inline-flex items-center gap-1">
                    Manage FAQs
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>

        <!-- Articles Card -->
        <div x-data="collapsibleCard('stats-articles')" class="admin-card p-5">
            <div class="admin-card-header items-center pb-3">
                <div>
                    <p class="text-sm font-medium text-slate-500">Articles</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">0</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="p-3 bg-purple-100 rounded-xl text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle articles card">
                        <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="admin-card-body" x-show="!collapsed" x-transition>
                <a href="#" class="text-sm text-purple-600 hover:text-purple-700 inline-flex items-center gap-1">
                    Manage Articles
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div x-data="collapsibleCard('recent-activity')" class="admin-card p-6">
            <div class="admin-card-header pb-5">
                <div>
                    <h3 class="admin-card-title">Recent Activity</h3>
                    <p class="admin-card-subtitle">Latest updates from across the dashboard</p>
                </div>
                <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle recent activity">
                    <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
            </div>
            <div class="admin-card-body" x-show="!collapsed" x-transition>
                <div class="space-y-4">
                    <p class="text-sm text-slate-500">No recent activity</p>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div x-data="collapsibleCard('quick-actions')" class="admin-card p-6">
            <div class="admin-card-header pb-5">
                <div>
                    <h3 class="admin-card-title">Quick Actions</h3>
                    <p class="admin-card-subtitle">Jump into the most common tasks</p>
                </div>
                <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle quick actions">
                    <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
            </div>
            <div class="admin-card-body" x-show="!collapsed" x-transition>
                <div class="space-y-2">
                    <a href="#" class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/60 transition">
                        <span class="text-sm text-slate-800">Add New Service</span>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </a>
                    <a href="#" class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/60 transition">
                        <span class="text-sm text-slate-800">Add Team Member</span>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </a>
                    <a href="#" class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/60 transition">
                        <span class="text-sm text-slate-800">Create Article</span>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </a>
                    <a href="#" class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/60 transition">
                        <span class="text-sm text-slate-800">Update Settings</span>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
