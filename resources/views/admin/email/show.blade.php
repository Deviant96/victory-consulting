@extends('admin.layouts.app')

@section('title', 'View Message')
@section('page-title', 'Email — Message')

@section('content')
<div class="space-y-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.email.' . $folder) }}"
           class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to {{ ucfirst($folder) }}
        </a>
    </div>

    @if($error || !$message)
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
            <svg class="w-10 h-10 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm font-semibold text-red-700 mb-1">Message Unavailable</p>
            <p class="text-sm text-red-600">{{ $error ?? 'The requested message could not be found.' }}</p>
            <a href="{{ $titanUrl }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-1 mt-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 transition">
                Open Titan Email ↗
            </a>
        </div>
    @else
        @php
            $from     = $message->getFrom()->first();
            $to       = $message->getTo()->first();
            $subject  = $message->getSubject()->first() ?? '(no subject)';
            $date     = $message->getDate()->first();
            $body     = $message->getHTMLBody() ?: nl2br(e($message->getTextBody()));
        @endphp
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <!-- Message Header -->
            <div class="px-6 py-5 border-b border-gray-100 space-y-3">
                <div class="flex items-start justify-between gap-4">
                    <h2 class="text-xl font-semibold text-gray-900 leading-tight">{{ $subject }}</h2>
                    <a href="{{ $titanUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1 flex-shrink-0 text-xs px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Open in Titan
                    </a>
                </div>
                <dl class="space-y-1 text-sm">
                    @if($from)
                        <div class="flex items-start gap-2">
                            <dt class="text-gray-500 w-14 flex-shrink-0 pt-0.5">From</dt>
                            <dd class="text-gray-900 font-medium">
                                {{ $from->personal ? $from->personal . ' <' . $from->mail . '>' : $from->mail }}
                            </dd>
                        </div>
                    @endif
                    @if($to)
                        <div class="flex items-start gap-2">
                            <dt class="text-gray-500 w-14 flex-shrink-0 pt-0.5">To</dt>
                            <dd class="text-gray-700">
                                {{ $to->personal ? $to->personal . ' <' . $to->mail . '>' : $to->mail }}
                            </dd>
                        </div>
                    @endif
                    @if($date)
                        <div class="flex items-start gap-2">
                            <dt class="text-gray-500 w-14 flex-shrink-0 pt-0.5">Date</dt>
                            <dd class="text-gray-700">{{ \Carbon\Carbon::parse($date)->format('D, M j, Y \a\t g:i A') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Message Body -->
            <div class="px-6 py-6">
                @if($body)
                    <div class="prose prose-sm max-w-none text-gray-800 leading-relaxed email-body">
                        {echo "DRAFTS_CREATED" $body !!}
                    </div>
                @else
                    <p class="text-gray-400 text-sm italic">This message has no body content.</p>
                @endif
            </div>

            <!-- Attachments -->
            @if($message->getAttachments()->count())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                        Attachments ({{ $message->getAttachments()->count() }})
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($message->getAttachments() as $attachment)
                            <div class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                {{ $attachment->getName() }}
                                <span class="text-xs text-gray-400">
                                    ({{ round($attachment->getSize() / 1024, 1) }} KB)
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-3 text-xs text-gray-400">To download attachments, open this email in Titan Email.</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .email-body img { max-width: 100%; height: auto; }
    .email-body a { color: #2563eb; text-decoration: underline; }
    .email-body table { border-collapse: collapse; width: 100%; }
    .email-body td, .email-body th { padding: 4px 8px; }
</style>
@endpush
