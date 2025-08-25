<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            'site_title' => 'MusicStream - Your Ultimate Music Platform',
            'site_logo' => null,
            'site_meta_description' => 'Discover, stream, and share music from talented artists worldwide. Join MusicStream for the ultimate music experience.',
            'site_keywords' => 'music, streaming, artists, songs, playlists, audio',
            'contact_content' => '<h2>Get in Touch</h2><p>We\'d love to hear from you! Reach out to us for any questions, suggestions, or feedback.</p><p><strong>Email:</strong> info@musicstream.com</p><p><strong>Phone:</strong> +1 (555) 123-4567</p><p><strong>Address:</strong> 123 Music Street, Sound City, SC 12345</p>',
            'about_content' => '<h2>About MusicStream</h2><p>MusicStream is your ultimate destination for discovering and enjoying music from talented artists around the world. Our platform connects music lovers with incredible content, featuring everything from emerging artists to established performers.</p><h3>Our Mission</h3><p>To democratize music discovery and provide a platform where artists can share their passion with the world while listeners can explore new sounds and genres.</p><h3>What We Offer</h3><ul><li>High-quality music streaming</li><li>Artist discovery and promotion</li><li>Personalized playlists</li><li>Social music sharing</li><li>Artist verification and support</li></ul>',
            'privacy_policy_content' => '<h2>Privacy Policy</h2><p>Last updated: ' . date('F j, Y') . '</p><h3>Information We Collect</h3><p>We collect information you provide directly to us, such as when you create an account, upload content, or contact us for support.</p><h3>How We Use Your Information</h3><p>We use the information we collect to provide, maintain, and improve our services, process transactions, and communicate with you.</p><h3>Information Sharing</h3><p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this privacy policy.</p><h3>Data Security</h3><p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>',
            'dmca_policy_content' => '<h2>DMCA Policy</h2><p>MusicStream respects the intellectual property rights of others and expects our users to do the same.</p><h3>Notification of Copyright Infringement</h3><p>If you believe that material on our platform infringes your copyright, please send a notice to our designated agent with the following information:</p><ul><li>Your contact information</li><li>Identification of the copyrighted work claimed to have been infringed</li><li>Identification of the material that is claimed to be infringing</li><li>A statement of good faith belief that use of the material is not authorized</li><li>A statement that the information in the notification is accurate</li><li>Your physical or electronic signature</li></ul><p><strong>DMCA Agent:</strong> dmca@musicstream.com</p>',
            'footer_copyright' => '© 2024 MusicStream. All rights reserved.',
            'social_facebook' => '',
            'social_twitter' => '',
            'social_instagram' => '',
            'social_youtube' => '',
            'seo_enabled' => true,
            'site_favicon' => null,
        ];

        foreach ($defaultSettings as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}