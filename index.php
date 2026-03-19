<?php
require_once __DIR__ . '/bootstrap.php';
// index.php — Donna's Fashion Accessories (single-page, SEO-friendly, images + PHP contact form)

// -------------------------
// Site configuration
// -------------------------
$siteName = "Donna's Fashion Accessories";
$tagline  = "Imported luxury fashion accessories supplier";
$address  = "PO Box 158, Harleyville, SC 29448, USA";
$phone    = "8434627666";
$emailTo  = "info@donnasfashionaccessories.com"; // change to your email

// IMPORTANT for SEO: replace with your real domain once hosted (MUST be a quoted string)
$siteUrl  = "https://www.example.com"; // CHANGE THIS
$canonicalUrl = rtrim($siteUrl, "/") . "/";

// Brand visuals (paths relative to this index.php)
// Upload these images into the SAME folder as index.php (or adjust paths below)
$images = [
  "hero"    => "hero-fashion.jpg",        // 21:9 (wide)
  "about"   => "about-accessories.jpg",   // 4:3 (landscape)
  "coll"    => "collection-bags.jpg",     // 3:2 (landscape)
  "square"  => "feature-jewelry.jpg",     // 1:1 (square)
  "contact" => "contact-fashion.jpg",     // 4:5 (tall)
];

// For better deliverability: ideally use an address on your domain (e.g. no-reply@yourdomain.com)
// Many hosts reject mail() if From doesn't match your domain.
$fromEmail = $emailTo;

// -------------------------
// Helpers
// -------------------------
function h($v) { return htmlspecialchars($v ?? "", ENT_QUOTES, "UTF-8"); }

// -------------------------
// Contact form handling
// -------------------------
$form = ["name"=>"","email"=>"","phone"=>"","interest"=>"","message"=>""];
$errors = [];
$success = false;

session_start();
if (!isset($_SESSION["csrf_token"]) || !is_string($_SESSION["csrf_token"]) || strlen($_SESSION["csrf_token"]) < 20) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION["csrf_token"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["contact_form"])) {
  // CSRF
  $postedToken  = $_POST["csrf_token"] ?? "";
  if (!$postedToken || !hash_equals($csrfToken, $postedToken)) {
    $errors[] = "Security check failed. Please refresh and try again.";
  }

  // Honeypot (bots fill hidden inputs)
  $honeypot = trim($_POST["company_site"] ?? "");
  if ($honeypot !== "") {
    $errors[] = "Submission rejected.";
  }

  // Collect
  $form["name"]     = trim($_POST["name"] ?? "");
  $form["email"]    = trim($_POST["email"] ?? "");
  $form["phone"]    = trim($_POST["phone"] ?? "");
  $form["interest"] = trim($_POST["interest"] ?? "");
  $form["message"]  = trim($_POST["message"] ?? "");

  // Validate
  if ($form["name"] === "" || mb_strlen($form["name"]) < 2) $errors[] = "Name is required (min 2 characters).";
  if ($form["email"] === "" || !filter_var($form["email"], FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
  if ($form["message"] === "" || mb_strlen($form["message"]) < 12) $errors[] = "Message is required (min 12 characters).";
  if ($form["phone"] !== "" && !preg_match('/^[0-9+\-\s().]{7,25}$/', $form["phone"])) $errors[] = "Phone format looks invalid.";

  if (!$errors) {
    $ip = $_SERVER["REMOTE_ADDR"] ?? "unknown";
    $ua = $_SERVER["HTTP_USER_AGENT"] ?? "unknown";

    $body =
      "New website inquiry - {$siteName}\n\n" .
      "Name: {$form["name"]}\n" .
      "Email: {$form["email"]}\n" .
      "Phone: " . ($form["phone"] ?: "-") . "\n" .
      "Interest: " . ($form["interest"] ?: "-") . "\n\n" .
      "Message:\n{$form["message"]}\n\n" .
      "----\nIP: {$ip}\nUser-Agent: {$ua}\n";

    $headers = [];
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: text/plain; charset=UTF-8";
    $headers[] = "From: {$siteName} <{$fromEmail}>";
    $headers[] = "Reply-To: {$form["name"]} <{$form["email"]}>";

    $sent = @mail($emailTo, "[Website] New Inquiry", $body, implode("\r\n", $headers));

    if ($sent) {
      $success = true;
      $form = ["name"=>"","email"=>"","phone"=>"","interest"=>"","message"=>""];
    } else {
      // Fallback log so inquiries aren't lost if mail() isn't configured
      $logLine = "[" . date("Y-m-d H:i:s") . "] " . str_replace("\n", " | ", $body) . "\n\n";
      @file_put_contents(__DIR__ . "/contact_submissions.log", $logLine, FILE_APPEND);
      $errors[] = "Message saved, but email delivery is not configured on this server. Please call or email directly.";
    }
  }
}

// -------------------------
// SEO meta
// -------------------------
$pageTitle = "{$siteName} | Imported Luxury Fashion Accessories Supplier";
$description = "Donna's Fashion Accessories supplies imported luxury accessories—handbags, jewelry, scarves, and statement pieces curated for boutiques, stylists, and premium clients.";
$keywords = "luxury fashion accessories, imported accessories, designer handbags supplier, luxury jewelry supplier, boutique accessories wholesale, scarves, belts, premium fashion";
$ogImage = rtrim($siteUrl, "/") . "/" . $images["hero"]; // best-effort
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />

  <title><?php echo h($pageTitle); ?></title>
  <meta name="description" content="<?php echo h($description); ?>" />
  <meta name="keywords" content="<?php echo h($keywords); ?>" />
  <meta name="author" content="<?php echo h($siteName); ?>" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
  <link rel="canonical" href="<?php echo h($canonicalUrl); ?>" />

  <meta name="theme-color" content="#0b0a0b" />

  <!-- Open Graph -->
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?php echo h($siteName); ?>" />
  <meta property="og:title" content="<?php echo h($pageTitle); ?>" />
  <meta property="og:description" content="<?php echo h($description); ?>" />
  <meta property="og:url" content="<?php echo h($canonicalUrl); ?>" />
  <meta property="og:image" content="<?php echo h($ogImage); ?>" />
  <meta property="og:image:alt" content="Luxury fashion accessories curated by <?php echo h($siteName); ?>" />

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?php echo h($pageTitle); ?>" />
  <meta name="twitter:description" content="<?php echo h($description); ?>" />
  <meta name="twitter:image" content="<?php echo h($ogImage); ?>" />

  <!-- LocalBusiness schema -->
  <script type="application/ld+json">
  <?php
    $schema = [
      "@context" => "https://schema.org",
      "@type" => "LocalBusiness",
      "name" => $siteName,
      "description" => $description,
      "telephone" => $phone,
      "email" => $emailTo,
      "url" => $canonicalUrl,
      "image" => $ogImage,
      "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => "PO Box 158",
        "addressLocality" => "Harleyville",
        "addressRegion" => "SC",
        "postalCode" => "29448",
        "addressCountry" => "US"
      ],
      "areaServed" => "US",
      "makesOffer" => [
        ["@type"=>"Offer","name"=>"Imported Handbags & Small Leather Goods"],
        ["@type"=>"Offer","name"=>"Luxury Jewelry & Statement Pieces"],
        ["@type"=>"Offer","name"=>"Curated Accessories for Boutiques & Stylists"]
      ]
    ];
    echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  ?>
  </script>

  <style>
    :root{
      --bg:#070607;
      --panel:#0f0e10;
      --panel2:#141216;
      --text:#f6f0e8;
      --muted:#bdb3a7;
      --line:rgba(246,240,232,.12);
      --gold:#d7b98a;
      --gold2:#b58b55;
      --shadow:0 18px 50px rgba(0,0,0,.58);
      --radius:18px;
      --max:1120px;
      --serif: ui-serif, Georgia, "Times New Roman", Times, serif;
      --sans: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
    }
    *{box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{
      margin:0;
      color:var(--text);
      background:
        radial-gradient(1100px 600px at 70% -10%, rgba(215,185,138,.14), transparent 55%),
        radial-gradient(900px 520px at 10% 10%, rgba(215,185,138,.08), transparent 55%),
        var(--bg);
      line-height:1.6;
    }
    a{color:inherit;text-decoration:none}
    img{max-width:100%; display:block}

    .container{max-width:var(--max); margin:0 auto; padding:0 22px}
    .skip{position:absolute; left:-9999px; top:auto; width:1px; height:1px; overflow:hidden}
    .skip:focus{left:22px; top:18px; width:auto; height:auto; padding:10px 12px; background:var(--panel); border:1px solid var(--line); border-radius:12px; z-index:9999}

    header{
      position:sticky; top:0; z-index:999;
      backdrop-filter: blur(10px);
      background: rgba(7,6,7,.72);
      border-bottom:1px solid var(--line);
    }
    .topbar{display:flex; align-items:center; justify-content:space-between; gap:14px; padding:14px 0}
    .brand{display:flex; flex-direction:column; gap:2px; min-width:220px}
    .brand strong{font-family:var(--serif); font-weight:700; font-size:18px; letter-spacing:.2px}
    .brand span{font-family:var(--sans); color:var(--muted); font-size:12px; letter-spacing:.14em; text-transform:uppercase}

    nav ul{list-style:none; margin:0; padding:0; display:flex; gap:10px; align-items:center}
    nav a{
      font-family:var(--sans);
      font-size:13px;
      color:var(--muted);
      padding:10px 12px;
      border-radius:999px;
      border:1px solid transparent;
      transition: all .15s ease;
    }
    nav a:hover{color:var(--text); border-color:rgba(215,185,138,.25); background:rgba(215,185,138,.06)}
    nav a.active{color:var(--text); border-color:rgba(215,185,138,.42); background:rgba(215,185,138,.10)}

    .btn{
      font-family:var(--sans);
      display:inline-flex; align-items:center; justify-content:center;
      padding:10px 14px;
      border-radius:999px;
      border:1px solid rgba(215,185,138,.45);
      background: linear-gradient(180deg, rgba(215,185,138,.18), rgba(215,185,138,.08));
      color:var(--text);
      font-size:13px;
      letter-spacing:.02em;
      cursor:pointer;
      transition: all .15s ease;
      white-space:nowrap;
    }
    .btn:hover{background: linear-gradient(180deg, rgba(215,185,138,.24), rgba(215,185,138,.10))}
    .menuBtn{display:none}

    .mobileNav{display:none; border-top:1px solid var(--line); padding:10px 0 14px}
    .mobileNav a{
      display:block;
      padding:10px 12px;
      border-radius:12px;
      font-family:var(--sans);
      color:var(--muted);
      border:1px solid transparent;
    }
    .mobileNav a:hover{color:var(--text); border-color:rgba(215,185,138,.25); background:rgba(215,185,138,.06)}
    .mobileNav a.active{color:var(--text); border-color:rgba(215,185,138,.42); background:rgba(215,185,138,.10)}

    section{padding:72px 0}
    .sectionTitle{display:flex; align-items:flex-end; justify-content:space-between; gap:16px; margin-bottom:18px}
    .sectionTitle h2{margin:0; font-family:var(--serif); font-size:28px; letter-spacing:-.01em}
    .sectionTitle p{margin:0; font-family:var(--sans); color:var(--muted); font-size:14px; max-width:560px}

    .panel{
      background: linear-gradient(180deg, rgba(20,18,22,.88), rgba(15,14,16,.88));
      border:1px solid var(--line);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      overflow:hidden;
    }
    .pad{padding:18px}

    .imgBox{position:relative; overflow:hidden; border-radius:var(--radius); border:1px solid var(--line)}
    .imgBox img{width:100%; height:100%; object-fit:cover}

    .grid2{display:grid; grid-template-columns: 1fr 1fr; gap:16px}
    .grid3{display:grid; grid-template-columns: repeat(3, 1fr); gap:16px}

    .hero{padding:0}
    .heroMedia{
      position:relative;
      min-height: 72vh;
      display:flex;
      align-items:flex-end;
      border-bottom:1px solid var(--line);
      background:
        linear-gradient(180deg, rgba(7,6,7,.18), rgba(7,6,7,.88)),
        url('<?php echo h($images["hero"]); ?>');
      background-size: cover;
      background-position:center;
    }
    .heroInner{width:100%; padding: 92px 0 54px}
    .heroGrid{display:grid; grid-template-columns: 1.15fr .85fr; gap:18px; align-items:end}
    .kicker{font-family:var(--sans); letter-spacing:.18em; text-transform:uppercase; font-size:12px; color:rgba(246,240,232,.80)}
    h1{margin:10px 0 12px; font-family:var(--serif); font-size:46px; line-height:1.05; letter-spacing:-.02em}
    .lead{margin:0 0 16px; font-family:var(--sans); color:rgba(246,240,232,.82); font-size:16px; max-width:66ch}
    .pillRow{display:flex; flex-wrap:wrap; gap:10px; margin-top:12px}
    .pill{font-family:var(--sans); border:1px solid rgba(215,185,138,.22); background:rgba(215,185,138,.06); color:rgba(246,240,232,.86); padding:8px 10px; border-radius:999px; font-size:12px}

    .feature{
      display:flex; gap:14px; align-items:flex-start;
      padding:16px;
      border-radius:var(--radius);
      border:1px solid var(--line);
      background: rgba(255,255,255,.02);
    }
    .feature strong{display:block; font-family:var(--serif); font-size:16px; margin-bottom:6px}
    .feature p{margin:0; font-family:var(--sans); color:var(--muted); font-size:14px}

    form{display:grid; gap:12px}
    .row2{display:grid; grid-template-columns: 1fr 1fr; gap:12px}
    label{display:block; margin:0 0 6px; font-family:var(--sans); font-size:12px; color:rgba(246,240,232,.78); letter-spacing:.06em; text-transform:uppercase}
    input, textarea, select{
      width:100%;
      padding:12px 12px;
      border-radius:14px;
      border:1px solid rgba(246,240,232,.14);
      background: rgba(7,6,7,.40);
      color:var(--text);
      outline:none;
      font-family:var(--sans);
      font-size:14px;
    }
    textarea{min-height:140px; resize:vertical}
    input:focus, textarea:focus, select:focus{border-color: rgba(215,185,138,.55); box-shadow: 0 0 0 3px rgba(215,185,138,.14)}
    .help{margin:0; font-family:var(--sans); color:var(--muted); font-size:12px}
    .actions{display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:2px}

    .notice{
      border-radius:16px;
      padding:12px 12px;
      border:1px solid var(--line);
      background: rgba(255,255,255,.02);
      font-family:var(--sans);
      font-size:14px;
      margin-bottom:12px;
    }
    .notice.ok{border-color: rgba(215,185,138,.35); background: rgba(215,185,138,.08)}
    .notice.err{border-color: rgba(255,120,120,.35); background: rgba(255,120,120,.08)}
    .notice ul{margin:8px 0 0 18px}

    footer{border-top:1px solid var(--line); background: rgba(7,6,7,.86); padding:26px 0}
    .footerGrid{display:flex; align-items:flex-start; justify-content:space-between; gap:16px; flex-wrap:wrap}
    .footLinks{display:flex; gap:10px; flex-wrap:wrap}
    .footLinks a{
      font-family:var(--sans);
      color:var(--muted);
      padding:8px 10px;
      border-radius:999px;
      border:1px solid transparent;
    }
    .footLinks a:hover{color:var(--text); border-color:rgba(215,185,138,.25); background:rgba(215,185,138,.06)}
    .small{margin:10px 0 0; font-family:var(--sans); color:var(--muted); font-size:13px}

    @media (max-width: 980px){
      .heroGrid{grid-template-columns: 1fr}
      nav ul{display:none}
      .menuBtn{
        display:inline-flex;
        border:1px solid rgba(246,240,232,.14);
        background:rgba(255,255,255,.02);
        padding:10px 12px;
        border-radius:999px;
        font-family:var(--sans);
        color:var(--text);
        cursor:pointer;
      }
      .grid3{grid-template-columns: 1fr}
      .grid2{grid-template-columns: 1fr}
      .row2{grid-template-columns: 1fr}
      h1{font-size:38px}
    }
  </style>
</head>

<body>
  <a class="skip" href="#main">Skip to content</a>

  <header>
    <div class="container">
      <div class="topbar">
        <div class="brand">
          <strong><?php echo h($siteName); ?></strong>
          <span>Imported Luxury Accessories</span>
        </div>

        <nav aria-label="Primary navigation">
          <ul id="desktopNav">
            <li><a href="#home" data-link="home">Home</a></li>
            <li><a href="#about" data-link="about">About</a></li>
            <li><a href="#collections" data-link="collections">Collections</a></li>
            <li><a href="#services" data-link="services">Services</a></li>
            <li><a href="#contact" data-link="contact">Contact</a></li>
          </ul>
        </nav>

        <div style="display:flex; gap:10px; align-items:center;">
          <a class="btn" href="#contact">Request Catalog</a>
          <button class="menuBtn" id="menuBtn" type="button" aria-expanded="false" aria-controls="mobileNav">Menu</button>
        </div>
      </div>

      <div class="mobileNav" id="mobileNav" aria-label="Mobile navigation">
        <a href="#home" data-link="home">Home</a>
        <a href="#about" data-link="about">About</a>
        <a href="#collections" data-link="collections">Collections</a>
        <a href="#services" data-link="services">Services</a>
        <a href="#contact" data-link="contact">Contact</a>
      </div>
    </div>
  </header>

  <main id="main">
    <!-- HERO / BANNER -->
    <section class="hero" id="home" aria-label="Hero">
      <div class="heroMedia" role="img" aria-label="Luxury fashion accessories background image">
        <div class="container heroInner">
          <div class="heroGrid">
            <div>
              <div class="kicker">Imported pieces · Boutique-ready · Premium finish</div>
              <h1>Luxury accessories that complete the look—quietly, confidently.</h1>
              <p class="lead">
                <?php echo h($siteName); ?> supplies imported high-end fashion accessories—curated for boutiques,
                stylists, gifting, and premium clients. Thoughtful selection, reliable sourcing, and consistent quality.
              </p>
              <div class="pillRow" aria-label="Highlights">
                <span class="pill">Handbags & small leather goods</span>
                <span class="pill">Jewelry & statement pieces</span>
                <span class="pill">Scarves, belts & finishing details</span>
                <span class="pill">Boutique & stylist sourcing</span>
              </div>
            </div>

            <aside class="panel">
              <div class="pad">
                <strong style="font-family:var(--serif); font-size:18px; display:block; margin-bottom:10px;">Contact</strong>
                <p class="small" style="margin:0;"><strong style="color:rgba(246,240,232,.92);">PO Box:</strong><br><?php echo h($address); ?></p>
                <p class="small" style="margin-top:10px;"><strong style="color:rgba(246,240,232,.92);">Phone:</strong><br><a href="tel:<?php echo h($phone); ?>" style="text-decoration:underline; text-underline-offset:3px;"><?php echo h($phone); ?></a></p>
                <p class="small" style="margin-top:10px;"><strong style="color:rgba(246,240,232,.92);">Email:</strong><br><a href="mailto:<?php echo h($emailTo); ?>" style="text-decoration:underline; text-underline-offset:3px;"><?php echo h($emailTo); ?></a></p>
                <div style="height:12px;"></div>
                <p class="small" style="margin:0;">Typical requests: seasonal drops, curated boutique edits, gifting assortments, and stylist pulls.</p>
              </div>
            </aside>

          </div>
        </div>
      </div>
    </section>

    <!-- ABOUT -->
    <section id="about" aria-label="About us">
      <div class="container">
        <div class="sectionTitle">
          <h2>About</h2>
          <p>Premium accessories with a focus on finish quality, cohesive aesthetics, and boutique readiness.</p>
        </div>

        <div class="grid2">
          <div class="panel">
            <div class="pad">
              <div class="kicker" style="margin-bottom:10px;">Who we are</div>
              <p class="lead" style="margin:0;">
                We curate imported accessories chosen for craftsmanship, materials, and styling versatility.
                Our assortment is designed to complement luxury wardrobes—refined pieces that elevate without overpowering.
              </p>

              <div style="height:14px;"></div>

              <div class="feature">
                <div style="min-width:10px;height:10px;margin-top:8px;border-radius:999px;background:var(--gold);box-shadow:0 0 0 3px rgba(215,185,138,.12)"></div>
                <div>
                  <strong>Curated selection</strong>
                  <p>We prioritize finish, durability, and design coherence across collections.</p>
                </div>
              </div>

              <div style="height:10px;"></div>

              <div class="feature">
                <div style="min-width:10px;height:10px;margin-top:8px;border-radius:999px;background:var(--gold);box-shadow:0 0 0 3px rgba(215,185,138,.12)"></div>
                <div>
                  <strong>Import sourcing</strong>
                  <p>Reliable supply planning for boutiques, stylists, and premium orders.</p>
                </div>
              </div>

              <div style="height:10px;"></div>

              <div class="feature">
                <div style="min-width:10px;height:10px;margin-top:8px;border-radius:999px;background:var(--gold);box-shadow:0 0 0 3px rgba(215,185,138,.12)"></div>
                <div>
                  <strong>Premium positioning</strong>
                  <p>Accessories designed to align with upscale retail and luxury clients.</p>
                </div>
              </div>

            </div>
          </div>

          <div class="panel">
            <div class="imgBox" style="aspect-ratio:4/3;">
              <img src="<?php echo h($images["about"]); ?>" alt="Luxury accessories display and curation" loading="lazy" width="1600" height="1200">
            </div>
            <div class="pad">
              <p class="small" style="margin:0;">
                We build cohesive edits—pieces that photograph well, style easily, and sell with confidence.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- COLLECTIONS -->
    <section id="collections" aria-label="Collections">
      <div class="container">
        <div class="sectionTitle">
          <h2>Collections</h2>
          <p>Focused categories that support boutiques, stylists, and premium gifting.</p>
        </div>

        <div class="grid2">
          <div class="panel">
            <div class="imgBox" style="aspect-ratio:3/2;">
              <img src="<?php echo h($images["coll"]); ?>" alt="Imported luxury handbags and accessories collection" loading="lazy" width="1800" height="1200">
            </div>
            <div class="pad">
              <strong style="font-family:var(--serif); font-size:18px;">Handbags & leather goods</strong>
              <p class="small" style="margin-top:6px;">
                Boutique-ready silhouettes, premium textures, and details that hold up—ideal for seasonal drops.
              </p>
            </div>
          </div>

          <div class="panel">
            <div class="imgBox" style="aspect-ratio:1/1;">
              <img src="<?php echo h($images["square"]); ?>" alt="Luxury jewelry and statement accessories" loading="lazy" width="1200" height="1200">
            </div>
            <div class="pad">
              <strong style="font-family:var(--serif); font-size:18px;">Jewelry & statement pieces</strong>
              <p class="small" style="margin-top:6px;">
                Elevated finishing touches—designed to complement luxury styling and premium gifting.
              </p>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- SERVICES -->
    <section id="services" aria-label="Services">
      <div class="container">
        <div class="sectionTitle">
          <h2>Services</h2>
          <p>Support beyond supply—helpful for stylists, boutiques, and curated orders.</p>
        </div>

        <div class="grid3">
          <div class="panel">
            <div class="pad">
              <strong style="font-family:var(--serif); font-size:18px;">Curated assortment planning</strong>
              <p class="small" style="margin-top:8px;">Build cohesive boutique edits with balanced price points and category mix.</p>
            </div>
          </div>
          <div class="panel">
            <div class="pad">
              <strong style="font-family:var(--serif); font-size:18px;">Sourcing requests</strong>
              <p class="small" style="margin-top:8px;">Tell us the look, material, and target client—then we recommend options.</p>
            </div>
          </div>
          <div class="panel">
            <div class="pad">
              <strong style="font-family:var(--serif); font-size:18px;">Premium gifting</strong>
              <p class="small" style="margin-top:8px;">Curated gift-ready accessories with presentation considerations in mind.</p>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" aria-label="Contact">
      <div class="container">
        <div class="sectionTitle">
          <h2>Contact</h2>
          <p>Tell us what you’re looking for—categories, quantity, and preferred style direction.</p>
        </div>

        <div class="grid2">
          <div class="panel">
            <div class="pad">

              <?php if ($success): ?>
                <div class="notice ok" role="status" aria-live="polite">
                  Your message has been sent successfully. We will respond shortly.
                </div>
              <?php endif; ?>

              <?php if ($errors): ?>
                <div class="notice err" role="alert">
                  Please fix the following:
                  <ul>
                    <?php foreach ($errors as $e): ?>
                      <li><?php echo h($e); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>

              <form method="post" action="#contact" novalidate>
                <input type="hidden" name="contact_form" value="1" />
                <input type="hidden" name="csrf_token" value="<?php echo h($csrfToken); ?>" />

                <!-- Honeypot -->
                <input type="text" name="company_site" value="" tabindex="-1" autocomplete="off"
                       style="position:absolute; left:-9999px; width:1px; height:1px;" />

                <div class="row2">
                  <div>
                    <label for="name">Full name</label>
                    <input id="name" name="name" type="text" value="<?php echo h($form["name"]); ?>" required />
                  </div>
                  <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="<?php echo h($form["email"]); ?>" required />
                  </div>
                </div>

                <div class="row2">
                  <div>
                    <label for="phone">Phone (optional)</label>
                    <input id="phone" name="phone" type="text" value="<?php echo h($form["phone"]); ?>" />
                  </div>
                  <div>
                    <label for="interest">Interested in</label>
                    <select id="interest" name="interest">
                      <option value="" <?php echo $form["interest"]==="" ? "selected" : ""; ?>>Select…</option>
                      <option value="Handbags & leather goods" <?php echo $form["interest"]==="Handbags & leather goods" ? "selected" : ""; ?>>Handbags & leather goods</option>
                      <option value="Jewelry & statement pieces" <?php echo $form["interest"]==="Jewelry & statement pieces" ? "selected" : ""; ?>>Jewelry & statement pieces</option>
                      <option value="Scarves / belts / finishing details" <?php echo $form["interest"]==="Scarves / belts / finishing details" ? "selected" : ""; ?>>Scarves / belts / finishing details</option>
                      <option value="Boutique assortment planning" <?php echo $form["interest"]==="Boutique assortment planning" ? "selected" : ""; ?>>Boutique assortment planning</option>
                      <option value="Other / sourcing request" <?php echo $form["interest"]==="Other / sourcing request" ? "selected" : ""; ?>>Other / sourcing request</option>
                    </select>
                  </div>
                </div>

                <div>
                  <label for="message">Message</label>
                  <textarea id="message" name="message" required><?php echo h($form["message"]); ?></textarea>
                  <p class="help">Include: category, quantity, style preference, and timeline.</p>
                </div>

                <div class="actions">
                  <button class="btn" type="submit" id="submitBtn">Send inquiry</button>
                  <a class="btn" href="tel:<?php echo h($phone); ?>" style="border-color:rgba(246,240,232,.14); background:rgba(255,255,255,.02)">Call</a>
                  <a class="btn" href="mailto:<?php echo h($emailTo); ?>" style="border-color:rgba(246,240,232,.14); background:rgba(255,255,255,.02)">Email</a>
                </div>
              </form>
            </div>
          </div>

          <div class="panel">
            <div class="imgBox" style="aspect-ratio:4/5;">
              <img src="<?php echo h($images["contact"]); ?>" alt="Luxury fashion styling and accessories" loading="lazy" width="1200" height="1500">
            </div>
            <div class="pad">
              <strong style="font-family:var(--serif); font-size:18px;">Mailing address</strong>
              <p class="small" style="margin-top:10px;"><?php echo h($address); ?></p>
              <p class="small" style="margin-top:10px;">
                <strong style="color:rgba(246,240,232,.92);">Phone:</strong>
                <a href="tel:<?php echo h($phone); ?>" style="text-decoration:underline; text-underline-offset:3px;"><?php echo h($phone); ?></a>
              </p>
            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  <footer>
    <div class="container">
      <div class="footerGrid">
        <div>
          <strong style="font-family:var(--serif); font-size:18px;"><?php echo h($siteName); ?></strong>
          <div class="small">
            <?php echo h($address); ?><br>
            <a href="tel:<?php echo h($phone); ?>"><?php echo h($phone); ?></a>
            <?php if ($emailTo): ?> · <a href="mailto:<?php echo h($emailTo); ?>"><?php echo h($emailTo); ?></a><?php endif; ?>
          </div>
        </div>

        <div class="footLinks" aria-label="Footer navigation">
          <a href="#home" data-link="home">Home</a>
          <a href="#about" data-link="about">About</a>
          <a href="#collections" data-link="collections">Collections</a>
          <a href="#services" data-link="services">Services</a>
          <a href="#contact" data-link="contact">Contact</a>
          <a href="#home" id="backToTop">Back to top</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    (function () {
      // Mobile menu toggle
      const menuBtn = document.getElementById("menuBtn");
      const mobileNav = document.getElementById("mobileNav");
      if (menuBtn && mobileNav) {
        menuBtn.addEventListener("click", () => {
          const isOpen = mobileNav.style.display === "block";
          mobileNav.style.display = isOpen ? "none" : "block";
          menuBtn.setAttribute("aria-expanded", String(!isOpen));
        });

        // Close mobile nav when a link is clicked
        mobileNav.querySelectorAll('a[href^="#"]').forEach(a => {
          a.addEventListener("click", () => {
            mobileNav.style.display = "none";
            menuBtn.setAttribute("aria-expanded", "false");
          });
        });
      }

      // Active nav highlighting
      const navLinks = Array.from(document.querySelectorAll("[data-link]"));
      const sections = ["home","about","collections","services","contact"]
        .map(id => document.getElementById(id))
        .filter(Boolean);

      function setActive(id) {
        navLinks.forEach(a => a.classList.toggle("active", a.getAttribute("data-link") === id));
      }

      if ("IntersectionObserver" in window) {
        const obs = new IntersectionObserver((entries) => {
          const visible = entries
            .filter(e => e.isIntersecting)
            .sort((a,b) => b.intersectionRatio - a.intersectionRatio)[0];
          if (visible && visible.target && visible.target.id) setActive(visible.target.id);
        }, { threshold: [0.25, 0.5, 0.75] });

        sections.forEach(s => obs.observe(s));
      } else {
        window.addEventListener("scroll", () => {
          let current = "home";
          const y = window.scrollY + 140;
          sections.forEach(s => { if (s.offsetTop <= y) current = s.id; });
          setActive(current);
        });
      }
      setActive(location.hash.replace("#","") || "home");

      // Back to top smooth behavior
      const backToTop = document.getElementById("backToTop");
      if (backToTop) {
        backToTop.addEventListener("click", (e) => {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: "smooth" });
          history.replaceState(null, "", "#home");
        });
      }

      // Prevent double submit
      const form = document.querySelector('form[action="#contact"]');
      const submitBtn = document.getElementById("submitBtn");
      if (form && submitBtn) {
        form.addEventListener("submit", () => {
          submitBtn.disabled = true;
          submitBtn.textContent = "Sending...";
          setTimeout(() => { submitBtn.disabled = false; submitBtn.textContent = "Send inquiry"; }, 8000);
        });
      }
    })();
  </script>
</body>
</html>
