<?php
/**
 * Privacy Policy & Terms. Both footer links point here — Terms lives at #terms.
 */
require_once __DIR__ . '/helpers.php';
$C = require __DIR__ . '/config.php';
$b = $C['brand']; $p = $C['project']; $n = $C['notices'];
?>
<!DOCTYPE html>
<html lang="en-IN" class="scroll-smooth">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Privacy Policy &amp; Terms — <?= e($b['name']) ?></title>
<meta name="description" content="Privacy Policy and Terms &amp; Conditions for <?= e($b['website']) ?>, operated by <?= e($b['legal_name']) ?>, an Authorized Channel Partner.">
<meta name="robots" content="noindex, follow">
<meta name="theme-color" content="#0E0E10">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='7' fill='%230E0E10'/><path d='M5 25V14l5.5-3.2V25zM12 25V8l7-4.5V25zM20.5 25v-9.5L27 19v6z' fill='%23F5B301'/></svg>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300..600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { theme: { extend: {
  colors: { ink:{DEFAULT:'#0E0E10',800:'#17171B',500:'#5B5B63'}, ivory:{DEFAULT:'#FBF9F4',200:'#F4F0E7'},
            line:'#E3DCCC', gold:{DEFAULT:'#F5B301',600:'#D99B00',700:'#A97800'} },
  fontFamily: { display:['Fraunces','serif'], sans:['"Plus Jakarta Sans"','system-ui','sans-serif'] },
  maxWidth: { '8xl':'88rem' } } } }
</script>
<style>
  body{-webkit-font-smoothing:antialiased}
  .display{font-family:'Fraunces',serif;font-variation-settings:"SOFT" 0,"WONK" 1}
  .eyebrow{font-size:.6875rem;letter-spacing:.22em;text-transform:uppercase;font-weight:600}
  .prose p{margin-top:1.15rem;line-height:1.75}
  ::selection{background:#F5B301;color:#0E0E10}
</style>
</head>
<body class="bg-ivory text-ink font-sans">

<header class="bg-ink">
  <div class="max-w-8xl mx-auto px-5 sm:px-8 h-[68px] flex items-center justify-between gap-6">
    <a href="index.php" aria-label="<?= e($b['name']) ?> — home">
      <img src="<?= e(logo()) ?>" alt="<?= e($b['name']) ?>" width="393" height="103" class="h-9 sm:h-10 w-auto">
    </a>
    <a href="index.php" class="text-[13.5px] font-semibold text-ivory/80 hover:text-gold transition-colors">← Back to the project</a>
  </div>
</header>

<main class="max-w-8xl mx-auto px-5 sm:px-8 py-16 sm:py-24">
  <div class="max-w-3xl">

    <p class="eyebrow text-gold-700">Legal</p>
    <div class="h-px w-20 mt-3.5 mb-7" style="background:linear-gradient(90deg,#F5B301,rgba(245,179,1,0))"></div>
    <h1 class="display font-light text-[clamp(2.2rem,5vw,3.4rem)] leading-[1.05]">
      Privacy Policy &amp;<br><em class="not-italic text-gold-600">Terms &amp; Conditions</em>
    </h1>

    <!-- ------------------------------------------------ Privacy ------- -->
    <section id="privacy" class="mt-14 scroll-mt-8">
      <h2 class="display text-[28px] pb-4 border-b-2 border-gold">Privacy Policy</h2>
      <div class="prose text-[15.5px] text-ink-500 max-w-none">
        <p>At <?= e($b['legal_name']) ?>, we respect your privacy and are committed to protecting the personal information you share with us. Information such as your name, phone number, email address, location, property requirements or other details submitted through our website may be collected when you make an enquiry or request information about our real estate services.</p>

        <p>Your information is used only for legitimate business purposes, including responding to your enquiry, providing information about properties and services, scheduling appointments, and communicating with you regarding your request. We do not sell, rent or misuse your personal information. We take reasonable technical and organizational measures to protect your information from unauthorized access, disclosure, alteration or misuse.</p>

        <p>Our website may use cookies, analytics and advertising technologies such as Google Ads and Google Analytics to understand website usage, measure advertising performance and improve our services. We may share limited information with trusted service providers where necessary to operate our website, manage enquiries or provide requested services. By submitting your information through our website, you consent to its collection and use for the purposes described above. You may contact us at any time to request correction, deletion or opt-out from promotional communications.</p>
      </div>

      <div class="mt-8 p-6 bg-ivory-200 border border-line rounded-[3px]">
        <p class="eyebrow text-gold-700">Contact</p>
        <dl class="mt-4 space-y-2.5 text-[14.5px]">
          <div class="flex flex-wrap gap-x-3">
            <dt class="text-ink-500 w-28 shrink-0">Email</dt>
            <dd><a href="mailto:<?= e($b['email']) ?>" class="font-semibold border-b border-gold hover:text-gold-700 break-all"><?= e($b['email']) ?></a></dd>
          </div>
          <div class="flex flex-wrap gap-x-3">
            <dt class="text-ink-500 w-28 shrink-0">Phone</dt>
            <dd><a href="tel:+<?= e($b['phone_raw']) ?>" class="font-semibold border-b border-gold hover:text-gold-700"><?= e($b['phone']) ?></a></dd>
          </div>
          <div class="flex flex-wrap gap-x-3">
            <dt class="text-ink-500 w-28 shrink-0">Address</dt>
            <dd><?= e($b['address']) ?></dd>
          </div>
        </dl>
      </div>
    </section>

    <!-- -------------------------------------------------- Terms ------- -->
    <section id="terms" class="mt-16 scroll-mt-8">
      <h2 class="display text-[28px] pb-4 border-b-2 border-gold">Terms &amp; Conditions</h2>
      <div class="prose text-[15.5px] text-ink-500 max-w-none">
        <p><?= e($n['disclaimer']) ?></p>

        <p><span class="text-ink font-semibold">Channel partner status.</span> <?= e($b['legal_name']) ?> (brand: <?= e($b['name']) ?>) operates this website as an <?= e($b['role']) ?> for <?= e($p['name']) ?>. We are not the developer, and we do not represent ourselves as officials of <?= e($p['developer']) ?> Limited. GSTIN: <?= e($b['gstin']) ?>.</p>

        <p><span class="text-ink font-semibold">Project information.</span> The project is registered with the Haryana Real Estate Regulatory Authority under <?= e($p['rera']) ?>, dated <?= e($p['rera_date']) ?>. Registration details can be verified at <a href="<?= e($p['rera_url']) ?>" target="_blank" rel="noopener nofollow" class="border-b border-gold hover:text-gold-700">www.haryanarera.gov.in</a>. Prospective purchasers should independently verify all project details before making a booking decision.</p>

        <p><span class="text-ink font-semibold">Pricing.</span> Prices start at <?= e($p['price_from']) ?>*. <?= e($n['price_note']) ?> Prices are exclusive of applicable taxes and statutory charges.</p>

        <p><span class="text-ink font-semibold">Imagery.</span> <?= e($n['image_note']) ?> Floor plans, layouts and specifications shown are indicative and subject to change.</p>

        <p><span class="text-ink font-semibold">Communication consent.</span> By submitting an enquiry through this website, you consent to receive calls, SMS, WhatsApp messages and email from <?= e($b['legal_name']) ?> and its authorised representatives regarding this project, overriding any DNC or NDNC registration. You may opt out of promotional communication at any time by writing to <a href="mailto:<?= e($b['email']) ?>" class="border-b border-gold hover:text-gold-700 break-all"><?= e($b['email']) ?></a>.</p>

        <p><span class="text-ink font-semibold">Trademarks.</span> All trademarks, logos and brand names belong to their respective owners and are used here only in reference to <?= e($p['developer']) ?>.</p>
      </div>
    </section>

    <a href="index.php" class="inline-flex items-center gap-2 text-[14px] font-semibold mt-14 border-b-2 border-gold pb-1 hover:text-gold-700 transition-colors">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 12H5m6 7-7-7 7-7"/></svg>
      Back to the project
    </a>
  </div>
</main>

<footer class="bg-ink-800 text-ivory/50 py-10 border-t border-white/[.07]">
  <div class="max-w-8xl mx-auto px-5 sm:px-8 text-[11.5px] leading-relaxed">
    &copy; <?= date('Y') ?> <?= e($b['legal_name']) ?>. All rights reserved. &middot; <?= e($b['website']) ?>
  </div>
</footer>
</body>
</html>
