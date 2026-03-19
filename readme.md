\# Roger Clothing Website



A multi-page PHP fashion e-commerce site tailored for 45+ US customers with Cash on Delivery (COD) checkout.



\## Setup Instructions

1\. Upload the entire project folder to your hosting provider.

2\. Ensure PHP 8.0+ is available on the server.

3\. Set the document root to the project directory (the folder containing `index.php`).

4\. Visit `index.php` in your browser.



\## Cash on Delivery (COD)

\- Customers place orders through the checkout form.

\- Orders are logged to `orders.log` in JSON format.

\- Payment is collected in cash upon delivery.



\## Folder Overview

\- `index.php`, `shop.php`, `product.php`, `cart.php`, `checkout.php`, `about.php`, `contact.php`: Site pages.

\- `bootstrap.php`: Session and configuration loader used by every page.

\- `includes/`: Shared header and footer templates.

\- `assets/css/style.css`: Global styling.

\- `assets/js/main.js`: Navigation and form validation.

\- `assets/images/`: Custom images and textures.

\- `orders.log`: Generated order log after checkout submissions.



\## Notes

\- The cart is stored in the PHP session.

\- To reset the cart, clear the browser session or remove `orders.log`.



