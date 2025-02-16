@extends('layouts.app')

@section('content')
    <head>
        <style>
            body {
                direction: ltr !important;
                text-align: left !important;
            }
        </style>
    </head>
    @php
        Session::put('lang_local','en');


    @endphp
    @if(Session::get('lang_local')=='en')
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

    @else

            <div class="container mt-4">
                <div class="card shadow-sm border-0 p-4">
                    <div class="card-body">
                        <h2 class="fw-bold mb-3 text-center">سياسة الخصوصية</h2>
                        <p class="text-muted text-center">تاريخ السريان: {{ date('F d, Y') }}</p>
                        <hr>

                        <h4 class="mt-4">1. المقدمة</h4>
                        <p>نحن نقدر خصوصيتك ونلتزم بحماية بياناتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع معلوماتك واستخدامها وحمايتها.</p>

                        <h4 class="mt-4">2. المعلومات التي نجمعها</h4>
                        <p>قد نقوم بجمع معلومات شخصية مثل اسمك، بريدك الإلكتروني، رقم هاتفك، وأي بيانات أخرى تقدمها من خلال النماذج على موقعنا.</p>

                        <h4 class="mt-4">3. كيفية استخدام معلوماتك</h4>
                        <ul>
                            <li>لتقديم خدماتنا وإدارتها</li>
                            <li>للتواصل معك بشأن استفساراتك</li>
                            <li>لتحسين موقعنا وتجربة المستخدم</li>
                        </ul>

                        <h4 class="mt-4">4. أمان البيانات</h4>
                        <p>نحن نطبق تدابير أمان مناسبة لحماية بياناتك الشخصية من الوصول غير المصرح به أو التعديل أو الكشف أو التدمير.</p>

                        <h4 class="mt-4">5. مشاركة البيانات مع أطراف ثالثة</h4>
                        <p>نحن لا نبيع أو نتاجر أو ننقل معلوماتك الشخصية إلى أطراف خارجية إلا إذا كان ذلك مطلوبًا بموجب القانون.</p>

                        <h4 class="mt-4">6. حقوقك</h4>
                        <p>لديك الحق في الوصول إلى معلوماتك الشخصية أو تحديثها أو حذفها. يرجى التواصل معنا إذا كنت بحاجة إلى أي مساعدة بخصوص بياناتك.</p>

                        <h4 class="mt-4">7. تغييرات على هذه السياسة</h4>
                        <p>قد نقوم بتحديث هذه السياسة من وقت لآخر. سيتم نشر أي تغييرات على هذه الصفحة مع تاريخ السريان المحدّث.</p>

                        <h4 class="mt-4">8. اتصل بنا</h4>
                        <p>إذا كانت لديك أي أسئلة حول سياسة الخصوصية هذه، يرجى الاتصال بنا على <strong>support@yourcompany.com</strong>.</p>
                    </div>
                </div>
            </div>


    @endif
@endsection
