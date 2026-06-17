# More Than Templates (MTT)

**More Than Templates** is a general-purpose website template — not a CMS — built to shorten development time while giving you a fully interactive, feature-rich foundation out of the box.

Unlike a typical template, MTT ships with extra built-in functionality so you can launch a quality, engaging website without building common features from scratch. It works equally well for personal or business sites, and can be configured to run alongside any blogging platform.

If you're a skilled PHP programmer, MTT is also a solid base to extend further — adding things like an affiliate program, social networking with individual public member pages, and more.

MTT comes with pre-configured scripts, so in most cases you only need to edit a single configuration file and the rest is set up for you.

## Note
- This PHP program is an old file from 2010. Some of the PHP commands may already be deprecated.

## Features

- **Contact Form** — Captcha-enabled to help cut down on spam.
- **Slideshows** — Smooth fading transitions that degrade gracefully; if JavaScript is disabled, a `<noscript>` fallback is used automatically.
- **Membership Area**
  - Visitor registration with a personal member login area
  - Forgot password facility
  - Change password facility
  - Profile editing, including photo upload
- **Forum Script**
  - Posts can be set to auto-approve or require moderation
  - Supports multiple forums
  - Each forum can have its own dedicated moderator
- **Admin Area**
  - View site visitors, including which pages they visit and where they came from
  - Track new signups
  - Manage members
  - Manage forum content and settings
- **Photo Gallery** — Lightbox-powered image popups (Colorbox), with a second mode for opening external webpages in a lightbox without leaving your site.
- **Video Page** — Includes a sample page for JavaScript-enabled browsers and a separate sample page for JavaScript-disabled browsers.
- **Drop-Down Menu** — Smooth fading transition effects.

## Pages to Edit

| File | Description |
|---|---|
| `index.php` | The home page |
| `header.php` | The page top section |
| `footer.php` | Footer menu |
| `topmenu.php` | The top menu |
| `sidemenu.php` | The side menu |
| `contact.php` | Contact form page |
| `messagesent.php` | Shown to members after a message is sent successfully |
| `emailproblem.php` | Shown to members if a message fails to send |
| `forum.php` | The forum page |
| `photogallery.php` | Photo gallery (supports as many categories as needed) |
| `resources.php` | External links page — links open in a lightbox instead of leaving the site |
| `regular.php` | A regular page, suitable for articles |
| `regular_onecolumn.php` | A regular page without the side menu |
| `regularpage_withslideshow.php` | A regular page that includes a slideshow |
| `sample_video.php` | Sample video page (JavaScript enabled) |
| `nojs_sample_video.php` | Sample video page for browsers with JavaScript disabled |
| `404.php` | Not found page |

## Getting Started

1. Clone or download this repository.
2. Edit the main configuration file to match your site's settings.
3. Customize the pages listed above to fit your content.
4. Upload to your hosting environment and you're ready to go.

## License

Add your license information here.
