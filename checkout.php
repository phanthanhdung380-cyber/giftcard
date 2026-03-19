<?php
require_once __DIR__ . '/bootstrap.php';
$active = 'cart';
$metaTitle = 'Checkout | Roger Clothing';
$metaDescription = 'Place a cash on delivery order and pay when your order arrives.';

$items = cart_items();
$orderPlaced = false;
$orderReference = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($items)) {
    $requiredFields = ['full_name', 'phone', 'email', 'address'];
    $missing = array_filter($requiredFields, fn($field) => empty(trim($_POST[$field] ?? '')));

    if (empty($missing)) {
        $orderReference = 'RC-' . strtoupper(substr(md5((string) time()), 0, 8));
        $order = [
            'reference' => $orderReference,
            'timestamp' => date('c'),
            'customer' => [
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),
            ],
            'items' => $items,
            'total' => cart_total(),
            'payment_method' => 'Cash on Delivery'
        ];
        write_order_log($order);
        $_SESSION['cart'] = [];
        $items = [];
        $orderPlaced = true;
    }
}

include 'includes/header.php';
?>
<main>
  <section class="section">
    <div class="container">
      <div class="section-title">
        <h2>Cash on Delivery Checkout</h2>
        <p>Reserve your order today and pay when it arrives at your door.</p>
      </div>
      <div class="notice">
        <p><strong>COD policy:</strong> Orders are shipped within 2 business days. Please keep cash ready at delivery. Our driver will provide a printed receipt.</p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <?php if ($orderPlaced): ?>
        <div class="card">
          <h3>Thank you for your order.</h3>
          <p>Your order reference is <strong><?php echo $orderReference; ?></strong>. We will call to confirm delivery within one business day.</p>
          <a class="button" href="shop.php">Continue Shopping</a>
        </div>
      <?php elseif (empty($items)): ?>
        <div class="notice">Your cart is empty. Please add items before checking out.</div>
        <a class="button" href="shop.php">Browse the Shop</a>
      <?php else: ?>
        <form method="post" data-validate>
          <div class="form-grid">
            <div>
              <label for="full_name">Full Name *</label>
              <input id="full_name" name="full_name" type="text" data-required>
            </div>
            <div>
              <label for="phone">Phone Number *</label>
              <input id="phone" name="phone" type="tel" data-required>
            </div>
            <div>
              <label for="email">Email *</label>
              <input id="email" name="email" type="email" data-required>
            </div>
          </div>
          <div>
            <label for="address">Shipping Address *</label>
            <textarea id="address" name="address" data-required></textarea>
          </div>
          <button class="button" type="submit">Place COD Order</button>
        </form>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>
