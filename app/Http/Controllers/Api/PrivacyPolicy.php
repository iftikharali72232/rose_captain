<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyPolicy extends Controller
{
    public function show()
    {
        return response()->json([
            'status' => 'success',
            'privacy_policy' => [
                'title' => 'Privacy Policy',
                'effective_date' => '2025-02-15',
                'introduction' => "We value your privacy. This policy explains how we collect, use, and protect your personal information.",
                'data_collection' => [
                    'info' => "We only collect necessary information to provide and improve our services.",
                    'examples' => [
                        'Your name and email when you register.',
                        'Your phone number for account verification.',
                        'Your location data (only if GPS tracking is enabled).'
                    ]
                ],
                'data_usage' => [
                    'info' => "We use your information for the following purposes:",
                    'purposes' => [
                        'To provide and improve our services.',
                        'To ensure security and fraud prevention.',
                        'To comply with legal obligations.'
                    ]
                ],
                'data_sharing' => [
                    'info' => "We do not share your personal data with third parties, except in the following cases:",
                    'cases' => [
                        'When required by law.',
                        'With your explicit consent.',
                        'With trusted service providers to improve our services.'
                    ]
                ],
                'security' => "We implement strict security measures to protect your data from unauthorized access.",
                'user_rights' => [
                    'You can access, update, or delete your personal data.',
                    'If you have any concerns, you may contact us.'
                ],
                'contact' => "For any privacy-related inquiries, contact us at: support@example.com"
            ]
        ], 200);
    }
}
