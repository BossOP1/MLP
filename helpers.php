<?php
/**
 * Shared view helpers. require_once'd by every page — the static build includes
 * all pages in a single PHP process, so these must not be declared per-page.
 */

/** Escape for HTML output. */
function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

/**
 * Local image path, cache-busted on file mtime so replacing a render never
 * serves a stale copy. Drop new files into assets/img/ using the same names.
 */
function u($name) {
    $rel   = 'assets/img/' . $name . '.jpg';
    $abs   = __DIR__ . '/' . $rel;
    $stamp = is_file($abs) ? filemtime($abs) : 0;
    return $rel . ($stamp ? '?v=' . $stamp : '');
}

/**
 * Consent notice shown beneath every lead form. Returns HTML because it
 * carries links; $dark selects the palette for forms on a dark panel.
 */
function consent_note(array $C, bool $dark = false): string {
    $muted = $dark ? 'text-ivory/40' : 'text-ink-500/80';
    $link  = $dark ? 'text-ivory/70 hover:text-gold' : 'text-ink hover:text-gold-700';
    return '<p class="text-[11px] leading-relaxed ' . $muted . '">'
         . 'Your enquiry will be handled by ' . e($C['brand']['legal_name']) . ', an '
         . e($C['brand']['role']) . ' for this project. By submitting this form, you consent to '
         . 'receive calls, SMS, WhatsApp and email, and agree to our '
         . '<a href="privacy-policy.php" class="underline underline-offset-2 ' . $link . '">Privacy Policy</a> and '
         . '<a href="privacy-policy.php#terms" class="underline underline-offset-2 ' . $link . '">Terms &amp; Conditions</a>.'
         . '</p>';
}

/** Brand logo — transparent PNG, cache-busted the same way. */
function logo() {
    $rel   = 'assets/img/logo/coming-keys.png';
    $abs   = __DIR__ . '/' . $rel;
    $stamp = is_file($abs) ? filemtime($abs) : 0;
    return $rel . ($stamp ? '?v=' . $stamp : '');
}
