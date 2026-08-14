<?php
/**
 * Post-submission page. On Netlify every form redirects here; locally the PHP
 * handler shows an inline flash instead, so this page is reachable either way.
 */
require_once __DIR__ . '/helpers.php';
$C = require __DIR__ . '/config.php';
$b = $C['brand']; $p = $C['project'];
?>
<!DOCTYPE html>
<html lang="en-IN" class="scroll-smooth">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Thank you — <?= e($p['name']) ?></title>
<meta name="description" content="Your request has been received. A senior relationship manager will call you within 30 minutes.">
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
  fontFamily: { display:['Fraunces','serif'], sans:['"Plus Jakarta Sans"','system-ui','sans-serif'] } } } }
</script>
<style>
  body{-webkit-font-smoothing:antialiased}
  .display{font-family:'Fraunces',serif;font-variation-settings:"SOFT" 0,"WONK" 1}
  .eyebrow{font-size:.6875rem;letter-spacing:.22em;text-transform:uppercase;font-weight:600}
  .btn{display:inline-flex;align-items:center;justify-content:center;gap:.55rem;font-weight:600;transition:.35s cubic-bezier(.16,1,.3,1)}
  .btn-gold{background:#F5B301;color:#0E0E10}
  .btn-gold:hover{background:#FFD34E;transform:translateY(-2px)}
  ::selection{background:#F5B301;color:#0E0E10}
</style>
</head>
<body class="bg-ink text-ivory font-sans min-h-screen flex flex-col">

<header class="px-5 sm:px-8 py-6">
  <a href="index.html" aria-label="<?= e($b['name']) ?> — home">
    <img src="<?= e(logo()) ?>" alt="<?= e($b['name']) ?> — <?= e($b['tagline']) ?>" width="393" height="103" class="h-10 w-auto">
  </a>
</header>

<main class="flex-1 grid place-items-center px-5 sm:px-8 py-12">
  <div class="w-full max-w-2xl text-center">

    <div class="mx-auto w-16 h-16 rounded-full bg-gold grid place-items-center">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#0E0E10" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg>
    </div>

    <p class="eyebrow text-gold mt-8">Request received</p>
    <h1 class="display font-light text-[clamp(2.2rem,6vw,3.6rem)] leading-[1.05] mt-4">
      Thank you. We’ll call you<br><em class="not-italic text-gold">within 30 minutes.</em>
    </h1>
    <p class="text-[15.5px] text-ivory/60 leading-relaxed mt-6 max-w-lg mx-auto">
      A senior relationship manager is preparing your cost sheet, payment plan and the current unit-availability chart for <?= e($p['name']) ?>. Calls go out between 10&nbsp;AM and 8&nbsp;PM IST.
    </p>

    <div class="mt-10 flex flex-wrap justify-center gap-3.5">
      <a href="https://wa.me/<?= e($b['whatsapp']) ?>" target="_blank" rel="noopener" class="btn btn-gold h-12 px-7 rounded-full text-[14px]">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2Zm5.4 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .1-1.7-.1a13 13 0 0 1-5.6-4.9c-.4-.6-1-1.5-1-2.9 0-1.3.7-2 1-2.3.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.4 0 .6l-.4.5-.3.4c-.1.1-.2.3 0 .6.2.3.7 1.2 1.5 1.9 1 .9 1.8 1.2 2.1 1.3.2.1.4.1.6-.1l.8-1c.2-.2.3-.2.6-.1l2 1c.2.1.4.2.4.3.1.2.1.8-.1 1.4Z"/></svg>
        Chat on WhatsApp
      </a>
      <a href="tel:+<?= e($b['phone_raw']) ?>"
         class="btn h-12 px-7 rounded-full text-[14px] border border-ivory/25 hover:bg-ivory hover:text-ink">Call <?= e($b['phone']) ?></a>
    </div>

    <div class="mt-12 pt-8 border-t border-white/10 grid sm:grid-cols-3 gap-6 text-left">
      <?php
      $next = [
        ['Prefer to talk now?', '<a class="text-gold hover:underline" href="tel:+' . e($b['phone_raw']) . '">' . e($b['phone']) . '</a>'],
        ['Visit the site', 'All days, 10:00 – 19:00. Complimentary pick-up across Delhi NCR.'],
        ['Verify the project', '<a class="text-gold hover:underline" href="' . e($p['rera_url']) . '" target="_blank" rel="noopener nofollow">HARERA ' . e($p['rera']) . '</a>'],
      ];
      foreach ($next as $n): ?>
        <div>
          <p class="eyebrow text-ivory/45"><?= e($n[0]) ?></p>
          <p class="text-[13.5px] text-ivory/75 mt-2.5 leading-relaxed"><?= $n[1] ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <a href="index.html" class="inline-flex items-center gap-2 text-[13.5px] text-ivory/50 hover:text-gold transition-colors mt-12">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 12H5m6 7-7-7 7-7"/></svg>
      Back to the project
    </a>
  </div>
</main>

<footer class="px-5 sm:px-8 py-8 text-center text-[11.5px] text-ivory/30">
  © <?= date('Y') ?> <?= e($b['legal_name']) ?>. All rights reserved.
</footer>
</body>
</html>
