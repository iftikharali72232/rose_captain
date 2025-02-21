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
                'data_collection' => "We only collect necessary information to provide and improve our services, such as your name, email when you register, phone number for account verification, and location data (only if GPS tracking is enabled).",
                'data_usage' => "Your information is used to provide and improve services, ensure security and fraud prevention, and comply with legal obligations.",
                'data_sharing' => "We do not share your personal data with third parties except when required by law, with your explicit consent, or with trusted service providers to enhance our services.",
                'security' => "We implement strict security measures to protect your data from unauthorized access.",
                'user_rights' => "You have the right to access, update, or delete your personal data. If you have concerns, you may contact us.",
                'contact' => "For any privacy-related inquiries, contact us at: support@example.com"
            ]
        ], 200);

    }
}
