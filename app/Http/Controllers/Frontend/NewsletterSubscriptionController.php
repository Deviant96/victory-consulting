<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => t('frontend.blog.newsletter_error_required', 'Please enter your email address.'),
            'email.email' => t('frontend.blog.newsletter_error_invalid', 'Please enter a valid email address.'),
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $validator->errors()->first('email'),
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()
                ->to($this->newsletterRedirectUrl($request))
                ->withErrors($validator, 'newsletter')
                ->withInput();
        }

        $validated = $validator->validated();

        $email = strtolower(trim($validated['email']));

        $subscription = NewsletterSubscription::firstOrCreate(
            ['email' => $email],
            ['source' => 'blog']
        );

        $message = $subscription->wasRecentlyCreated
            ? t('frontend.blog.newsletter_success', 'Thanks for subscribing. Please check your inbox for updates.')
            : t('frontend.blog.newsletter_exists', 'You are already subscribed with this email.');

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->to($this->newsletterRedirectUrl($request))
            ->with('newsletter_success', $message);
    }

    private function newsletterRedirectUrl(Request $request): string
    {
        // Keep non-JS fallback usable by scrolling directly to the CTA section.
        $previous = explode('#', url()->previous())[0];

        return $previous . '#newsletter-signup';
    }
}
