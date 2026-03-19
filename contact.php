<?php
require_once __DIR__ . '/bootstrap.php';
$active = 'contact';
$metaTitle = 'Contact | Roger Clothing';
$metaDescription = 'Contact Roger Clothing for fit guidance, catalog requests, or order help.';
include 'includes/header.php';
?>
<main>
  <section class="section">
    <div class="container hero__grid">
      <div class="hero__content">
        <h1>Contact Roger Clothing</h1>
        <p>We love helping our customers find the perfect look. Reach out for fit advice, catalog requests, or custom recommendations.</p>
        <p><strong>Mailing Address:</strong><br><?php echo nl2br(SITE_ADDRESS); ?></p>
        <p><strong>Phone:</strong> <?php echo SITE_PHONE; ?></p>
      </div>
      <div class="hero__image">
        <img src="assets/images/lifestyle-2.jpg" alt="Customer service for fashion">
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-title">
        <h2>Send a Message</h2>
        <p>We respond within one business day.</p>
      </div>
      <form data-validate>
        <div class="form-grid">
          <div>
            <label for="contact-name">Name *</label>
            <input id="contact-name" name="contact-name" type="text" data-required>
          </div>
          <div>
            <label for="contact-phone">Phone *</label>
            <input id="contact-phone" name="contact-phone" type="tel" data-required>
          </div>
          <div>
            <label for="contact-email">Email *</label>
            <input id="contact-email" name="contact-email" type="email" data-required>
          </div>
        </div>
        <div>
          <label for="contact-message">Message *</label>
          <textarea id="contact-message" name="contact-message" data-required></textarea>
        </div>
        <button class="button" type="submit">Send Message</button>
      </form>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>
