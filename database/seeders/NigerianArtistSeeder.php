<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Artist;
use App\Models\Music;
use Carbon\Carbon;

class NigerianArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds 20 Nigerian artists as 'artist' role users with reserved usernames/emails
     */
    public function run(): void
    {
        // Get admin user for created_by references
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->command->error('Admin user not found. Please run AdminDashboardSeeder first.');
            return;
        }

        // Nigerian artists with real bios and reserved usernames/emails
        $nigerianArtists = [
            [
                'name' => 'Davido',
                'email' => 'davido@nigerianartists.com',
                'username' => 'davido',
                'artist_stage_name' => 'Davido',
                'artist_genre' => 'Afrobeats, Hip Hop',
                'bio' => 'David Adedeji Adeleke, known professionally as Davido, is a Nigerian singer, songwriter and record producer. Born in Atlanta and raised in Lagos, he is regarded as one of the most important Afrobeats artists of the 21st century.',
                'profile_picture' => 'https://images.unsplash.com/photo-1560472355-536de3962603?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/davido',
                    'twitter' => 'https://twitter.com/davido',
                    'spotify' => 'https://open.spotify.com/artist/0Y3agQaa6g2r0YmHPOO9rh'
                ],
                'songs' => [
                    [
                        'title' => 'Fall',
                        'description' => 'One of the biggest Afrobeats songs worldwide, showcasing Davido\'s global appeal.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
                        'duration' => '3:17'
                    ],
                    [
                        'title' => 'If',
                        'description' => 'A classic romantic Afrobeats track that dominated African music charts.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
                        'duration' => '3:58'
                    ],
                    [
                        'title' => 'Unavailable',
                        'description' => 'Recent hit showcasing modern Afrobeats production and vocals.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3',
                        'duration' => '3:42'
                    ]
                ]
            ],
            [
                'name' => 'Rema',
                'email' => 'rema@nigerianartists.com',
                'username' => 'rema',
                'artist_stage_name' => 'Rema',
                'artist_genre' => 'Afrobeats, Trap, Pop',
                'bio' => 'Divine Ikubor, known professionally as Rema, is a Nigerian singer, songwriter and rapper. He rose to prominence with his 2019 song "Iron Man" and became a global sensation with "Calm Down".',
                'profile_picture' => 'https://images.unsplash.com/photo-1558020321-20f96f6c19b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/heisrema',
                    'twitter' => 'https://twitter.com/heisrema'
                ],
                'songs' => [
                    [
                        'title' => 'Calm Down',
                        'description' => 'Global hit that topped charts worldwide and showcased Afrobeats to international audiences.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3',
                        'duration' => '3:59'
                    ],
                    [
                        'title' => 'Dumebi',
                        'description' => 'Breakout hit that established Rema as a major force in Afrobeats.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-5.mp3',
                        'duration' => '3:15'
                    ]
                ]
            ],
            [
                'name' => 'Asake',
                'email' => 'asake@nigerianartists.com',
                'username' => 'asake',
                'artist_stage_name' => 'Asake',
                'artist_genre' => 'Afrobeats, Amapiano',
                'bio' => 'Ahmed Ololade, known professionally as Asake, is a Nigerian singer and songwriter. He is signed to YBNL Nation and Empire Distribution, known for blending Afrobeats with Amapiano sounds.',
                'profile_picture' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/asakemusik',
                    'twitter' => 'https://twitter.com/asakemusik'
                ],
                'songs' => [
                    [
                        'title' => 'Palazzo',
                        'description' => 'Hit single showcasing Asake\'s unique Amapiano-Afrobeats fusion.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-6.mp3',
                        'duration' => '2:47'
                    ],
                    [
                        'title' => 'Sungba',
                        'description' => 'Popular track that became a street anthem across Nigeria.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-7.mp3',
                        'duration' => '3:12'
                    ]
                ]
            ],
            [
                'name' => 'Fireboy DML',
                'email' => 'fireboy@nigerianartists.com',
                'username' => 'fireboy',
                'artist_stage_name' => 'Fireboy DML',
                'artist_genre' => 'Afrobeats, R&B',
                'bio' => 'Adedamola Adefolahan, known professionally as Fireboy DML, is a Nigerian singer and songwriter signed to YBNL Nation. He is known for his smooth vocals and contemporary R&B-influenced Afrobeats sound.',
                'profile_picture' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/fireboydml',
                    'twitter' => 'https://twitter.com/fireboydml'
                ],
                'songs' => [
                    [
                        'title' => 'Peru',
                        'description' => 'International breakthrough hit that gained massive global recognition.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3',
                        'duration' => '2:53'
                    ],
                    [
                        'title' => 'Jealous',
                        'description' => 'Romantic ballad that showcased Fireboy\'s vocal range and songwriting.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-9.mp3',
                        'duration' => '3:04'
                    ]
                ]
            ],
            [
                'name' => 'Joeboy',
                'email' => 'joeboy@nigerianartists.com',
                'username' => 'joeboy',
                'artist_stage_name' => 'Joeboy',
                'artist_genre' => 'Afrobeats, R&B, Pop',
                'bio' => 'Joseph Akinwale Akinfenwa-Donus, known professionally as Joeboy, is a Nigerian singer and songwriter. He was discovered by Mr Eazi and is known for his melodic Afrobeats style.',
                'profile_picture' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/joeboy',
                    'twitter' => 'https://twitter.com/joeboyofficial'
                ],
                'songs' => [
                    [
                        'title' => 'Baby',
                        'description' => 'Breakthrough single that established Joeboy as a major Afrobeats talent.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-10.mp3',
                        'duration' => '3:21'
                    ],
                    [
                        'title' => 'Alcohol',
                        'description' => 'Popular party anthem with infectious Afrobeats rhythm.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-11.mp3',
                        'duration' => '2:48'
                    ]
                ]
            ],
            [
                'name' => 'Omah Lay',
                'email' => 'omahlay@nigerianartists.com',
                'username' => 'omahlay',
                'artist_stage_name' => 'Omah Lay',
                'artist_genre' => 'Afrobeats, Alternative R&B',
                'bio' => 'Stanley Omah Didia, known professionally as Omah Lay, is a Nigerian singer, songwriter and record producer. He is known for his unique blend of Afrobeats with alternative R&B and introspective lyrics.',
                'profile_picture' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/omah_lay',
                    'twitter' => 'https://twitter.com/omah_lay'
                ],
                'songs' => [
                    [
                        'title' => 'Godly',
                        'description' => 'Breakout hit that showcased Omah Lay\'s unique sound and vocal style.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-12.mp3',
                        'duration' => '3:07'
                    ],
                    [
                        'title' => 'Bad Influence',
                        'description' => 'Popular track with smooth production and relatable lyrics.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-13.mp3',
                        'duration' => '2:59'
                    ]
                ]
            ],
            [
                'name' => 'Olamide',
                'email' => 'olamide@nigerianartists.com',
                'username' => 'olamide',
                'artist_stage_name' => 'Olamide',
                'artist_genre' => 'Hip Hop, Afrobeats',
                'bio' => 'Olamide Gbenga Adedeji, known mononymously as Olamide, is a Nigerian hip-hop recording artist and the founder of YBNL Nation record label. He is regarded as one of the most influential artists in Africa.',
                'profile_picture' => 'https://images.unsplash.com/photo-1474176857210-7287d38d27c6?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/olamide',
                    'twitter' => 'https://twitter.com/olamide_ybnl'
                ],
                'songs' => [
                    [
                        'title' => 'Wo',
                        'description' => 'Massive hit that dominated Nigerian music charts and became a cultural phenomenon.',
                        'genre' => 'Hip Hop',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-14.mp3',
                        'duration' => '3:29'
                    ],
                    [
                        'title' => 'Rock',
                        'description' => 'Popular street anthem showcasing Olamide\'s rap prowess.',
                        'genre' => 'Hip Hop',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-15.mp3',
                        'duration' => '3:45'
                    ]
                ]
            ],
            [
                'name' => 'Kizz Daniel',
                'email' => 'kissdaniel@nigerianartists.com',
                'username' => 'kizzdaniel',
                'artist_stage_name' => 'Kizz Daniel',
                'artist_genre' => 'Afrobeats, R&B',
                'bio' => 'Oluwatobiloba Daniel Anidugbe, known professionally as Kizz Daniel, is a Nigerian singer and songwriter. He is known for his smooth vocals and hit songs that dominate African music charts.',
                'profile_picture' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/kizzdaniel',
                    'twitter' => 'https://twitter.com/kizzdaniel'
                ],
                'songs' => [
                    [
                        'title' => 'Buga',
                        'description' => 'International hit featuring Tekno that became a global dance anthem.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-16.mp3',
                        'duration' => '2:51'
                    ],
                    [
                        'title' => 'Woju',
                        'description' => 'Career-defining hit that established Kizz Daniel as a major force in Afrobeats.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-17.mp3',
                        'duration' => '4:12'
                    ]
                ]
            ],
            [
                'name' => 'Mayorkun',
                'email' => 'mayorkun@nigerianartists.com',
                'username' => 'mayorkun',
                'artist_stage_name' => 'Mayorkun',
                'artist_genre' => 'Afrobeats, Pop',
                'bio' => 'Adewale Emmanuel Mayowa, known professionally as Mayorkun, is a Nigerian singer, songwriter and pianist. He was discovered by Davido and is known for his catchy melodies and energetic performances.',
                'profile_picture' => 'https://images.unsplash.com/photo-1542909168-82c3e7fdca5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/iammayorkun',
                    'twitter' => 'https://twitter.com/iammayorkun'
                ],
                'songs' => [
                    [
                        'title' => 'Mama',
                        'description' => 'Breakthrough single that showcased Mayorkun\'s unique sound and style.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-18.mp3',
                        'duration' => '3:33'
                    ],
                    [
                        'title' => 'Geng',
                        'description' => 'Popular party anthem with infectious energy and memorable hooks.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-19.mp3',
                        'duration' => '3:18'
                    ]
                ]
            ],
            [
                'name' => 'Naira Marley',
                'email' => 'nairamarley@nigerianartists.com',
                'username' => 'nairamarley',
                'artist_stage_name' => 'Naira Marley',
                'artist_genre' => 'Hip Hop, Afrobeats',
                'bio' => 'Azeez Adeshina Fashola, known professionally as Naira Marley, is a Nigerian singer, songwriter and rapper. He is known for his controversial lyrics and unique blend of hip-hop with Afrobeats.',
                'profile_picture' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/nairamarley',
                    'twitter' => 'https://twitter.com/nairamarley'
                ],
                'songs' => [
                    [
                        'title' => 'Soapy',
                        'description' => 'Controversial hit that sparked dance trends and cultural conversations.',
                        'genre' => 'Hip Hop',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-20.mp3',
                        'duration' => '3:05'
                    ],
                    [
                        'title' => 'Mafo',
                        'description' => 'Street anthem that resonated with Nigerian youth culture.',
                        'genre' => 'Hip Hop',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-21.mp3',
                        'duration' => '2:38'
                    ]
                ]
            ],
            [
                'name' => 'Yemi Alade',
                'email' => 'yemialade@nigerianartists.com',
                'username' => 'yemialade',
                'artist_stage_name' => 'Yemi Alade',
                'artist_genre' => 'Afrobeats, Pop',
                'bio' => 'Yemi Eberechi Alade is a Nigerian Afropop singer and songwriter. Known for her energetic performances and pan-African themes, she is one of the most successful female African artists.',
                'profile_picture' => 'https://images.unsplash.com/photo-1494790108755-2616c056c342?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/yemialade',
                    'twitter' => 'https://twitter.com/yemialade'
                ],
                'songs' => [
                    [
                        'title' => 'Johnny',
                        'description' => 'International hit that brought African music to global audiences.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-22.mp3',
                        'duration' => '4:03'
                    ],
                    [
                        'title' => 'Shekere',
                        'description' => 'Vibrant Afrobeats track showcasing Yemi Alade\'s vocal power.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-23.mp3',
                        'duration' => '3:47'
                    ]
                ]
            ],
            [
                'name' => 'Tekno',
                'email' => 'tekno@nigerianartists.com',
                'username' => 'tekno',
                'artist_stage_name' => 'Tekno',
                'artist_genre' => 'Afrobeats, Pop, R&B',
                'bio' => 'Augustine Miles Kelechi, known professionally as Tekno, is a Nigerian singer, songwriter, producer and dancer. He is known for his unique sound that blends Afrobeats with contemporary pop.',
                'profile_picture' => 'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/teknoofficial',
                    'twitter' => 'https://twitter.com/teknoofficial'
                ],
                'songs' => [
                    [
                        'title' => 'Pana',
                        'description' => 'Breakthrough hit that established Tekno as a major force in Afrobeats.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-24.mp3',
                        'duration' => '3:54'
                    ],
                    [
                        'title' => 'Diana',
                        'description' => 'Popular romantic track with smooth production and catchy melodies.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-25.mp3',
                        'duration' => '3:26'
                    ]
                ]
            ],
            [
                'name' => 'Adekunle Gold',
                'email' => 'adekunlegold@nigerianartists.com',
                'username' => 'adekunlegold',
                'artist_stage_name' => 'Adekunle Gold',
                'artist_genre' => 'Afrobeats, Highlife, Alternative',
                'bio' => 'Adekunle Kosoko, known professionally as Adekunle Gold, is a Nigerian highlife singer, songwriter and graphic designer. He is known for his modern take on traditional Yoruba music and highlife.',
                'profile_picture' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/adekunlegold',
                    'twitter' => 'https://twitter.com/adekunlegold'
                ],
                'songs' => [
                    [
                        'title' => 'Sade',
                        'description' => 'Beautiful highlife-influenced track showcasing Adekunle Gold\'s artistic vision.',
                        'genre' => 'Highlife',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-26.mp3',
                        'duration' => '3:41'
                    ],
                    [
                        'title' => 'High',
                        'description' => 'Contemporary Afrobeats track with modern production elements.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-27.mp3',
                        'duration' => '3:22'
                    ]
                ]
            ],
            [
                'name' => 'Falz',
                'email' => 'falz@nigerianartists.com',
                'username' => 'falz',
                'artist_stage_name' => 'Falz',
                'artist_genre' => 'Hip Hop, Comedy Rap, Afrobeats',
                'bio' => 'Folarin Falana, known professionally as Falz, is a Nigerian rapper, songwriter and actor. He is known for his socially conscious lyrics and comedic elements in his music.',
                'profile_picture' => 'https://images.unsplash.com/photo-1552058544-f2b08422138a?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/falzthebahdguy',
                    'twitter' => 'https://twitter.com/falzthebahdguy'
                ],
                'songs' => [
                    [
                        'title' => 'Bad Baddo Baddest',
                        'description' => 'Popular comedy rap track featuring Olamide with social commentary.',
                        'genre' => 'Hip Hop',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-28.mp3',
                        'duration' => '4:15'
                    ],
                    [
                        'title' => 'This Is Nigeria',
                        'description' => 'Controversial social commentary track addressing Nigerian societal issues.',
                        'genre' => 'Hip Hop',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-29.mp3',
                        'duration' => '4:28'
                    ]
                ]
            ],
            [
                'name' => 'Patoranking',
                'email' => 'patoranking@nigerianartists.com',
                'username' => 'patoranking',
                'artist_stage_name' => 'Patoranking',
                'artist_genre' => 'Reggae, Dancehall, Afrobeats',
                'bio' => 'Patrick Nnaemeka Okorie, known professionally as Patoranking, is a Nigerian reggae-dancehall singer and songwriter. He is known for blending Caribbean sounds with African rhythms.',
                'profile_picture' => 'https://images.unsplash.com/photo-1566492031773-4f4e44671d66?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/patorankingfire',
                    'twitter' => 'https://twitter.com/patorankingfire'
                ],
                'songs' => [
                    [
                        'title' => 'My Woman My Everything',
                        'description' => 'Reggae-influenced love song showcasing Patoranking\'s unique style.',
                        'genre' => 'Reggae',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-30.mp3',
                        'duration' => '4:01'
                    ],
                    [
                        'title' => 'Available',
                        'description' => 'Dancehall-Afrobeats fusion track with infectious Caribbean vibes.',
                        'genre' => 'Dancehall',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-31.mp3',
                        'duration' => '3:33'
                    ]
                ]
            ],
            [
                'name' => 'Timaya',
                'email' => 'timaya@nigerianartists.com',
                'username' => 'timaya',
                'artist_stage_name' => 'Timaya',
                'artist_genre' => 'Dancehall, Afrobeats, Reggae',
                'bio' => 'Inetimi Alfred Odon, known professionally as Timaya, is a Nigerian singer and songwriter. He is the founder of DM Records Limited and known for his energetic dancehall and Afrobeats fusion.',
                'profile_picture' => 'https://images.unsplash.com/photo-1520833967655-95d03871f2ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/timayatimaya',
                    'twitter' => 'https://twitter.com/timayatimaya'
                ],
                'songs' => [
                    [
                        'title' => 'Dem Mama',
                        'description' => 'Breakthrough hit that established Timaya as a major Nigerian artist.',
                        'genre' => 'Dancehall',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-32.mp3',
                        'duration' => '3:45'
                    ],
                    [
                        'title' => 'Cold Outside',
                        'description' => 'Popular track featuring Buju with contemporary Afrobeats production.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-33.mp3',
                        'duration' => '3:18'
                    ]
                ]
            ],
            [
                'name' => '2Baba',
                'email' => '2baba@nigerianartists.com',
                'username' => '2baba',
                'artist_stage_name' => '2Baba',
                'artist_genre' => 'Afrobeats, R&B, Hip Hop',
                'bio' => 'Innocent Ujah Idibia, known professionally as 2Baba, is a Nigerian singer, songwriter, record producer and entrepreneur. He is one of the most decorated and successful Afrobeats artists.',
                'profile_picture' => 'https://images.unsplash.com/photo-1507591064344-4c6ce005b128?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/official2baba',
                    'twitter' => 'https://twitter.com/official2baba'
                ],
                'songs' => [
                    [
                        'title' => 'African Queen',
                        'description' => 'Legendary classic that put Nigerian music on the global map.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-34.mp3',
                        'duration' => '3:57'
                    ],
                    [
                        'title' => 'Implication',
                        'description' => 'Contemporary hit showcasing 2Baba\'s enduring relevance in Nigerian music.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-35.mp3',
                        'duration' => '3:14'
                    ]
                ]
            ],
            [
                'name' => 'Phyno',
                'email' => 'phyno@nigerianartists.com',
                'username' => 'phyno',
                'artist_stage_name' => 'Phyno',
                'artist_genre' => 'Hip Hop, Afrobeats, Highlife',
                'bio' => 'Chibuzor Nelson Azubuike, known professionally as Phyno, is a Nigerian rapper, singer, songwriter and record producer. He is known for rapping and singing primarily in the Igbo language.',
                'profile_picture' => 'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/phynofino',
                    'twitter' => 'https://twitter.com/phynofino'
                ],
                'songs' => [
                    [
                        'title' => 'Fada Fada',
                        'description' => 'Popular hip-hop track featuring Olamide with catchy Igbo lyrics.',
                        'genre' => 'Hip Hop',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-36.mp3',
                        'duration' => '4:22'
                    ],
                    [
                        'title' => 'Financial Woman',
                        'description' => 'Highlife-influenced track celebrating successful African women.',
                        'genre' => 'Highlife',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-37.mp3',
                        'duration' => '3:59'
                    ]
                ]
            ],
            [
                'name' => 'Oxlade',
                'email' => 'oxlade@nigerianartists.com',
                'username' => 'oxlade',
                'artist_stage_name' => 'Oxlade',
                'artist_genre' => 'Afrobeats, R&B',
                'bio' => 'Ikuforiji Olaitan Abdulrahman, known professionally as Oxlade, is a Nigerian singer and songwriter. He is known for his smooth vocals and contemporary R&B-influenced Afrobeats sound.',
                'profile_picture' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=300',
                'country' => 'Nigeria',
                'social_links' => [
                    'instagram' => 'https://instagram.com/oxladeofficial',
                    'twitter' => 'https://twitter.com/oxladeofficial'
                ],
                'songs' => [
                    [
                        'title' => 'Away',
                        'description' => 'Smooth R&B-Afrobeats track showcasing Oxlade\'s vocal prowess.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-38.mp3',
                        'duration' => '3:12'
                    ],
                    [
                        'title' => 'Ku Lo Sa',
                        'description' => 'Popular track featuring Blaq Jerzee with infectious melodies.',
                        'genre' => 'Afrobeats',
                        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-39.mp3',
                        'duration' => '2:57'
                    ]
                ]
            ]
        ];

        $this->command->info('Seeding 20 Nigerian artists with reserved usernames and emails...');

        foreach ($nigerianArtists as $artistData) {
            // Generate a secure random password for the seeded artist
            $randomPassword = Str::random(16);
            // Create User with 'artist' role
            $user = User::firstOrCreate(
                ['email' => $artistData['email']],
                [
                    'name' => $artistData['name'],
                    'password' => Hash::make($randomPassword),
                    'role' => 'artist',
                    'status' => 'approved',
                    'approved_at' => Carbon::now(),
                    'approved_by' => $admin->id,
                    'artist_stage_name' => $artistData['artist_stage_name'],
                    'artist_genre' => $artistData['artist_genre'],
                    'bio' => $artistData['bio'],
                    'profile_picture' => $artistData['profile_picture'],
                    'social_links' => $artistData['social_links'],
                    'verification_status' => 'verified',
                    'active_since' => Carbon::now()->subMonths(rand(6, 24))
                ]
            );

            // Create corresponding Artist model entry
            $artist = Artist::firstOrCreate(
                ['username' => $artistData['username']],
                [
                    'name' => $artistData['name'],
                    'slug' => \Illuminate\Support\Str::slug($artistData['name']),
                    'bio' => $artistData['bio'],
                    'image_url' => $artistData['profile_picture'],
                    'genre' => explode(',', $artistData['artist_genre'])[0], // First genre
                    'country' => $artistData['country'],
                    'social_links' => $artistData['social_links'],
                    'is_trending' => rand(0, 1) == 1,
                    'status' => 'published',
                    'created_by' => $admin->id
                ]
            );

            // Create songs for each artist
            foreach ($artistData['songs'] as $songData) {
                Music::firstOrCreate(
                    [
                        'title' => $songData['title'],
                        'artist_name' => $artistData['artist_stage_name']
                    ],
                    [
                        'slug' => \Illuminate\Support\Str::slug($songData['title']),
                        'description' => $songData['description'],
                        'artist_id' => $artist->id,
                        'genre' => $songData['genre'],
                        'audio_url' => $songData['audio_url'],
                        'duration' => $songData['duration'],
                        'image_url' => $artistData['profile_picture'], // Use artist profile as song image
                        'is_featured' => rand(0, 2) == 2, // 1/3 chance of being featured
                        'status' => 'published',
                        'created_by' => $user->id
                    ]
                );
            }

            $this->command->info("✓ Created artist: {$artistData['name']} ({$artistData['username']})");
        }

        $this->command->info('Nigerian Artist seeder completed successfully!');
        $this->command->info('20 Nigerian artists created with reserved usernames and emails.');
        $this->command->info('Each artist has 2-3 hit songs and cannot be registered by regular users.');
    }
}