@extends('layouts.app')

@section('title', 'DMCA Policy')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">DMCA Policy</h1>
                <p class="text-gray-600 dark:text-gray-400">Our copyright protection and takedown procedure</p>
            </div>

            <div class="prose prose-lg dark:prose-invert max-w-none">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>
@endsection
                        <li>A statement that you have a good faith belief that use of the material is not authorized</li>
                        <li>A statement that the information in the notification is accurate</li>
                        <li>A statement, under penalty of perjury, that you are authorized to act on behalf of the copyright owner</li>
                    </ul>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-3">How to Submit Your Notice</h3>
                <p class="mb-4">Send your complete DMCA takedown notice to:</p>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="mb-2"><strong>Email:</strong> dmca@blogscript.com</p>
                    <p class="mb-2"><strong>Subject Line:</strong> DMCA Takedown Notice</p>
                    <p><strong>Mailing Address:</strong><br>
                    BlogScript DMCA Agent<br>
                    Lagos, Nigeria</p>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">3. Our Response Process</h2>
                <p class="mb-4">Upon receiving a valid DMCA takedown notice, we will:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>Remove or disable access to the allegedly infringing material</li>
                    <li>Notify the user who posted the material about the removal</li>
                    <li>Provide the user with a copy of the takedown notice</li>
                    <li>Inform the user of their right to file a counter-notification</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">4. Filing a Counter-Notification</h2>
                <p class="mb-4">If you believe your content was wrongly removed due to a DMCA takedown notice, you may file a counter-notification. Your counter-notification must include:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>Your physical or electronic signature</li>
                    <li>Identification of the material that was removed and where it appeared</li>
                    <li>A statement under penalty of perjury that you have a good faith belief the material was removed by mistake or misidentification</li>
                    <li>Your contact information</li>
                    <li>A statement that you consent to jurisdiction in the federal district court</li>
                    <li>A statement that you will accept service of process from the original complainant</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">5. Counter-Notification Process</h2>
                <p class="mb-4">After receiving a valid counter-notification:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>We will forward the counter-notification to the original complainant</li>
                    <li>We will restore the content within 10-14 business days unless the original complainant files a court action</li>
                    <li>The original complainant has 10 business days to file a court action to keep the content removed</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">6. Repeat Infringer Policy</h2>
                <p class="mb-6">We maintain a policy of terminating user accounts that are repeat infringers. Users who repeatedly post copyrighted material without authorization may have their accounts suspended or permanently banned from our platform.</p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">7. Safe Harbor Provisions</h2>
                <p class="mb-6">BlogScript operates under the safe harbor provisions of the DMCA. We are a service provider that hosts user-generated content and respond promptly to valid takedown notices. We do not actively monitor content for copyright infringement.</p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">8. False Claims Warning</h2>
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                    <p class="text-red-800"><strong>Important:</strong> Making false claims in a DMCA takedown notice or counter-notification may result in legal liability for damages, including costs and attorney fees. Only submit a notice if you have a good faith belief that the content infringes copyright or was wrongly removed.</p>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">9. Alternative Dispute Resolution</h2>
                <p class="mb-6">Before filing formal legal action, we encourage parties to attempt to resolve copyright disputes through direct communication. Many issues can be resolved quickly and amicably without formal DMCA procedures.</p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">10. Content Guidelines</h2>
                <p class="mb-4">To help prevent copyright infringement:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>Only upload content you own or have permission to use</li>
                    <li>Respect the intellectual property rights of artists and content creators</li>
                    <li>When in doubt about copyright status, don't upload the content</li>
                    <li>Use royalty-free or Creative Commons licensed content when possible</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">11. Contact Information</h2>
                <p class="mb-4">For all copyright-related matters, including DMCA notices and general inquiries:</p>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="mb-2"><strong>DMCA Agent:</strong> BlogScript Legal Team</p>
                    <p class="mb-2"><strong>Email:</strong> dmca@blogscript.com</p>
                    <p class="mb-2"><strong>General Contact:</strong> <a href="{{ route('contact') }}" class="text-primary hover:underline">Contact Form</a></p>
                    <p><strong>Mailing Address:</strong><br>
                    BlogScript Copyright Agent<br>
                    Lagos, Nigeria</p>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 mt-8">12. Changes to This Policy</h2>
                <p class="mb-6">We may update this DMCA policy from time to time to reflect changes in law or our procedures. We will post any significant changes on this page and update the "Last updated" date at the top of this policy.</p>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
                    <p class="text-blue-800"><strong>Note:</strong> This policy is designed to comply with the DMCA and related copyright laws. For specific legal advice regarding copyright matters, please consult with a qualified attorney.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection