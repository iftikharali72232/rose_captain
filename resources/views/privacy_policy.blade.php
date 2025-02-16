@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 p-4">
            <div class="card-body">
                <h2 class="fw-bold mb-3 text-center">Privacy Policy</h2>
                <p class="text-muted text-center">Effective Date: {{ date('F d, Y') }}</p>
                <hr>

                <h4 class="mt-4">1. Introduction</h4>
                <p>We value your privacy and are committed to protecting your personal data. This privacy policy outlines how we collect, use, and safeguard your information.</p>

                <h4 class="mt-4">2. Information We Collect</h4>
                <p>We may collect personal information such as your name, email, phone number, and any other data you provide through forms on our website.</p>

                <h4 class="mt-4">3. How We Use Your Information</h4>
                <ul>
                    <li>To provide and manage our services</li>
                    <li>To communicate with you regarding your inquiries</li>
                    <li>To improve our website and user experience</li>
                </ul>

                <h4 class="mt-4">4. Data Security</h4>
                <p>We implement appropriate security measures to protect your personal data from unauthorized access, alteration, disclosure, or destruction.</p>

                <h4 class="mt-4">5. Third-Party Sharing</h4>
                <p>We do not sell, trade, or otherwise transfer your personal information to outside parties unless required by law.</p>

                <h4 class="mt-4">6. Your Rights</h4>
                <p>You have the right to access, update, or delete your personal information. Contact us if you need any assistance regarding your data.</p>

                <h4 class="mt-4">7. Changes to This Policy</h4>
                <p>We may update this policy from time to time. Any changes will be posted on this page with the updated effective date.</p>

                <h4 class="mt-4">8. Contact Us</h4>
                <p>If you have any questions about this privacy policy, please contact us at <strong>support@yourcompany.com</strong>.</p>
            </div>
        </div>
    </div>
@endsection
