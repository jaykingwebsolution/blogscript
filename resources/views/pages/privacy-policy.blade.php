@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
                <p class="text-gray-600">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <div class="prose max-w-none text-gray-800">
                <p class="text-lg mb-6">At BlogScript, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy outlines how we collect, use, and safeguard your data when you use our website and services.</p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">1. Information We Collect</h2>
                
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Personal Information</h3>
                <p class="mb-4">When you create an account, subscribe to our newsletter, or contact us, we may collect:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>Name and email address</li>
                    <li>Profile information and preferences</li>
                    <li>Contact information for support requests</li>
                    <li>Content you submit (comments, posts, music submissions)</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-900 mb-3">Usage Information</h3>
                <p class="mb-4">We automatically collect information about how you use our website:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>IP address and browser information</li>
                    <li>Pages visited and time spent on our site</li>
                    <li>Referring websites and search terms</li>
                    <li>Device and operating system information</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">2. How We Use Your Information</h2>
                <p class="mb-4">We use the information we collect for the following purposes:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>To provide and maintain our services</li>
                    <li>To personalize your experience on our website</li>
                    <li>To communicate with you about our services</li>
                    <li>To send newsletters and promotional content (with your consent)</li>
                    <li>To improve our website and services</li>
                    <li>To detect and prevent fraud or security issues</li>
                    <li>To comply with legal obligations</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">3. Information Sharing</h2>
                <p class="mb-4">We do not sell, trade, or rent your personal information to third parties. We may share your information in the following limited circumstances:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li><strong>Service Providers:</strong> With trusted third-party services that help us operate our website</li>
                    <li><strong>Legal Requirements:</strong> When required by law or to protect our rights and safety</li>
                    <li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets</li>
                    <li><strong>Consent:</strong> When you explicitly consent to sharing your information</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">4. Cookies and Tracking</h2>
                <p class="mb-4">We use cookies and similar tracking technologies to enhance your experience:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li><strong>Essential Cookies:</strong> Required for basic website functionality</li>
                    <li><strong>Analytics Cookies:</strong> Help us understand how visitors use our site</li>
                    <li><strong>Preference Cookies:</strong> Remember your settings and preferences</li>
                    <li><strong>Marketing Cookies:</strong> Used to display relevant advertisements (with consent)</li>
                </ul>
                <p class="mb-6">You can control cookie settings through your browser preferences.</p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">5. Data Security</h2>
                <p class="mb-4">We implement appropriate security measures to protect your personal information:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>Encryption of data in transit and at rest</li>
                    <li>Regular security assessments and updates</li>
                    <li>Access controls and authentication measures</li>
                    <li>Employee training on data protection</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">6. Your Rights</h2>
                <p class="mb-4">You have the following rights regarding your personal information:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li><strong>Access:</strong> Request copies of your personal data</li>
                    <li><strong>Rectification:</strong> Request correction of inaccurate information</li>
                    <li><strong>Erasure:</strong> Request deletion of your personal data</li>
                    <li><strong>Portability:</strong> Request transfer of your data to another service</li>
                    <li><strong>Objection:</strong> Object to processing of your personal data</li>
                    <li><strong>Withdraw Consent:</strong> Withdraw consent for data processing</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">7. Children's Privacy</h2>
                <p class="mb-6">Our services are not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If we become aware that we have collected such information, we will take steps to delete it promptly.</p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">8. International Data Transfers</h2>
                <p class="mb-6">If you are accessing our services from outside Nigeria, please be aware that your information may be transferred to and processed in Nigeria. We ensure appropriate safeguards are in place for international data transfers.</p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">9. Changes to This Policy</h2>
                <p class="mb-6">We may update this Privacy Policy from time to time. We will notify you of significant changes by posting a notice on our website or sending you an email. Your continued use of our services after changes are made constitutes acceptance of the updated policy.</p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">10. Contact Us</h2>
                <p class="mb-4">If you have any questions about this Privacy Policy or our data practices, please contact us:</p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="mb-2"><strong>Email:</strong> privacy@blogscript.com</p>
                    <p class="mb-2"><strong>Address:</strong> Lagos, Nigeria</p>
                    <p><strong>Website:</strong> <a href="{{ route('contact') }}" class="text-primary hover:underline">Contact Form</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection