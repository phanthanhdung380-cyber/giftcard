<?php
require_once __DIR__ . '/bootstrap.php';
$active = 'cart';
$metaTitle = 'Cart | Roger Clothing';
$metaDescription = 'Review your selections and proceed to cash on delivery checkout.';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart']) && isset($_POST['quantities'])) {
        update_cart($_POST['quantities']);
    }

    if (isset($_POST['remove_item'])) {
        remove_from_cart($_POST['remove_item']);
    }

    header('Location: cart.php');
    exit;
}

include 'includes/header.php';
$items = cart_items();
?>
<main>
  <section class="section">
    <div class="container">
      <div class="section-title">
        <h2>Your Cart</h2>
        <p>Review your selections before placing your COD order.</p>
      </div>
      <?php if (empty($items)): ?>
        <div class="notice">Your cart is currently empty. Visit the shop to add items.</div>
        <a class="button" href="shop.php">Return to Shop</a>
      <?php else: ?>
        <form method="post">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td><?php echo htmlspecialchars($item['product']['name']); ?></td>
                  <td><?php echo format_currency($item['product']['price']); ?></td>
                  <td>
                    <input type="number" name="quantities[<?php echo $item['product']['id']; ?>]" min="1" value="<?php echo $item['quantity']; ?>">
                  </td>
                  <td><?php echo format_currency($item['line_total']); ?></td>
                  <td>
                    <button class="button secondary" type="submit" name="remove_item" value="<?php echo $item['product']['id']; ?>">Remove</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <button class="button" type="submit" name="update_cart">Update Cart</button>
        </form>
        <div class="cart-summary">
          <h3>Order Summary</h3>
          <p>Total: <strong><?php echo format_currency(cart_total()); ?></strong></p>
          <a class="button" href="checkout.php">Proceed to COD Checkout</a>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>
