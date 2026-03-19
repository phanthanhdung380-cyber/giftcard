<?php
require_once __DIR__ . '/bootstrap.php';
$active = 'shop';
$productId = $_GET['id'] ?? '';
$product = get_product($productId);
if (!$product) {
    header('Location: shop.php');
    exit;
}

$metaTitle = $product['name'] . ' | Roger Clothing';
$metaDescription = $product['description'];
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
    add_to_cart($productId, (int) $_POST['quantity']);
    header('Location: cart.php');
    exit;
}
?>
<main>
  <section class="section">
    <div class="container product-detail">
      <div>
        <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
      </div>
      <div>
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p><?php echo htmlspecialchars($product['description']); ?></p>
        <p><?php echo htmlspecialchars($product['details']); ?></p>
        <p class="price"><?php echo format_currency($product['price']); ?></p>
        <form method="post" data-validate>
          <label for="quantity">Quantity</label>
          <input id="quantity" name="quantity" type="number" min="1" value="1" data-required>
          <button class="button" type="submit">Add to Cart</button>
        </form>
        <a class="button secondary" href="shop.php">Back to Shop</a>
      </div>
    </div>
  </section>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "<?php echo htmlspecialchars($product['name']); ?>",
  "description": "<?php echo htmlspecialchars($product['description']); ?>",
  "image": "<?php echo BASE_URL . $product['image']; ?>",
  "brand": {
    "@type": "Brand",
    "name": "Roger Clothing"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "USD",
    "price": "<?php echo number_format($product['price'], 2); ?>",
    "availability": "https://schema.org/InStock"
  }
}
</script>
<?php include 'includes/footer.php'; ?>
