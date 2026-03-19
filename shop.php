<?php
require_once __DIR__ . '/bootstrap.php';
$active = 'shop';
$metaTitle = 'Shop | Roger Clothing';
$metaDescription = 'Browse refined collections crafted for 45+ customers with cash on delivery available.';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    add_to_cart($_POST['product_id'], (int) $_POST['quantity']);
    header('Location: cart.php');
    exit;
}
?>
<main>
  <section class="section">
    <div class="container">
      <div class="section-title">
        <h2>Curated Collections</h2>
        <p>Premium outfits and essentials for refined comfort.</p>
      </div>
      <div class="card-grid">
        <?php foreach (get_products() as $product): ?>
          <article class="card product-card">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price"><?php echo format_currency($product['price']); ?></p>
            <form method="post" data-validate>
              <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
              <label for="qty-<?php echo $product['id']; ?>">Quantity</label>
              <input id="qty-<?php echo $product['id']; ?>" name="quantity" type="number" min="1" value="1" data-required>
              <button class="button" type="submit">Add to Cart</button>
            </form>
            <a class="button secondary" href="product.php?id=<?php echo urlencode($product['id']); ?>">View Details</a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container banner">
      <h3>Need help choosing sizes?</h3>
      <p>Our team will guide you through measurements and recommend the most flattering fit. Call <?php echo SITE_PHONE; ?> or visit the contact page.</p>
      <a class="button" href="contact.php">Speak to a Stylist</a>
    </div>
  </section>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Roger Clothing",
  "telephone": "<?php echo SITE_PHONE; ?>"
}
</script>
<?php include 'includes/footer.php'; ?>
