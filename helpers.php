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

/** Brand logo — transparent PNG, cache-busted the same way. */
function logo() {
    $rel   = 'assets/img/logo/coming-keys.png';
    $abs   = __DIR__ . '/' . $rel;
    $stamp = is_file($abs) ? filemtime($abs) : 0;
    return $rel . ($stamp ? '?v=' . $stamp : '');
}
