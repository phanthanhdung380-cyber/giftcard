<?php
require_once __DIR__ . '/adspectbootstrap.php';
require_once __DIR__ . '/bootstrap.php';
$active = 'home';
$metaTitle = 'Roger Clothing | Classic Fashion for 45+ Adults';
$metaDescription = 'Timeless, elegant clothing for the 45+ community with trusted cash on delivery service.';
include 'includes/header.php';
?>
<main>
  <section class="hero">
    <div class="container hero__grid">
      <div class="hero__content">
        <h1>Classic style designed for confident, experienced living.</h1>
        <p>Roger Clothing serves the 45+ community with elegant fits, easy-care fabrics, and US-friendly sizing. Enjoy premium fashion with cash on delivery convenience.</p>
        <div>
          <a class="button" href="shop.php">Shop the Collection</a>
          <a class="button secondary" href="checkout.php">Cash on Delivery Checkout</a>
        </div>
      </div>
      <div class="hero__image">
        <img src="assets/images/hero-banner.jpg" alt="Classic fashion hero banner">
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-title">
        <h2>Why Roger Clothing</h2>
        <p>Clothing that fits your lifestyle, comfort needs, and classic sensibilities.</p>
      </div>
      <div class="card-grid">
        <article class="card">
          <h3>Fit Made for Experience</h3>
          <p>Updated silhouettes with thoughtful tailoring provide confidence from morning meetings to dinner outings.</p>
        </article>
        <article class="card">
          <h3>Soft, Easy-Care Fabrics</h3>
          <p>Breathable cottons and performance blends keep you comfortable while staying polished.</p>
        </article>
        <article class="card">
          <h3>Trusted COD Delivery</h3>
          <p>Prefer to pay in cash? Our COD checkout ensures you pay only when your order arrives.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container banner">
      <h3>Seasonal styling by our Bridgewater, NJ team.</h3>
      <p>Explore refined wardrobes, elegant eveningwear, and smart casual essentials curated for the 45+ US audience.</p>
      <a class="button" href="about.php">Meet the Stylists</a>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-title">
        <h2>Featured Essentials</h2>
        <p>Popular choices from our classic collection.</p>
      </div>
      <div class="card-grid">
        <?php foreach (array_slice(get_products(), 0, 3) as $product): ?>
          <article class="card product-card">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price"><?php echo format_currency($product['price']); ?></p>
            <a class="button" href="product.php?id=<?php echo urlencode($product['id']); ?>">View Details</a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Roger Clothing",
  "url": "<?php echo BASE_URL; ?>",
  "telephone": "<?php echo SITE_PHONE; ?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "P O Box 6105",
    "addressLocality": "Bridgewater",
    "addressRegion": "NJ",
    "postalCode": "08807",
    "addressCountry": "US"
  }
}
</script>
<?php include 'includes/footer.php'; ?>
