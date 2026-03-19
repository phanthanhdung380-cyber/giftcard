<?php
require_once __DIR__ . '/bootstrap.php';
$active = 'about';
$metaTitle = 'Our Story | Roger Clothing';
$metaDescription = 'Learn about Roger Clothing and our commitment to elegant fashion for experienced shoppers.';
include 'includes/header.php';
?>
<main>
  <section class="section">
    <div class="container hero__grid">
      <div class="hero__content">
        <h1>Our Story</h1>
        <p>Roger Clothing began with a simple promise: deliver polished, comfortable fashion to the 45+ community. From Bridgewater, NJ, we curate collections that honor experience, elevate confidence, and keep your day effortless.</p>
        <p>Our stylists work closely with American manufacturers and heritage mills to ensure every garment is easy to maintain, flattering, and ready for any occasion.</p>
      </div>
      <div class="hero__image">
        <img src="assets/images/lifestyle-1.jpg" alt="Mature lifestyle fashion">
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-title">
        <h2>Our Commitments</h2>
        <p>Service and style aligned to your needs.</p>
      </div>
      <div class="card-grid">
        <article class="card">
          <h3>Personal Styling Help</h3>
          <p>Call or message our team for fit guidance, outfit pairings, and packing lists for your next trip.</p>
        </article>
        <article class="card">
          <h3>Quality You Can Feel</h3>
          <p>We review each fabric for softness, stretch recovery, and colorfastness before it enters our catalog.</p>
        </article>
        <article class="card">
          <h3>Community Focused</h3>
          <p>We host local trunk shows and partner with US charities supporting lifelong learning.</p>
        </article>
      </div>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>
