<?php
require __DIR__ . '/lead-handler.php';
$C = require __DIR__ . '/config.php';

require_once __DIR__ . '/helpers.php';

/* Schematic unit plans — [x, y, w, h, label] on a 120 × 90 canvas */
$PLAN_SHAPES = [
    '3 BHK' => [
        [3,3,60,40,'Living & Dining'], [3,45,60,10,'Deck'],
        [3,57,38,30,'Master Bedroom'], [43,57,20,30,'Bath'],
        [65,3,52,22,'Kitchen'], [65,27,52,10,'Utility'],
        [65,39,52,22,'Bedroom 2'], [65,63,34,24,'Bedroom 3'], [101,63,16,24,'Bath 2'],
    ],
    '3 BHK + Servant' => [
        [3,3,60,38,'Living & Dining'], [3,43,60,10,'Deck'],
        [3,55,38,32,'Master Bedroom'], [43,55,20,32,'Bath'],
        [65,3,34,20,'Kitchen'], [101,3,16,20,'Servant'],
        [65,25,52,22,'Bedroom 2'], [65,49,52,22,'Bedroom 3'], [65,73,52,14,'Bath 2'],
    ],
];

function render_plan($rooms) {
    $svg  = '<svg viewBox="0 0 120 90" class="w-full h-auto" aria-hidden="true">';
    $svg .= '<rect x="0.5" y="0.5" width="119" height="89" rx="2" fill="none" stroke="currentColor" stroke-width="1.1" opacity=".85"/>';
    foreach ($rooms as $r) {
        [$x, $y, $w, $h, $label] = $r;
        $svg .= sprintf(
            '<rect x="%s" y="%s" width="%s" height="%s" rx="1" fill="currentColor" fill-opacity=".045" stroke="currentColor" stroke-width=".5" stroke-opacity=".55"/>',
            $x, $y, $w, $h
        );
        $svg .= sprintf(
            '<text x="%s" y="%s" text-anchor="middle" font-size="3.4" letter-spacing=".12" fill="currentColor" fill-opacity=".72">%s</text>',
            $x + $w / 2, $y + $h / 2 + 1.2, e(strtoupper($label))
        );
    }
    return $svg . '</svg>';
}

$navItems = [
    'overview'  => 'Overview',
    'plans'     => 'Layout Plan',
    'price'     => 'Price',
    'gallery'   => 'Gallery',
    'amenities' => 'Amenities',
    'location'  => 'Location Advantages',
    'map'       => 'Map',
    'faq'       => 'FAQ',
];

$b = $C['brand']; $p = $C['project']; $seo = $C['seo'];
?>
<!DOCTYPE html>
<html lang="en-IN" class="scroll-smooth">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<!-- Reveal animations only arm when JS is alive; without it everything is visible. -->
<script>document.documentElement.classList.add('js')</script>
<title><?= e($seo['title']) ?></title>
<meta name="description" content="<?= e($seo['desc']) ?>">
<meta name="keywords" content="<?= e($seo['keywords']) ?>">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
<meta name="theme-color" content="#0E0E10">
<meta name="author" content="<?= e($b['legal_name']) ?>">
<link rel="canonical" href="<?= e($seo['url']) ?>">

<!-- Open Graph / Twitter -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($b['name']) ?>">
<meta property="og:title" content="<?= e($seo['title']) ?>">
<meta property="og:description" content="<?= e($seo['desc']) ?>">
<meta property="og:url" content="<?= e($seo['url']) ?>">
<meta property="og:image" content="<?= e($seo['og']) ?>">
<meta property="og:locale" content="en_IN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($seo['title']) ?>">
<meta name="twitter:description" content="<?= e($seo['desc']) ?>">
<meta name="twitter:image" content="<?= e($seo['og']) ?>">

<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='7' fill='%230E0E10'/><path d='M5 25V14l5.5-3.2V25zM12 25V8l7-4.5V25zM20.5 25v-9.5L27 19v6z' fill='%23F5B301'/></svg>">
<link rel="apple-touch-icon" href="assets/img/logo/ck-technologies.png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..700;1,9..144,300..500&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="preload" as="image" href="<?= e(u('hero')) ?>" fetchpriority="high">

<script src="https://cdn.tailwindcss.com?plugins=aspect-ratio"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        ink:   { DEFAULT:'#0E0E10', 800:'#17171B', 700:'#26262C', 500:'#5B5B63' },
        ivory: { DEFAULT:'#FBF9F4', 200:'#F4F0E7', 300:'#EBE5D8' },
        line:  '#E3DCCC',
        gold:  { DEFAULT:'#F5B301', 300:'#FFD34E', 500:'#F5B301', 600:'#D99B00', 700:'#A97800' },
      },
      fontFamily: {
        display: ['Fraunces','ui-serif','Georgia','serif'],
        sans:    ['"Plus Jakarta Sans"','ui-sans-serif','system-ui','sans-serif'],
      },
      letterSpacing: { tightest:'-.045em' },
      maxWidth: { '8xl':'88rem' },
    }
  }
}
</script>

<style>
  :root { --gold:#F5B301; --line:#E3DCCC; }
  body{ -webkit-font-smoothing:antialiased; text-rendering:optimizeLegibility; }
  ::selection{ background:var(--gold); color:#0E0E10; }

  /* Editorial display treatment */
  .display{ font-family:'Fraunces',serif; font-optical-sizing:auto; font-variation-settings:"SOFT" 0,"WONK" 1; }

  /* Fine paper grain — sits above flat fills, never above text */
  .grain::after{
    content:''; position:absolute; inset:0; pointer-events:none; opacity:.5; mix-blend-mode:multiply;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='3'/%3E%3C/filter%3E%3Crect width='160' height='160' filter='url(%23n)' opacity='.28'/%3E%3C/svg%3E");
  }

  /* Scroll reveal — scoped to .js so content is never hidden without JS */
  .js .rv{ opacity:0; transform:translateY(22px); transition:opacity .9s cubic-bezier(.16,1,.3,1), transform .9s cubic-bezier(.16,1,.3,1); }
  .js .rv.in{ opacity:1; transform:none; }
  .rv-d1{ transition-delay:.08s } .rv-d2{ transition-delay:.16s } .rv-d3{ transition-delay:.24s } .rv-d4{ transition-delay:.32s }

  /* Image mask reveal */
  .js .imgrv{ clip-path:inset(0 0 100% 0); transition:clip-path 1.1s cubic-bezier(.16,1,.3,1); }
  .js .imgrv.in{ clip-path:inset(0 0 0 0); }

  @media (prefers-reduced-motion:reduce){
    .js .rv, .js .imgrv{ opacity:1; transform:none; clip-path:none; transition:none }
  }

  /* Header scroll state.
     Defined here, NOT as Tailwind classes toggled from JS: the Play CDN only
     generates utilities it can see in the markup, so a class that exists only
     inside a JS string produces no CSS — the bar would stay transparent and
     its light text would disappear over the ivory sections. */
  #hdr{ border-bottom:1px solid transparent;
        transition:background-color .45s ease, border-color .45s ease, backdrop-filter .45s ease; }
  #hdr.solid{ background-color:rgba(14,14,16,.94); backdrop-filter:blur(16px);
              -webkit-backdrop-filter:blur(16px); border-bottom-color:rgba(255,255,255,.10); }
  @supports not (backdrop-filter:blur(2px)){ #hdr.solid{ background-color:rgba(14,14,16,.985) } }

  /* Tabs (layout plans + amenities).
     State lives in one .is-active class rather than a pile of utilities toggled
     from JS: a tab that starts inactive keeps its hover:text-ink utility forever,
     so once JS made it active (black) the hover rule painted dark text on a dark
     tab and the label vanished. */
  .tab{ background:transparent; border:1px solid var(--line); color:#5B5B63;
        transition:background-color .3s ease, border-color .3s ease, color .3s ease; }
  .tab:hover{ border-color:#0E0E10; color:#0E0E10; }
  .tab.is-active,
  .tab.is-active:hover{ background:#0E0E10; border-color:#0E0E10; color:#FBF9F4; }
  .tab .tab-count{ opacity:.55 }
  .tab.is-active .tab-count{ opacity:.7 }

  .rule{ height:1px; background:linear-gradient(90deg,var(--gold),rgba(245,179,1,0)); }
  .eyebrow{ font-size:.6875rem; letter-spacing:.22em; text-transform:uppercase; font-weight:600; }

  /* Underline nav */
  .nav-a{ position:relative; }
  .nav-a::after{ content:''; position:absolute; left:0; bottom:-5px; height:1.5px; width:0; background:var(--gold); transition:width .35s cubic-bezier(.16,1,.3,1); }
  .nav-a:hover::after, .nav-a.active::after{ width:100%; }

  /* Inputs */
  .fld{ width:100%; background:transparent; border:0; border-bottom:1px solid rgba(255,255,255,.22); padding:.65rem 0; color:#fff; font-size:.9375rem; outline:none; transition:border-color .3s; }
  .fld::placeholder{ color:rgba(255,255,255,.42) }
  .fld:focus{ border-color:var(--gold) }
  .fld-l{ border-bottom-color:rgba(14,14,16,.16); color:#0E0E10 }
  .fld-l::placeholder{ color:rgba(14,14,16,.4) }
  select.fld option{ color:#0E0E10 }

  /* Buttons */
  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:.55rem; font-weight:600; letter-spacing:.02em; transition:.35s cubic-bezier(.16,1,.3,1); }
  .btn-gold{ background:var(--gold); color:#0E0E10 }
  .btn-gold:hover{ background:#FFD34E; transform:translateY(-2px); box-shadow:0 14px 34px -12px rgba(245,179,1,.75) }
  .btn-ink{ background:#0E0E10; color:#fff }
  .btn-ink:hover{ background:#26262C; transform:translateY(-2px) }
  .btn-ghost{ border:1px solid rgba(14,14,16,.18) }
  .btn-ghost:hover{ border-color:#0E0E10; background:#0E0E10; color:#fff }

  /* Marquee */
  @keyframes slide{ to{ transform:translateX(-50%) } }
  .marquee{ animation:slide 34s linear infinite }
  .marquee:hover{ animation-play-state:paused }

  /* FAQ */
  details > summary{ list-style:none; cursor:pointer }
  details > summary::-webkit-details-marker{ display:none }
  details[open] .faq-ico{ transform:rotate(45deg) }

  /* Hide scrollbar on rails */
  .no-sb::-webkit-scrollbar{ display:none } .no-sb{ scrollbar-width:none }
</style>

<!-- ------------------------------------------------- Structured data -->
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@graph":[
    {
      "@type":"RealEstateAgent",
      "@id":"<?= e($seo['url']) ?>#org",
      "name":"<?= e($b['name']) ?>",
      "legalName":"<?= e($b['legal_name']) ?>",
      "url":"<?= e($seo['url']) ?>",
      "image":"<?= e($seo['og']) ?>",
      "telephone":"<?= e($b['phone']) ?>",
      "email":"<?= e($b['email']) ?>",
      "priceRange":"<?= e($p['price_from']) ?> – <?= e($p['price_upto']) ?>",
      "address":{"@type":"PostalAddress","streetAddress":"<?= e($b['address']) ?>","addressLocality":"<?= e($b['locality']) ?>","addressRegion":"<?= e($b['region']) ?>","postalCode":"<?= e($b['postal']) ?>","addressCountry":"IN"},
      "geo":{"@type":"GeoCoordinates","latitude":"<?= e($b['lat']) ?>","longitude":"<?= e($b['lng']) ?>"},
      "areaServed":"Gurugram, Delhi NCR"
    },
    {
      "@type":"ApartmentComplex",
      "name":"<?= e($p['name']) ?>",
      "url":"<?= e($seo['url']) ?>",
      "image":"<?= e($seo['og']) ?>",
      "description":"<?= e($seo['desc']) ?>",
      "numberOfAccommodationUnits":"820",
      "petsAllowed":true,
      "address":{"@type":"PostalAddress","streetAddress":"<?= e($b['address']) ?>","addressLocality":"<?= e($b['locality']) ?>","addressRegion":"<?= e($b['region']) ?>","postalCode":"<?= e($b['postal']) ?>","addressCountry":"IN"},
      "geo":{"@type":"GeoCoordinates","latitude":"<?= e($b['lat']) ?>","longitude":"<?= e($b['lng']) ?>"},
      "amenityFeature":[<?php
        $af = [];
        foreach ($C['amenities'] as $group) foreach ($group as $a) $af[] = '{"@type":"LocationFeatureSpecification","name":"'.e($a).'","value":true}';
        echo implode(',', array_slice($af, 0, 24));
      ?>],
      "containsPlace":[<?php
        $cp = [];
        foreach ($C['plans'] as $pl) $cp[] = '{"@type":"Apartment","name":"'.e($pl['type']).'","floorSize":{"@type":"QuantitativeValue","value":"'.e(str_replace(',','',$pl['area'])).'","unitCode":"FTK"}}';
        echo implode(',', $cp);
      ?>]
    },
    {
      "@type":"FAQPage",
      "mainEntity":[<?php
        $fq = [];
        foreach ($C['faq'] as $f) $fq[] = '{"@type":"Question","name":"'.e($f[0]).'","acceptedAnswer":{"@type":"Answer","text":"'.e($f[1]).'"}}';
        echo implode(',', $fq);
      ?>]
    },
    {
      "@type":"BreadcrumbList",
      "itemListElement":[
        {"@type":"ListItem","position":1,"name":"Home","item":"<?= e($seo['url']) ?>"},
        {"@type":"ListItem","position":2,"name":"Gurugram","item":"<?= e($seo['url']) ?>#location"},
        {"@type":"ListItem","position":3,"name":"<?= e($p['name']) ?>","item":"<?= e($seo['url']) ?>#overview"}
      ]
    }
  ]
}
</script>
</head>

<body class="bg-ivory text-ink font-sans antialiased">

<!-- ══════════════════════════════════════════════ Announcement ══ -->
<div class="bg-ink text-ivory/70 text-[11px] leading-relaxed">
  <div class="max-w-8xl mx-auto px-5 sm:px-8 py-2.5 text-center">
    <?= e($C['notices']['ticker']) ?>
  </div>
</div>

<!-- ══════════════════════════════════════════════════ Header ══ -->
<header id="hdr" class="sticky top-0 z-50">
  <div class="max-w-8xl mx-auto px-5 sm:px-8">
    <div class="h-[68px] flex items-center justify-between gap-6">

      <!-- Logo -->
      <a href="#top" class="flex items-center gap-3.5 shrink-0" aria-label="<?= e($b['name']) ?> — home">
        <img src="<?= e(logo()) ?>" alt="<?= e($b['legal_name']) ?> — <?= e($b['name']) ?>"
             width="560" height="317" class="h-11 sm:h-[52px] w-auto">
      </a>

      <!-- Desktop nav -->
      <nav class="hidden xl:flex items-center gap-7" aria-label="Primary">
        <?php foreach ($navItems as $id => $label): ?>
          <a href="#<?= e($id) ?>" data-nav="<?= e($id) ?>" class="nav-a js-navlink text-[13.5px] font-medium text-ivory/75 hover:text-ivory transition-colors"><?= e($label) ?></a>
        <?php endforeach; ?>
      </nav>

      <!-- Actions -->
      <div class="flex items-center gap-3">
        <a href="tel:+<?= e($b['phone_raw']) ?>" class="hidden md:flex items-center gap-2 text-[13.5px] font-semibold text-ivory/90 hover:text-gold transition-colors">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
          <?= e($b['phone']) ?>
        </a>
        <button data-modal-open class="btn btn-gold text-[13px] px-5 h-10 rounded-full">Enquire Now</button>
        <button id="burger" class="xl:hidden w-10 h-10 -mr-2 grid place-items-center text-ivory" aria-label="Open menu" aria-expanded="false">
          <svg width="22" height="22" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M3 7h18M3 12h18M3 17h18"/></svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile drawer -->
  <div id="drawer" class="xl:hidden hidden bg-ink border-t border-white/10">
    <nav class="max-w-8xl mx-auto px-5 py-4 grid gap-1" aria-label="Mobile">
      <?php foreach ($navItems as $id => $label): ?>
        <a href="#<?= e($id) ?>" class="js-drawer-link py-2.5 text-ivory/80 hover:text-gold border-b border-white/[.06] text-[15px]"><?= e($label) ?></a>
      <?php endforeach; ?>
      <a href="tel:+<?= e($b['phone_raw']) ?>" class="mt-3 btn btn-gold h-11 rounded-full text-sm">Call <?= e($b['phone']) ?></a>
    </nav>
  </div>
</header>

<main id="top">

<!-- ════════════════════════════════════════════════════ HERO ══ -->
<section class="relative -mt-[68px] min-h-[100svh] flex items-end overflow-hidden bg-ink">
  <img src="<?= e(u('hero')) ?>"
       alt="Indiabulls Sector 104 — residential towers on Dwarka Expressway, Gurugram"
       class="absolute inset-0 w-full h-full object-cover" fetchpriority="high" width="1800" height="1200">
  <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/70 to-ink/45"></div>
  <div class="absolute inset-0 bg-gradient-to-r from-ink/85 via-ink/20 to-transparent"></div>
  <div class="absolute inset-0 grain"></div>

  <div class="relative w-full max-w-8xl mx-auto px-5 sm:px-8 pt-32 pb-14 lg:pb-20">
    <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-end">

      <!-- Copy -->
      <div class="lg:col-span-7 text-ivory">
        <p class="eyebrow text-gold rv in"><?= e($p['eyebrow']) ?></p>
        <div class="rule w-28 mt-4 mb-7"></div>

        <h1 class="display font-light leading-[.95] tracking-tightest text-[clamp(2.6rem,7.2vw,5.6rem)] rv in">
          <?= e($p['headline']) ?><br>
          <em class="not-italic font-normal text-gold"><?= e($p['headline_em']) ?></em>
        </h1>

        <p class="mt-7 max-w-xl text-[15.5px] sm:text-[17px] leading-relaxed text-ivory/70 rv in rv-d1">
          <?= e($p['subline']) ?>
        </p>

        <!-- Key facts -->
        <dl class="mt-9 flex flex-wrap gap-x-10 gap-y-5 rv in rv-d2">
          <?php
          $facts = [
            ['Starting at', $p['price_from'] . '*'],
            ['Possession',  $p['possession']],
            ['Estate',      '17 Acres'],
            ['Open space',  '7 Acres'],
          ];
          foreach ($facts as $f): ?>
            <div>
              <dt class="text-[10.5px] uppercase tracking-[.18em] text-ivory/45 font-semibold"><?= e($f[0]) ?></dt>
              <dd class="display text-2xl sm:text-[28px] mt-1.5 text-ivory"><?= e($f[1]) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>

        <div class="mt-10 flex flex-wrap items-center gap-3.5 rv in rv-d3">
          <a href="#plans" class="btn btn-gold h-12 px-7 rounded-full text-[14px]">
            View Layout Plans
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14m-6-7 7 7-7 7"/></svg>
          </a>
          <a href="https://wa.me/<?= e($b['whatsapp']) ?>?text=<?= rawurlencode('Hi, I would like details for Indiabulls Sector 104, Dwarka Expressway.') ?>" target="_blank" rel="noopener"
             class="btn h-12 px-7 rounded-full text-[14px] border border-ivory/25 text-ivory hover:bg-ivory hover:text-ink">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2Zm5.4 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .1-1.7-.1a13 13 0 0 1-5.6-4.9c-.4-.6-1-1.5-1-2.9 0-1.3.7-2 1-2.3.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.4 0 .6l-.4.5-.3.4c-.1.1-.2.3 0 .6.2.3.7 1.2 1.5 1.9 1 .9 1.8 1.2 2.1 1.3.2.1.4.1.6-.1l.8-1c.2-.2.3-.2.6-.1l2 1c.2.1.4.2.4.3.1.2.1.8-.1 1.4Z"/></svg>
            WhatsApp
          </a>
        </div>

        <p class="mt-7 text-[11px] text-ivory/35 leading-relaxed rv in rv-d4"><?= e($C['notices']['image']) ?></p>
      </div>

      <!-- Hero lead form -->
      <div class="lg:col-span-5 rv in rv-d2" id="enquire">
        <div class="relative bg-ink-800/70 backdrop-blur-xl border border-white/12 rounded-[4px] p-7 sm:p-8 shadow-2xl">
          <div class="absolute -top-px left-8 right-8 h-px bg-gradient-to-r from-transparent via-gold to-transparent"></div>

          <?php if ($FLASH && $FLASH['type'] !== 'brochure'): ?>
            <div class="mb-5 rounded-sm px-4 py-3 text-[13px] <?= $FLASH['ok'] ? 'bg-gold/15 text-gold border border-gold/30' : 'bg-red-500/10 text-red-300 border border-red-400/30' ?>">
              <?= e($FLASH['msg']) ?>
            </div>
          <?php endif; ?>

          <p class="eyebrow text-gold">Instant Callback</p>
          <h2 class="display text-[27px] leading-tight text-ivory mt-2.5">Get price, plans &amp; payment schedule</h2>
          <p class="text-[13px] text-ivory/55 mt-2">Shared by a senior relationship manager — no bots, no spam.</p>

          <form method="post" class="mt-6 grid gap-5" novalidate>
            <input type="hidden" name="form_type" value="enquiry">
            <input type="hidden" name="src" value="hero">
            <input type="text" name="company" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">

            <div>
              <label for="h-name" class="sr-only">Full name</label>
              <input id="h-name" class="fld" type="text" name="name" placeholder="Full name" required autocomplete="name">
            </div>
            <div class="grid grid-cols-[auto_1fr] gap-3 items-end">
              <span class="pb-2.5 text-ivory/55 text-[15px] border-b border-white/20">+91</span>
              <div>
                <label for="h-phone" class="sr-only">Mobile number</label>
                <input id="h-phone" class="fld" type="tel" name="phone" placeholder="Mobile number" required inputmode="numeric" autocomplete="tel">
              </div>
            </div>
            <div>
              <label for="h-email" class="sr-only">Email</label>
              <input id="h-email" class="fld" type="email" name="email" placeholder="Email (optional)" autocomplete="email">
            </div>
            <button class="btn btn-gold h-12 rounded-full text-[14px] mt-1">
              Get Instant Callback
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14m-6-7 7 7-7 7"/></svg>
            </button>

            <?= consent_note($C, true) ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═════════════════════════════════════════ Trust marquee ══ -->
<section class="bg-ink text-ivory/50 border-y border-white/[.07] overflow-hidden">
  <div class="flex whitespace-nowrap py-4">
    <ul class="marquee flex shrink-0 items-center gap-12 pr-12 text-[12px] tracking-[.14em] uppercase font-medium">
      <?php
      $ticker = ['HARERA Registered', '17-Acre Gated Estate', '7 Acres of Open Green', '29+ Amenities',
                 '30:70 Payment Plan', 'Approved by SBI · HDFC', '4 Towers', 'Possession Oct 2030', '24×7 Security'];
      for ($i = 0; $i < 2; $i++):
        foreach ($ticker as $t): ?>
          <li class="flex items-center gap-12"><span><?= e($t) ?></span><span class="w-1 h-1 rounded-full bg-gold/70"></span></li>
      <?php endforeach;
      endfor; ?>
    </ul>
  </div>
</section>

<!-- ════════════════════════════════════════════════ OVERVIEW ══ -->
<section id="overview" class="relative scroll-mt-20 py-20 sm:py-28 lg:py-32">
  <div class="max-w-8xl mx-auto px-5 sm:px-8">
    <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">

      <div class="lg:col-span-5">
        <p class="eyebrow text-gold-700 rv">01 — Overview</p>
        <div class="rule w-20 mt-3.5 mb-7 rv"></div>
        <h2 class="display font-light text-[clamp(2rem,4.6vw,3.4rem)] leading-[1.03] tracking-tightest rv">
          Seventeen acres<br>designed for<br><em class="not-italic text-gold-600">elevated living.</em>
        </h2>
        <div class="mt-7 space-y-5 text-[15.5px] leading-relaxed text-ink-500 max-w-lg rv rv-d1">
          <p>Indiabulls brings together spacious luxury residences, landscaped surroundings and a premium lifestyle on Dwarka Expressway — creating a home designed for families who value space, comfort and connectivity.</p>
        </div>

        <div class="mt-9 grid grid-cols-2 gap-x-8 gap-y-6 max-w-md rv rv-d2">
          <?php
          $usps = [
            ['Premium residences',  'Spacious 3 BHK homes'],
            ['30:70 payment plan',  'Flexible payment structure'],
            ['Premium clubhouse',   'Lifestyle amenities for everyday living'],
            ['Dwarka Expressway',   'A well-connected Gurugram address'],
          ];
          foreach ($usps as $x): ?>
            <div class="border-t border-line pt-4">
              <p class="font-semibold text-[14.5px]"><?= $x[0] ?></p>
              <p class="text-[13px] text-ink-500 mt-1"><?= e($x[1]) ?></p>
            </div>
          <?php endforeach; ?>
        </div>

        <a href="#plans" class="btn btn-ghost mt-10 h-12 px-7 rounded-full text-[14px] rv rv-d3">
          Explore the residences
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14m-6-7 7 7-7 7"/></svg>
        </a>
      </div>

      <div class="lg:col-span-7">
        <div class="grid grid-cols-12 gap-4 sm:gap-5">
          <figure class="col-span-12 sm:col-span-7 overflow-hidden rounded-[3px] imgrv">
            <img src="<?= e(u('living')) ?>" alt="Light-filled living room in a 3 BHK residence at Indiabulls Sector 104, Gurugram"
                 loading="lazy" width="900" height="1100" class="w-full h-[300px] sm:h-[440px] object-cover hover:scale-[1.04] transition-transform duration-[1.2s]">
          </figure>
          <figure class="col-span-12 sm:col-span-5 overflow-hidden rounded-[3px] imgrv rv-d1">
            <img src="<?= e(u('bedroom')) ?>" alt="Primary bedroom with floor-to-ceiling glazing"
                 loading="lazy" width="700" height="900" class="w-full h-[220px] sm:h-[440px] object-cover hover:scale-[1.04] transition-transform duration-[1.2s]">
          </figure>
          <figure class="col-span-12 overflow-hidden rounded-[3px] imgrv rv-d2">
            <img src="<?= e(u('pool')) ?>" alt="The swimming pool at Indiabulls Sector 104, Gurugram"
                 loading="lazy" width="1400" height="700" class="w-full h-[240px] sm:h-[320px] object-cover hover:scale-[1.04] transition-transform duration-[1.2s]">
          </figure>
        </div>

        <p class="text-[11.5px] text-ink-500/80 mt-4 leading-relaxed"><?= e($C['notices']['image']) ?></p>

        <!-- Stat counters -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-px bg-line mt-5 rounded-[3px] overflow-hidden">
          <?php foreach ($C['stats'] as $i => $s): ?>
            <div class="bg-ivory px-5 py-6 rv rv-d<?= $i + 1 ?>">
              <p class="display text-[34px] leading-none">
                <span class="js-count" data-to="<?= e($s['value']) ?>" data-dec="<?= e($s['decimals']) ?>">0</span><span class="text-gold-600"><?= e($s['suffix']) ?></span>
              </p>
              <p class="text-[12px] text-ink-500 mt-2.5 leading-snug"><?= e($s['label']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═════════════════════════════════════════════ LAYOUT PLAN ══ -->
<section id="plans" class="scroll-mt-20 bg-ivory-200 border-y border-line py-20 sm:py-28">
  <div class="max-w-8xl mx-auto px-5 sm:px-8">

    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12">
      <div>
        <p class="eyebrow text-gold-700 rv">02 — Layout Plan</p>
        <div class="rule w-20 mt-3.5 mb-6 rv"></div>
        <h2 class="display font-light text-[clamp(2rem,4.6vw,3.4rem)] leading-[1.03] tracking-tightest rv">
          Spacious plans.<br>No wasted <em class="not-italic text-gold-600">space.</em>
        </h2>
      </div>
      <p class="max-w-sm text-[15px] text-ink-500 leading-relaxed rv rv-d1">
        Every layout is a corner unit with a dedicated service core, so no bedroom shares a wall with a lift or a duct. Select a plan to see the arrangement.
      </p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 overflow-x-auto no-sb pb-2 -mx-1 px-1 rv">
      <?php foreach ($C['plans'] as $i => $pl): ?>
        <button data-plan-tab="<?= $i ?>" type="button" aria-pressed="<?= $i === 0 ? 'true' : 'false' ?>"
          class="js-plan-tab tab shrink-0 h-11 px-5 rounded-full text-[13.5px] font-semibold <?= $i === 0 ? 'is-active' : '' ?>">
          <?= e($pl['type']) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Panels -->
    <div class="mt-8">
      <?php foreach ($C['plans'] as $i => $pl): ?>
        <div data-plan-panel="<?= $i ?>" class="js-plan-panel <?= $i === 0 ? '' : 'hidden' ?>">
          <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center bg-ivory border border-line rounded-[3px] p-6 sm:p-10">

            <!-- Plan is blurred until the visitor identifies themselves — the
                 floor plan is the strongest thing this page has to trade. -->
            <div class="lg:col-span-7 min-w-0">
              <div class="relative overflow-hidden rounded-[3px] border border-line bg-ivory-200/60">
                <div class="js-plan-art text-ink px-4 py-6 sm:px-8 transition-all duration-700"
                     style="filter:blur(9px); transform:scale(1.03); user-select:none" aria-hidden="true">
                  <?= render_plan($PLAN_SHAPES[$pl['type']]) ?>
                </div>

                <!-- Unlock overlay -->
                <div class="js-plan-gate absolute inset-0 grid place-items-center p-5 sm:p-8
                            bg-gradient-to-b from-ivory/70 via-ivory/85 to-ivory">
                  <div class="w-full max-w-sm text-center">
                    <span class="inline-grid place-items-center w-11 h-11 rounded-full bg-ink text-gold mb-4">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <rect x="4" y="10.5" width="16" height="10" rx="2"/><path d="M8 10.5V7a4 4 0 0 1 8 0"/>
                      </svg>
                    </span>
                    <h4 class="display text-[21px] sm:text-[24px] leading-tight">Unlock the <?= e($pl['type']) ?> floor plan</h4>

                    <form method="post" class="mt-5 grid gap-3.5 text-left" novalidate>
                      <input type="hidden" name="form_type" value="enquiry">
                      <input type="hidden" name="src" value="floorplan-<?= e($pl['type']) ?>">
                      <input type="hidden" name="config" value="<?= e($pl['type']) ?>">
                      <input type="text" name="company" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">

                      <label for="fp-name-<?= $i ?>" class="sr-only">Full name</label>
                      <input id="fp-name-<?= $i ?>" class="fld fld-l" type="text" name="name" placeholder="Full name" required autocomplete="name">

                      <div class="grid grid-cols-[auto_1fr] gap-3 items-end">
                        <span class="pb-2.5 text-ink-500 text-[15px] border-b border-ink/15">+91</span>
                        <div>
                          <label for="fp-phone-<?= $i ?>" class="sr-only">Mobile number</label>
                          <input id="fp-phone-<?= $i ?>" class="fld fld-l" type="tel" name="phone" placeholder="Mobile number" required inputmode="numeric" autocomplete="tel">
                        </div>
                      </div>

                      <button class="btn btn-gold h-11 rounded-full text-[13.5px] mt-1">
                        View floor plan
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14m-6-7 7 7-7 7"/></svg>
                      </button>
                      <?= consent_note($C) ?>
                    </form>
                  </div>
                </div>
              </div>
              <p class="text-center text-[11px] tracking-[.16em] uppercase text-ink-500 mt-5">Indicative schematic · not to scale</p>
            </div>

            <div class="lg:col-span-5 min-w-0">
              <?php if ($pl['tag']): ?>
                <span class="inline-block bg-gold/20 text-gold-700 text-[10.5px] font-bold uppercase tracking-[.16em] px-3 py-1.5 rounded-full mb-4"><?= e($pl['tag']) ?></span>
              <?php endif; ?>
              <h3 class="display text-[34px] leading-tight"><?= e($pl['type']) ?></h3>

              <!-- Headline specs -->
              <div class="grid grid-cols-3 gap-px bg-line mt-6 border border-line rounded-[3px] overflow-hidden">
                <?php
                $specs = [
                  [$pl['area'],  'Sq. Ft Area'],
                  [$pl['beds'],  $pl['beds_label']],
                  [$pl['baths'], $pl['baths_label']],
                ];
                foreach ($specs as $s): ?>
                  <div class="bg-ivory px-3 py-5 text-center">
                    <p class="display text-[28px] leading-none"><?= e($s[0]) ?></p>
                    <p class="text-[11px] text-ink-500 mt-2 leading-snug"><?= e($s[1]) ?></p>
                  </div>
                <?php endforeach; ?>
              </div>

              <p class="mt-6 text-[13px] text-ink-500">Starting at</p>
              <p class="display text-[34px] leading-none mt-1"><?= e($pl['price']) ?></p>

              <div class="mt-7 flex flex-wrap gap-3">
                <button data-modal-open data-modal-config="<?= e($pl['type']) ?>" class="btn btn-ink h-11 px-6 rounded-full text-[13.5px]">Get detailed plan</button>
                <a href="#price" class="btn btn-ghost h-11 px-6 rounded-full text-[13.5px]">See cost sheet</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═════════════════════════════════════════════════════ PRICE ══ -->
<section id="price" class="scroll-mt-20 py-20 sm:py-28">
  <div class="max-w-8xl mx-auto px-5 sm:px-8">

    <div class="max-w-2xl mb-12">
      <p class="eyebrow text-gold-700 rv">03 — Price</p>
      <div class="rule w-20 mt-3.5 mb-6 rv"></div>
      <h2 class="display font-light text-[clamp(2rem,4.6vw,3.4rem)] leading-[1.03] tracking-tightest rv">
        Launch pricing,<br>published <em class="not-italic text-gold-600">openly.</em>
      </h2>
    </div>

    <div class="rv">
      <div class="overflow-x-auto no-sb -mx-5 px-5 sm:mx-0 sm:px-0">
        <table class="w-full min-w-[680px] border-collapse">
          <caption class="sr-only">Price list for Indiabulls Sector 104, Dwarka Expressway Gurugram</caption>
          <thead>
            <tr class="text-left border-y border-ink">
              <th scope="col" class="py-4 pr-4 text-[11px] uppercase tracking-[.18em] font-bold">Configuration</th>
              <th scope="col" class="py-4 px-4 text-[11px] uppercase tracking-[.18em] font-bold">Area</th>
              <th scope="col" class="py-4 px-4 text-[11px] uppercase tracking-[.18em] font-bold">Launch price</th>
              <th scope="col" class="py-4 pl-4 text-right text-[11px] uppercase tracking-[.18em] font-bold">Availability</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($C['plans'] as $i => $pl): ?>
              <tr class="border-b border-line group hover:bg-ivory-200/70 transition-colors">
                <th scope="row" class="py-6 pr-4 text-left">
                  <span class="display text-[21px] font-normal"><?= e($pl['type']) ?></span>
                  <?php if ($pl['tag']): ?><span class="ml-3 align-middle inline-block bg-gold/20 text-gold-700 text-[9.5px] font-bold uppercase tracking-[.14em] px-2.5 py-1 rounded-full"><?= e($pl['tag']) ?></span><?php endif; ?>
                </th>
                <td class="py-6 px-4 text-[15px] text-ink-500"><?= e($pl['area']) ?> sq.ft</td>
                <td class="py-6 px-4 text-[17px] font-semibold"><?= e($pl['price']) ?></td>
                <td class="py-6 pl-4 text-right">
                  <button data-modal-open data-modal-config="<?= e($pl['type']) ?>" class="text-[13.5px] font-semibold text-ink border-b-2 border-gold hover:text-gold-700 transition-colors">Request cost sheet</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-5 mt-10">
      <?php
      $notes = [
        ['Flexible payment plans', '30:70 construction-linked, or a subvention plan.'],
        ['Home loans pre-approved', 'SBI, HDFC funding, doorstep documentation.'],
      ];
      foreach ($notes as $i => $n): ?>
        <div class="border-t-2 border-gold pt-5 rv rv-d<?= $i + 1 ?>">
          <p class="font-semibold text-[15px]"><?= e($n[0]) ?></p>
          <p class="text-[13.5px] text-ink-500 mt-2 leading-relaxed"><?= e($n[1]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ═══════════════════════════════════════════════════ GALLERY ══ -->
<section id="gallery" class="scroll-mt-20 bg-ink text-ivory py-20 sm:py-28 relative">
  <div class="absolute inset-0 grain opacity-30"></div>
  <div class="relative max-w-8xl mx-auto px-5 sm:px-8">

    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-11">
      <div>
        <p class="eyebrow text-gold rv">04 — Gallery</p>
        <div class="rule w-20 mt-3.5 mb-6 rv"></div>
        <h2 class="display font-light text-[clamp(2rem,4.6vw,3.4rem)] leading-[1.03] tracking-tightest rv">
          Walk through it,<br><em class="not-italic text-gold">frame by frame.</em>
        </h2>
      </div>
      <p class="text-[13px] text-ivory/45 rv rv-d1 max-w-xs"><?= e($C['notices']['gallery']) ?></p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 auto-rows-[170px] sm:auto-rows-[210px] gap-3 sm:gap-4">
      <?php foreach ($C['gallery'] as $i => $g): ?>
        <button class="js-lb group relative overflow-hidden rounded-[3px] <?= e($g['span']) ?> rv rv-d<?= min(4, $i % 4 + 1) ?>"
                data-full="<?= e(u($g['id'])) ?>" data-cap="<?= e($g['cap']) ?>" aria-label="Enlarge: <?= e($g['cap']) ?>">
          <img src="<?= e(u($g['id'])) ?>" alt="<?= e($g['cap']) ?> — Indiabulls Sector 104, Gurugram" loading="lazy" width="800" height="600"
               class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1.1s] group-hover:scale-[1.07]">
          <span class="absolute inset-0 bg-gradient-to-t from-ink/85 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
          <span class="absolute left-4 bottom-3.5 right-4 text-left text-[12.5px] font-medium text-ivory translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-500"><?= e($g['cap']) ?></span>
          <span class="absolute right-3.5 top-3.5 w-8 h-8 grid place-items-center rounded-full bg-gold text-ink scale-0 group-hover:scale-100 transition-transform duration-500">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
          </span>
        </button>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═════════════════════════════════════════════════ AMENITIES ══ -->
<section id="amenities" class="scroll-mt-20 py-20 sm:py-28">
  <div class="max-w-8xl mx-auto px-5 sm:px-8">

    <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-end mb-12">
      <div class="lg:col-span-7">
        <p class="eyebrow text-gold-700 rv">05 — Amenities</p>
        <div class="rule w-20 mt-3.5 mb-6 rv"></div>
        <h2 class="display font-light text-[clamp(2rem,4.6vw,3.4rem)] leading-[1.03] tracking-tightest rv">
          Reasons<br>to stay <em class="not-italic text-gold-600">home.</em>
        </h2>
      </div>
      <p class="lg:col-span-5 text-[15px] text-ink-500 leading-relaxed rv rv-d1">
        A premium clubhouse anchors the estate, wrapped by courts, gardens and open green. Seven of the seventeen acres are left to landscape.
      </p>
    </div>

    <!-- items-start stops the grid stretching the short column to match the tall one -->
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-start">

      <!-- Category rail.
           A grid, not a horizontal scroller: on a phone all six categories stay
           visible instead of hiding off-screen. min-w-0 is load-bearing either
           way — grid items default to min-width:auto, so wide inline content
           sizes the track to its full min-content width (~862px here) and
           stretches the whole page rather than wrapping. -->
      <div class="lg:col-span-4 min-w-0 lg:sticky lg:top-24">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-1 gap-2 rv">
          <?php $ai = 0; foreach ($C['amenities'] as $cat => $items): ?>
            <button data-am-tab="<?= $ai ?>" type="button" aria-pressed="<?= $ai === 0 ? 'true' : 'false' ?>"
              class="js-am-tab tab w-full min-w-0 text-left px-4 sm:px-5 h-14 rounded-[3px] flex items-center justify-between gap-3 <?= $ai === 0 ? 'is-active' : '' ?>">
              <span class="display text-[17px] sm:text-[19px] truncate"><?= e($cat) ?></span>
              <span class="tab-count text-[11px] tabular-nums shrink-0"><?= str_pad((string)count($items), 2, '0', STR_PAD_LEFT) ?></span>
            </button>
          <?php $ai++; endforeach; ?>
        </div>
      </div>

      <!-- Lists — min-height keeps the panel from jumping between categories -->
      <div class="lg:col-span-8 min-w-0 lg:min-h-[440px]">
        <?php $ai = 0; foreach ($C['amenities'] as $cat => $items): ?>
          <div data-am-panel="<?= $ai ?>" class="js-am-panel <?= $ai === 0 ? '' : 'hidden' ?>">
            <div class="flex items-baseline justify-between gap-6 pb-5 border-b-2 border-gold">
              <h3 class="display text-[24px]"><?= e($cat) ?></h3>
              <span class="text-[11px] uppercase tracking-[.18em] text-ink-500 font-semibold whitespace-nowrap"><?= count($items) ?> features</span>
            </div>
            <?php if (!empty($C['amenity_intros'][$cat])): ?>
              <p class="text-[14.5px] text-ink-500 leading-relaxed mt-5 max-w-xl"><?= e($C['amenity_intros'][$cat]) ?></p>
            <?php endif; ?>
            <ul class="grid sm:grid-cols-2 gap-x-12 mt-3">
              <?php foreach ($items as $k => $item): ?>
                <li class="flex items-center gap-4 py-[18px] border-b border-line">
                  <span class="text-[10.5px] tabular-nums text-gold-600 font-bold w-6 shrink-0"><?= str_pad((string)($k + 1), 2, '0', STR_PAD_LEFT) ?></span>
                  <span class="text-[15px]"><?= e($item) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php $ai++; endforeach; ?>
      </div>
    </div>

    <!-- Full-width image strip closes the section instead of trailing whitespace -->
    <div class="grid sm:grid-cols-3 gap-4 sm:gap-5 mt-14 sm:mt-16">
      <?php
      $strip = [
        ['gym',     'The gymnasium'],
        ['lounge',  'Clubhouse lounge'],
        ['kitchen', 'Chef’s kitchen'],
      ];
      foreach ($strip as $i => $s): ?>
        <figure class="relative overflow-hidden rounded-[3px] group imgrv rv-d<?= $i + 1 ?>">
          <img src="<?= e(u($s[0])) ?>" alt="<?= e($s[1]) ?> at Indiabulls Sector 104, Gurugram"
               loading="lazy" width="800" height="600"
               class="w-full h-[220px] sm:h-[260px] object-cover transition-transform duration-[1.2s] group-hover:scale-[1.05]">
          <figcaption class="absolute inset-x-0 bottom-0 p-4 text-ivory text-[12.5px] font-medium bg-gradient-to-t from-ink/85 to-transparent pt-10">
            <?= e($s[1]) ?>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
    <p class="text-[11.5px] text-ink-500/80 mt-4 leading-relaxed"><?= e($C['notices']['image']) ?></p>
  </div>
</section>

<!-- ══════════════════════════════════════ LOCATION ADVANTAGES ══ -->
<section id="location" class="scroll-mt-20 bg-ivory-200 border-y border-line py-20 sm:py-28">
  <div class="max-w-8xl mx-auto px-5 sm:px-8">

    <div class="grid lg:grid-cols-12 gap-10 lg:gap-16">
      <div class="lg:col-span-5">
        <p class="eyebrow text-gold-700 rv">06 — Location Advantages</p>
        <div class="rule w-20 mt-3.5 mb-6 rv"></div>
        <?php $loc = $C['location']; ?>
        <h2 class="display font-light text-[clamp(2rem,4.6vw,3.4rem)] leading-[1.03] tracking-tightest rv">
          <?= e($loc['heading_a']) ?><br><em class="not-italic text-gold-600"><?= e($loc['heading_em']) ?></em>
        </h2>
        <p class="mt-6 text-[15.5px] text-ink-500 leading-relaxed max-w-lg rv rv-d1">
          <?= e($loc['intro']) ?>
        </p>

        <div class="mt-8 p-6 bg-ivory border border-line rounded-[3px] rv rv-d2">
          <p class="eyebrow text-gold-700"><?= e($loc['why_title']) ?></p>
          <p class="text-[14.5px] leading-relaxed text-ink-500 mt-3"><?= e($loc['why']) ?></p>
        </div>
      </div>

      <div class="lg:col-span-7 min-w-0 grid sm:grid-cols-2 gap-x-10 gap-y-10">
        <?php
        $locLists = [
          [$loc['list_title'],    $loc['connectivity']],
          [$loc['schools_title'], $loc['schools']],
        ];
        foreach ($locLists as $li => $block): ?>
          <div class="min-w-0">
            <h3 class="display text-[22px] pb-4 border-b-2 border-gold rv"><?= e($block[0]) ?></h3>
            <ul>
              <?php foreach ($block[1] as $k => $item): ?>
                <li class="flex items-start gap-4 py-[15px] border-b border-line rv rv-d<?= min(4, $k % 4 + 1) ?>">
                  <span class="text-[10.5px] tabular-nums text-gold-600 font-bold w-6 shrink-0 mt-[3px]"><?= str_pad((string)($k + 1), 2, '0', STR_PAD_LEFT) ?></span>
                  <span class="text-[14.5px] leading-snug"><?= e($item) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════ MAP ══ -->
<section id="map" class="scroll-mt-20 relative">
  <div class="grid lg:grid-cols-[1fr_420px]">
    <div class="relative h-[380px] sm:h-[520px] bg-ivory-300">
      <iframe
        src="https://www.google.com/maps?q=<?= e($p['map_query']) ?>&z=14&output=embed"
        title="Map showing Indiabulls Sector 104, Dwarka Expressway, Gurugram"
        class="absolute inset-0 w-full h-full grayscale-[.35] contrast-[1.05]"
        loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="border:0"></iframe>
    </div>

    <div class="bg-ink text-ivory p-8 sm:p-12 flex flex-col justify-center relative">
      <div class="absolute inset-0 grain"></div>
      <div class="relative">
        <p class="eyebrow text-gold">07 — Office address</p>
        <h2 class="display text-[30px] leading-tight mt-3">Talk to us in person</h2>
        <address class="not-italic text-[15px] text-ivory/65 mt-5 leading-relaxed">
          <?= e($b['legal_name']) ?><br><?= e($b['address']) ?>
        </address>
        <dl class="mt-7 space-y-3 text-[14px]">
          <div class="flex gap-3"><dt class="text-ivory/45 w-20 shrink-0">Open</dt><dd>All days · 10:00 – 19:00</dd></div>
          <div class="flex gap-3"><dt class="text-ivory/45 w-20 shrink-0">Call</dt><dd><a class="hover:text-gold" href="tel:+<?= e($b['phone_raw']) ?>"><?= e($b['phone']) ?></a></dd></div>
          <div class="flex gap-3"><dt class="text-ivory/45 w-20 shrink-0">Email</dt><dd><a class="hover:text-gold" href="mailto:<?= e($b['email']) ?>"><?= e($b['email']) ?></a></dd></div>
        </dl>
        <div class="flex flex-wrap gap-3 mt-8">
          <button data-modal-open data-modal-src="site-visit" class="btn btn-gold h-11 px-6 rounded-full text-[13.5px]">Book a site visit</button>
          <a href="https://www.google.com/maps/dir/?api=1&destination=<?= e($p['map_query']) ?>" target="_blank" rel="noopener"
             class="btn h-11 px-6 rounded-full text-[13.5px] border border-ivory/25 text-ivory hover:bg-ivory hover:text-ink">Directions to site</a>
          <a href="https://www.google.com/maps/dir/?api=1&destination=<?= e($b['map_query']) ?>" target="_blank" rel="noopener"
             class="btn h-11 px-6 rounded-full text-[13.5px] border border-ivory/25 text-ivory hover:bg-ivory hover:text-ink">Directions to office</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════ FAQ ══ -->
<section id="faq" class="scroll-mt-20 bg-ivory-200 border-y border-line py-20 sm:py-28">
  <div class="max-w-8xl mx-auto px-5 sm:px-8">
    <div class="grid lg:grid-cols-12 gap-10 lg:gap-16">

      <div class="lg:col-span-4">
        <p class="eyebrow text-gold-700 rv">FAQ</p>
        <div class="rule w-20 mt-3.5 mb-6 rv"></div>
        <h2 class="display font-light text-[clamp(1.8rem,4vw,2.8rem)] leading-[1.05] tracking-tightest rv">
          Answers,<br>before you <em class="not-italic text-gold-600">ask.</em>
        </h2>
        <p class="mt-6 text-[14.5px] text-ink-500 leading-relaxed rv rv-d1">
          Something not covered here? Call <a href="tel:+<?= e($b['phone_raw']) ?>" class="text-ink font-semibold border-b border-gold"><?= e($b['phone']) ?></a> — a real person picks up.
        </p>
      </div>

      <div class="lg:col-span-8 min-w-0">
        <?php foreach ($C['faq'] as $i => $f): ?>
          <details class="group border-b border-line rv rv-d<?= min(4, $i % 4 + 1) ?>" <?= $i === 0 ? 'open' : '' ?>>
            <summary class="flex items-start justify-between gap-6 py-6 select-none">
              <h3 class="display text-[18.5px] sm:text-[21px] font-normal leading-snug pr-4"><?= e($f[0]) ?></h3>
              <span class="faq-ico shrink-0 mt-1 w-8 h-8 grid place-items-center rounded-full border border-line group-hover:border-gold group-hover:bg-gold transition-all duration-300">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
              </span>
            </summary>
            <p class="pb-7 -mt-1 pr-14 text-[15px] leading-relaxed text-ink-500"><?= e($f[1]) ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

</main>

<!-- ═══════════════════════════════════════════════════ FOOTER ══ -->
<footer class="bg-ink-800 text-ivory/60 pt-16 pb-32 lg:pb-10 border-t border-white/[.07]">
  <div class="max-w-8xl mx-auto px-5 sm:px-8">

    <div class="grid md:grid-cols-12 gap-10 lg:gap-12 pb-12 border-b border-white/[.08]">

      <!-- Operator -->
      <div class="md:col-span-4">
        <img src="<?= e(logo()) ?>" alt="<?= e($b['legal_name']) ?> — <?= e($b['name']) ?>"
             width="560" height="317" class="h-16 w-auto" loading="lazy">
        <p class="mt-5 text-[14px] leading-relaxed max-w-sm"><?= e($p['name']) ?>, a 17-acre gated estate of 3 &amp; 3.5 BHK residences on the Dwarka Expressway, Gurugram.</p>

        <p class="eyebrow text-ivory mt-8 mb-4">Company Details</p>
        <dl class="text-[13px] leading-relaxed space-y-2">
          <?php
          $company = [
            ['Legal name',        $b['legal_name']],
            ['Brand name',        $b['name']],
            ['Business role',     $b['role']],
            ['Website operator',  $b['legal_name']],
            ['Registered address',$b['address']],
            ['GSTIN',             $b['gstin']],
          ];
          foreach ($company as $c): ?>
            <div class="flex gap-2">
              <dt class="text-ivory/40 shrink-0 w-[122px]"><?= e($c[0]) ?></dt>
              <dd class="min-w-0"><?= e($c[1]) ?></dd>
            </div>
          <?php endforeach; ?>
          <div class="flex gap-2">
            <dt class="text-ivory/40 shrink-0 w-[122px]">Mail ID</dt>
            <dd class="min-w-0"><a href="mailto:<?= e($b['email']) ?>" class="hover:text-gold transition-colors break-all"><?= e($b['email']) ?></a></dd>
          </div>
        </dl>
      </div>

      <!-- Project details -->
      <div class="md:col-span-5">
        <p class="eyebrow text-ivory mb-4">Project Details</p>
        <dl class="text-[13px] leading-relaxed space-y-2">
          <?php
          $proj = [
            ['Developer name',  $p['developer']],
            ['Project address', $p['address']],
            ['Office address',  $p['dev_office']],
            ['Project status',  $p['status']],
            ['RERA number',     $p['rera']],
            ['Possession date', 'October 2030'],
          ];
          foreach ($proj as $r): ?>
            <div class="flex gap-2">
              <dt class="text-ivory/40 shrink-0 w-[122px]"><?= e($r[0]) ?></dt>
              <dd class="min-w-0"><?= e($r[1]) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>

        <div class="mt-5 p-4 border border-white/10 rounded-[3px]">
          <p class="text-[10.5px] uppercase tracking-[.18em] text-gold font-bold">HRERA Registration</p>
          <p class="text-[12.5px] mt-2"><?= e($p['rera']) ?></p>
          <p class="text-[12px] text-ivory/45 mt-1.5">Date: <?= e($p['rera_date']) ?> &middot;
            <a href="<?= e($p['rera_url']) ?>" target="_blank" rel="noopener nofollow" class="text-gold hover:underline">www.haryanarera.gov.in</a>
          </p>
        </div>

        <div class="mt-5 space-y-2 text-[12px] text-ivory/45 leading-relaxed">
          <p><span class="text-ivory/70 font-semibold">Pricing disclaimer:</span> Starts at <?= e($p['price_from']) ?>*. <?= e($C['notices']['price_note']) ?></p>
          <p><span class="text-ivory/70 font-semibold">Image disclaimer:</span> <?= e($C['notices']['image_note']) ?></p>
        </div>
      </div>

      <!-- Explore + contact -->
      <div class="md:col-span-3">
        <p class="eyebrow text-ivory mb-4">Explore</p>
        <nav aria-label="Footer">
          <ul class="space-y-2.5 text-[14px]">
            <?php foreach ($navItems as $id => $label): ?>
              <li><a href="#<?= e($id) ?>" class="hover:text-gold transition-colors"><?= e($label) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </nav>

        <p class="eyebrow text-ivory mt-8 mb-4">Talk to us</p>
        <p class="text-[14px] leading-relaxed">
          <a href="tel:+<?= e($b['phone_raw']) ?>" class="block hover:text-gold transition-colors"><?= e($b['phone']) ?></a>
          <a href="mailto:<?= e($b['email']) ?>" class="block hover:text-gold transition-colors break-all"><?= e($b['email']) ?></a>
        </p>
      </div>
    </div>

    <div class="pt-8 grid lg:grid-cols-[1fr_auto] gap-6 items-start">
      <p class="text-[11.5px] leading-relaxed text-ivory/35 max-w-4xl">
        <strong class="text-ivory/55">Disclaimer:</strong> <?= e($C['notices']['disclaimer']) ?>
      </p>
      <p class="text-[11.5px] text-ivory/35 lg:text-right">
        &copy; <?= date('Y') ?> <?= e($b['legal_name']) ?>. All rights reserved.<br>
        <a href="privacy-policy.php" class="hover:text-gold">Privacy Policy</a> &middot;
        <a href="privacy-policy.php#terms" class="hover:text-gold">Terms &amp; Conditions</a>
      </p>
    </div>
  </div>
</footer>

<!-- ═════════════════════════════════════════ Mobile sticky bar ══ -->
<div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-ink/95 backdrop-blur border-t border-white/10 grid grid-cols-3 pb-[env(safe-area-inset-bottom)]">
  <a href="tel:+<?= e($b['phone_raw']) ?>" class="flex flex-col items-center justify-center gap-1 py-3 text-ivory/80 text-[11px] font-medium active:bg-white/5">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
    Call
  </a>
  <a href="https://wa.me/<?= e($b['whatsapp']) ?>" target="_blank" rel="noopener" class="flex flex-col items-center justify-center gap-1 py-3 text-ivory/80 text-[11px] font-medium border-x border-white/10 active:bg-white/5">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2Zm5.4 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .1-1.7-.1a13 13 0 0 1-5.6-4.9c-.4-.6-1-1.5-1-2.9 0-1.3.7-2 1-2.3.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.4 0 .6l-.4.5-.3.4c-.1.1-.2.3 0 .6.2.3.7 1.2 1.5 1.9 1 .9 1.8 1.2 2.1 1.3.2.1.4.1.6-.1l.8-1c.2-.2.3-.2.6-.1l2 1c.2.1.4.2.4.3.1.2.1.8-.1 1.4Z"/></svg>
    WhatsApp
  </a>
  <button data-modal-open data-modal-src="mobile-bar" class="flex flex-col items-center justify-center gap-1 py-3 bg-gold text-ink text-[11px] font-bold active:brightness-95">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 4h16v12H7l-3 3V4Z"/></svg>
    Enquire
  </button>
</div>

<!-- ═══════════════════════════════════════════════════ MODAL ══ -->
<div id="modal" class="fixed inset-0 z-[60] hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
  <div class="absolute inset-0 bg-ink/80 backdrop-blur-sm" data-modal-close></div>
  <div class="relative h-full overflow-y-auto flex items-center justify-center p-4 sm:p-6">
    <div id="modal-card" class="relative w-full max-w-[880px] bg-ivory rounded-[3px] overflow-hidden shadow-2xl grid md:grid-cols-2 transition-all duration-500 opacity-0 translate-y-4">

      <div class="relative hidden md:block">
        <img src="<?= e(u('lounge')) ?>" alt="Clubhouse lounge at Indiabulls Sector 104" loading="lazy" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/40 to-transparent"></div>
        <div class="absolute bottom-0 p-8 text-ivory">
          <p class="eyebrow text-gold">Authorized Channel Partner</p>
          <p class="display text-[26px] leading-tight mt-2">Priority allotment for early registrations</p>
          <ul class="mt-5 space-y-2 text-[13px] text-ivory/70">
            <?php foreach (['Full cost sheet & payment plan','Unit availability chart','48-hour unit hold, no payment'] as $x): ?>
              <li class="flex gap-2.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#F5B301" stroke-width="2.6" stroke-linecap="round" class="shrink-0 mt-0.5"><path d="m5 13 4 4L19 7"/></svg><?= e($x) ?></li>
            <?php endforeach; ?>
          </ul>
          <p class="mt-5 text-[10.5px] text-ivory/40 leading-relaxed"><?= e($C['notices']['image']) ?></p>
        </div>
      </div>

      <div class="p-7 sm:p-9">
        <button data-modal-close class="absolute top-4 right-4 w-9 h-9 grid place-items-center rounded-full hover:bg-ink hover:text-ivory transition-colors" aria-label="Close">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>

        <p class="eyebrow text-gold-700">Register interest</p>
        <h2 id="modal-title" class="display text-[28px] leading-tight mt-2.5">Let’s find your floor.</h2>
        <p class="text-[13px] text-ink-500 mt-2">Callback within 30 minutes, 10 AM – 8 PM IST.</p>

        <form method="post" class="mt-6 grid gap-5" novalidate>
          <input type="hidden" name="form_type" value="enquiry">
          <input type="hidden" name="src" id="modal-src" value="modal">
          <!-- Set when the visitor opens the modal from a specific plan or price
               row, so the lead still records what they were looking at. -->
          <input type="hidden" name="config" id="m-cfg" value="">
          <input type="text" name="company" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">

          <label for="m-name" class="sr-only">Full name</label>
          <input id="m-name" class="fld fld-l" type="text" name="name" placeholder="Full name" required autocomplete="name">

          <div class="grid grid-cols-[auto_1fr] gap-3 items-end">
            <span class="pb-2.5 text-ink-500 text-[15px] border-b border-ink/15">+91</span>
            <div>
              <label for="m-phone" class="sr-only">Mobile number</label>
              <input id="m-phone" class="fld fld-l" type="tel" name="phone" placeholder="Mobile number" required inputmode="numeric" autocomplete="tel">
            </div>
          </div>

          <label for="m-email" class="sr-only">Email</label>
          <input id="m-email" class="fld fld-l" type="email" name="email" placeholder="Email (optional)" autocomplete="email">

          <button class="btn btn-gold h-12 rounded-full text-[14px] mt-1">
            Request a callback
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14m-6-7 7 7-7 7"/></svg>
          </button>
          <?= consent_note($C) ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════ Lightbox ══ -->
<div id="lb" class="fixed inset-0 z-[70] hidden bg-ink/96 backdrop-blur">
  <button data-lb-close class="absolute top-5 right-5 z-10 w-11 h-11 grid place-items-center rounded-full border border-white/20 text-ivory hover:bg-gold hover:text-ink hover:border-gold transition-colors" aria-label="Close gallery">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
  </button>
  <button data-lb-prev class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 grid place-items-center rounded-full border border-white/20 text-ivory hover:bg-gold hover:text-ink hover:border-gold transition-colors" aria-label="Previous">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m15 5-7 7 7 7"/></svg>
  </button>
  <button data-lb-next class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 grid place-items-center rounded-full border border-white/20 text-ivory hover:bg-gold hover:text-ink hover:border-gold transition-colors" aria-label="Next">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 5 7 7-7 7"/></svg>
  </button>
  <figure class="h-full flex flex-col items-center justify-center p-6 sm:p-14 gap-4">
    <img id="lb-img" src="" alt="" class="max-h-[76vh] max-w-full object-contain rounded-[3px]">
    <figcaption class="text-center">
      <span id="lb-cap" class="block text-ivory/70 text-[13px] tracking-wide"></span>
      <span class="block text-ivory/35 text-[11px] mt-1.5"><?= e($C['notices']['image']) ?></span>
    </figcaption>
  </figure>
</div>

<script>
(() => {
  'use strict';
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];

  /* ---------- Header: solid on scroll ---------- */
  const hdr = $('#hdr');
  const onScroll = () => hdr.classList.toggle('solid', window.scrollY > 60);
  onScroll();
  addEventListener('scroll', onScroll, { passive: true });

  /* ---------- Mobile drawer ---------- */
  const burger = $('#burger'), drawer = $('#drawer');
  burger.addEventListener('click', () => {
    const open = drawer.classList.toggle('hidden');
    burger.setAttribute('aria-expanded', String(!open));
  });
  $$('.js-drawer-link').forEach(a => a.addEventListener('click', () => {
    drawer.classList.add('hidden');
    burger.setAttribute('aria-expanded', 'false');
  }));

  /* ---------- Scroll reveal ----------
     Three layers, so an element can never get stuck invisible:
       1. anything already on screen at load reveals immediately
       2. IntersectionObserver handles the rest as you scroll
       3. a timeout force-reveals whatever is left, and if IO is missing
          entirely we skip straight to showing everything.               */
  const targets = $$('.rv:not(.in), .imgrv');
  const reveal  = el => el.classList.add('in');

  const inView = (el) => {
    const r = el.getBoundingClientRect();
    return r.top < innerHeight * 0.95 && r.bottom > 0;
  };

  if ('IntersectionObserver' in window) {
    const revealer = new IntersectionObserver((entries) => {
      entries.forEach(en => {
        if (en.isIntersecting) { reveal(en.target); revealer.unobserve(en.target); }
      });
    }, { threshold: 0.05, rootMargin: '0px 0px -5% 0px' });

    targets.forEach(el => { if (inView(el)) reveal(el); else revealer.observe(el); });

    /* Safety net: nothing stays hidden for more than 3s after load. */
    addEventListener('load', () => setTimeout(() => targets.forEach(reveal), 3000));
  } else {
    targets.forEach(reveal);
  }

  /* ---------- Animated counters ---------- */
  const counter = new IntersectionObserver((entries) => {
    entries.forEach(en => {
      if (!en.isIntersecting) return;
      const el = en.target, to = parseFloat(el.dataset.to), dec = parseInt(el.dataset.dec, 10) || 0;
      const t0 = performance.now(), dur = 1500;
      const tick = (t) => {
        const k = Math.min(1, (t - t0) / dur);
        el.textContent = (to * (1 - Math.pow(1 - k, 3))).toFixed(dec);
        if (k < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
      counter.unobserve(el);
    });
  }, { threshold: 0.6 });
  $$('.js-count').forEach(el => counter.observe(el));

  /* ---------- Scrollspy ---------- */
  const links = $$('.js-navlink');
  const spy = new IntersectionObserver((entries) => {
    entries.forEach(en => {
      if (!en.isIntersecting) return;
      links.forEach(l => l.classList.toggle('active', l.dataset.nav === en.target.id));
    });
  }, { rootMargin: '-45% 0px -50% 0px' });
  links.forEach(l => { const s = document.getElementById(l.dataset.nav); if (s) spy.observe(s); });

  /* ---------- Generic tab switcher ---------- */
  const tabs = (btnSel, panelSel, dataAttr, panelAttr) => {
    const btns = $$(btnSel), panels = $$(panelSel);
    btns.forEach(btn => btn.addEventListener('click', () => {
      const k = btn.dataset[dataAttr];
      btns.forEach(b => {
        const on = b === btn;
        b.classList.toggle('is-active', on);
        b.setAttribute('aria-pressed', String(on));
      });
      panels.forEach(p => p.classList.toggle('hidden', p.dataset[panelAttr] !== k));
    }));
  };
  tabs('.js-plan-tab', '.js-plan-panel', 'planTab', 'planPanel');
  tabs('.js-am-tab',   '.js-am-panel',   'amTab',   'amPanel');

  /* ---------- Modal ---------- */
  const modal = $('#modal'), card = $('#modal-card');
  let lastFocus = null;
  const openModal = (cfg, src) => {
    lastFocus = document.activeElement;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(() => card.classList.remove('opacity-0', 'translate-y-4'));
    if (cfg) { const s = $('#m-cfg'); if (s) s.value = cfg; }
    if (src) $('#modal-src').value = src;
    setTimeout(() => $('#m-name').focus(), 260);
  };
  const closeModal = () => {
    card.classList.add('opacity-0', 'translate-y-4');
    document.body.style.overflow = '';
    setTimeout(() => modal.classList.add('hidden'), 260);
    lastFocus && lastFocus.focus();
  };
  $$('[data-modal-open]').forEach(b => b.addEventListener('click', () =>
    openModal(b.dataset.modalConfig, b.dataset.modalSrc || 'modal')));
  $$('[data-modal-close]').forEach(b => b.addEventListener('click', closeModal));

  /* Focus trap */
  modal.addEventListener('keydown', (ev) => {
    if (ev.key !== 'Tab') return;
    const f = $$('a[href],button,input,select,textarea', card).filter(el => !el.disabled && el.offsetParent !== null);
    if (!f.length) return;
    const first = f[0], last = f[f.length - 1];
    if (ev.shiftKey && document.activeElement === first) { ev.preventDefault(); last.focus(); }
    else if (!ev.shiftKey && document.activeElement === last) { ev.preventDefault(); first.focus(); }
  });

  /* ---------- Lightbox ---------- */
  const lb = $('#lb'), lbImg = $('#lb-img'), lbCap = $('#lb-cap');
  const shots = $$('.js-lb');
  let idx = 0;
  const show = (i) => {
    idx = (i + shots.length) % shots.length;
    const s = shots[idx];
    lbImg.src = s.dataset.full;
    lbImg.alt = s.dataset.cap;
    lbCap.textContent = s.dataset.cap;
  };
  shots.forEach((s, i) => s.addEventListener('click', () => {
    show(i); lb.classList.remove('hidden'); document.body.style.overflow = 'hidden';
  }));
  const closeLb = () => { lb.classList.add('hidden'); document.body.style.overflow = ''; };
  $('[data-lb-close]').addEventListener('click', closeLb);
  $('[data-lb-prev]').addEventListener('click', () => show(idx - 1));
  $('[data-lb-next]').addEventListener('click', () => show(idx + 1));
  lb.addEventListener('click', (ev) => { if (ev.target === lb || ev.target.tagName === 'FIGURE') closeLb(); });

  /* ---------- Keyboard ---------- */
  addEventListener('keydown', (ev) => {
    if (ev.key === 'Escape') { if (!lb.classList.contains('hidden')) closeLb(); if (!modal.classList.contains('hidden')) closeModal(); }
    if (!lb.classList.contains('hidden')) {
      if (ev.key === 'ArrowRight') show(idx + 1);
      if (ev.key === 'ArrowLeft')  show(idx - 1);
    }
  });

  /* ---------- Floor-plan gate ----------
     Reveal the plan as soon as the visitor submits, so the promise is kept
     immediately rather than after a page round-trip. The form still posts
     (PHP locally, Netlify Forms in production) — this only handles the UI. */
  $$('.js-plan-gate form').forEach(form => {
    form.addEventListener('submit', () => {
      const wrap = form.closest('.relative');
      if (!wrap) return;
      const art  = $('.js-plan-art', wrap);
      const gate = $('.js-plan-gate', wrap);
      if (art) { art.style.filter = 'none'; art.style.transform = 'none'; }
      if (gate) { gate.style.opacity = '0'; gate.style.pointerEvents = 'none'; }
      try { sessionStorage.setItem('ck_plan_unlocked', '1'); } catch (err) { /* private mode */ }
    });
  });

  /* Stay unlocked for the rest of the session, including the other plan tab. */
  try {
    if (sessionStorage.getItem('ck_plan_unlocked')) {
      $$('.js-plan-art').forEach(a => { a.style.filter = 'none'; a.style.transform = 'none'; });
      $$('.js-plan-gate').forEach(g => g.remove());
    }
  } catch (err) { /* private mode */ }

  /* ---------- Phone input hygiene ---------- */
  $$('input[type="tel"]').forEach(i => i.addEventListener('input', () => {
    i.value = i.value.replace(/[^\d]/g, '').slice(0, 10);
  }));

  /* ---------- Graceful image fallback ---------- */
  addEventListener('error', (ev) => {
    const t = ev.target;
    if (t && t.tagName === 'IMG' && !t.dataset.fb) {
      t.dataset.fb = '1';
      t.removeAttribute('src');
      t.style.background = 'linear-gradient(135deg,#26262C,#0E0E10 60%,#3a3216)';
    }
  }, true);

  /* ---------- Exit-intent (desktop, once per session) ---------- */
  if (!sessionStorage.getItem('ck_exit')) {
    document.addEventListener('mouseout', function handler(ev) {
      if (ev.clientY > 0 || ev.relatedTarget || window.innerWidth < 1024) return;
      if (!modal.classList.contains('hidden')) return;
      sessionStorage.setItem('ck_exit', '1');
      document.removeEventListener('mouseout', handler);
      openModal(null, 'exit-intent');
    });
  }

  /* ---------- Scroll to flash message after PRG ---------- */
  if (location.search.includes('sent=1') && location.hash) {
    const t = document.querySelector(location.hash);
    t && setTimeout(() => t.scrollIntoView({ behavior: 'smooth', block: 'center' }), 200);
  }
})();
</script>
</body>
</html>
