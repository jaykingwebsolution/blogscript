# BlogScript

A responsive blog application built with Laravel Blade templates and Tailwind CSS.

## Features

- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Navigation**: Inspired by naijakit.com with all required navigation links
- **Hero Section**: Eye-catching banner with call-to-action buttons
- **Content Sections**: 
  - Featured Music (3 items)
  - Trending Artists (4 items)
  - Latest Blog Posts (3 items)
  - Recent Videos (4 items)
- **Blade Components**: Modular components for navbar, footer, and cards
- **Newsletter Signup**: Email subscription form

## File Structure

```
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php          # Main layout template
│   ├── components/
│   │   ├── navbar.blade.php       # Navigation component
│   │   ├── footer.blade.php       # Footer component
│   │   └── card.blade.php         # Reusable card component
│   └── home.blade.php             # Home page view
├── css/
│   └── app.css                    # Main stylesheet
routes/
└── web.php                        # Route definitions
```

## Setup

1. Install dependencies:
   ```bash
   composer install
   npm install
   ```

2. Build CSS:
   ```bash
   npm run build
   ```

3. Serve the application:
   ```bash
   php artisan serve
   ```

## Navigation Links

The navigation includes all requested links:
- Home
- Music
- Artists
- Gist
- Video
- News
- About
- Contact
- Privacy Policy

## Responsive Design

The layout is fully responsive with:
- Mobile navigation menu
- Responsive grid layouts
- Mobile-first design approach
- Optimized for all screen sizes