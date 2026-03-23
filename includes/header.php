<?php
  $metaTitle = $metaTitle ?? SITE_NAME;
  $metaDescription = $metaDescription ?? 'Classic, elegant fashion for the 45+ community with cash on delivery convenience.';
  $active = $active ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Histats.com  START  (aync)-->
<script type="text/javascript">var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,5015863,4,0,0,0,00010000']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
hs.src = ('//s10.histats.com/js15_as.js');
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?5015863&101" alt="hit tracker" border="0"></a></noscript>
<!-- Histats.com  END  -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($metaTitle); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
  <meta property="og:title" content="<?php echo htmlspecialchars($metaTitle); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
  <meta property="og:image" content="<?php echo BASE_URL; ?>assets/images/hero-banner.jpg">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="top-bar">
    <div class="container top-bar__content">
      <span>Classic fashion for the 45+ community.</span>
      <span>Call us: <?php echo SITE_PHONE; ?></span>
    </div>
  </div>
  <header class="header">
    <div class="container header__content">
      <a class="logo" href="index.php">Roger Clothing</a>
      <button class="menu-toggle" aria-expanded="false" aria-controls="primary-navigation">Menu</button>
      <nav id="primary-navigation" class="nav" role="navigation">
        <a href="index.php" class="<?php echo $active === 'home' ? 'active' : ''; ?>">Home</a>
        <a href="shop.php" class="<?php echo $active === 'shop' ? 'active' : ''; ?>">Shop</a>
        <a href="cart.php" class="<?php echo $active === 'cart' ? 'active' : ''; ?>">Cart (<?php echo cart_count(); ?>)</a>
        <a href="about.php" class="<?php echo $active === 'about' ? 'active' : ''; ?>">Our Story</a>
        <a href="contact.php" class="<?php echo $active === 'contact' ? 'active' : ''; ?>">Contact</a>
      </nav>
    </div>
  </header>
