<!DOCTYPE html>
<html lang="<?= APP_LANG ?>" dir="<?= APP_LANG === 'ar' ? 'rtl' : 'ltr' ?>" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index, follow">
  <meta name="author" content="MS Horizon Group">

  <!-- Primary SEO -->
  <title><?= htmlspecialchars($page_title ?? APP_NAME, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($page_description ?? 'MS Horizon Group — One trusted organisation providing Travel, Reservations, HR Consultancy, Business Setup & Software Development.', ENT_QUOTES, 'UTF-8') ?>">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= htmlspecialchars($page_title ?? APP_NAME, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($page_description ?? '', ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:image" content="<?= APP_URL ?>/assets/images/og-banner.jpg">
  <meta property="og:url" content="<?= APP_URL . htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:site_name" content="MS Horizon Group">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($page_title ?? APP_NAME, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($page_description ?? '', ENT_QUOTES, 'UTF-8') ?>">
  <meta name="twitter:image" content="<?= APP_URL ?>/assets/images/og-banner.jpg">

  <!-- Canonical -->
  <link rel="canonical" href="<?= APP_URL . htmlspecialchars(strtok($_SERVER['REQUEST_URI'], '?'), ENT_QUOTES, 'UTF-8') ?>">

  <!-- Favicons -->
  <link rel="icon" type="image/png" href="<?= APP_URL ?>/assets/images/favicon.png">
  <link rel="apple-touch-icon" href="<?= APP_URL ?>/assets/images/apple-touch-icon.png">

  <!-- Google Fonts preconnect -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- SweetAlert2 CSS & JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- MS Horizon Core Styles -->
  <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">

  <!-- Structured Data - Organization Schema -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "MS Horizon Group",
    "url": "<?= APP_URL ?>",
    "logo": "<?= APP_URL ?>/assets/images/logo.png",
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+971-4-123-4567",
      "contactType": "customer service",
      "areaServed": "AE",
      "availableLanguage": ["English", "Arabic"]
    },
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Level 28, Horizon Tower, Business Bay",
      "addressLocality": "Dubai",
      "addressCountry": "AE"
    },
    "sameAs": [
      "https://www.linkedin.com/company/mshorizongroup",
      "https://www.instagram.com/mshorizongroup"
    ]
  }
  </script>

  <?php if (isset($extra_head)) echo $extra_head; ?>
</head>
<body>
