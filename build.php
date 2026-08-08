<?php
/**
 * Build script for Netlify deployment
 * ------------------------------------------------------------------
 * Renders every PHP page to static HTML in dist/, rewrites .php links
 * to .html, converts the lead forms to Netlify Forms, and copies the
 * assets alongside. Run locally with:
 *
 *     php build.php
 *
 * Netlify runs it via the build command in netlify.toml and publishes dist/.
 *
 * Why the form conversion matters: on a static host there is no PHP, so
 * lead-handler.php never runs. Every form on this page would POST into the
 * void. The rewrite below hands submissions to Netlify Forms instead, so
 * the enquiry, brochure and modal forms keep working after deploy.
 */

chdir(__DIR__);

// The CLI has no request, but the page templates read $_SERVER. Give them
// something sane so nothing warns mid-render.
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI']    = $_SERVER['REQUEST_URI']    ?? '/';
$_SERVER['HTTP_HOST']      = $_SERVER['HTTP_HOST']      ?? 'localhost';
$_SERVER['SERVER_NAME']    = $_SERVER['SERVER_NAME']    ?? 'localhost';
$_SERVER['HTTPS']          = 'on';

// Pages to build (source PHP file => output HTML file).
// Missing files are skipped with a warning rather than failing the build.
$pages = [
    'index.php'     => 'index.html',
    'thank-you.php' => 'thank-you.html',
];

// Folders copied wholesale into dist/.
$assetDirs = ['assets'];

// Single files copied into dist/ when present.
$rootFiles = [
    'favicon.ico', 'favicon.png', 'robots.txt', 'sitemap.xml',
    '_redirects', '_headers',
];

// Where Netlify sends a visitor after a successful submission.
const FORM_REDIRECT = '/thank-you.html';

// Files that must never reach the public directory.
$neverPublish = ['leads.csv', 'config.php', 'lead-handler.php', 'build.php'];

/* ------------------------------------------------------------------ */

function removeDir(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    foreach (scandir($dir) as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        $path = "$dir/$file";
        is_dir($path) ? removeDir($path) : unlink($path);
    }
    rmdir($dir);
}

function copyDir(string $src, string $dst): int
{
    // Source-only artefacts: the original logo supplied by the client is kept
    // in the repo but there is no reason to publish it alongside the PNG.
    $skipPatterns = ['/^WhatsApp Image/i', '/\.psd$/i', '/\.ai$/i', '/^\./'];

    if (!is_dir($src)) {
        return 0;
    }
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    $count = 0;
    foreach (scandir($src) as $file) {
        if ($file === '.' || $file === '..' || $file === '.DS_Store') {
            continue;
        }
        foreach ($skipPatterns as $pat) {
            if (preg_match($pat, $file)) {
                continue 2;
            }
        }
        $srcPath = "$src/$file";
        $dstPath = "$dst/$file";
        if (is_dir($srcPath)) {
            $count += copyDir($srcPath, $dstPath);
        } elseif (copy($srcPath, $dstPath)) {
            $count++;
        }
    }
    return $count;
}

/**
 * Turn every PHP-handled <form> into a Netlify Form.
 *
 * Netlify detects forms by parsing the deployed HTML, so each one needs a
 * name, data-netlify, and a matching hidden form-name field. The existing
 * honeypot input is declared to Netlify rather than replaced.
 */
function netlifyForms(string $html, int &$converted): string
{
    return preg_replace_callback(
        '/<form\b([^>]*)>(.*?)<\/form>/is',
        function (array $m) use (&$converted) {
            [$all, $attrs, $body] = $m;

            // Only touch the POST forms this site owns.
            if (!preg_match('/method\s*=\s*["\']post["\']/i', $attrs)) {
                return $all;
            }

            // form_type tells us which bucket the submission belongs in.
            $type = preg_match('/name=["\']form_type["\']\s+value=["\']([^"\']+)["\']/i', $body, $t)
                ? $t[1]
                : 'enquiry';
            $formName = 'coming-keys-' . $type;

            // Preserve class / novalidate, drop attributes we are about to
            // re-emit — otherwise the tag ends up with two method attributes.
            $attrs = preg_replace('/\s(method|action|name|data-netlify|netlify-honeypot)\s*=\s*["\'][^"\']*["\']/i', '', $attrs);

            $open = '<form' . rtrim($attrs)
                  . ' name="' . $formName . '"'
                  . ' method="POST"'
                  . ' action="' . FORM_REDIRECT . '"'
                  . ' data-netlify="true"'
                  . ' netlify-honeypot="company">';

            $hidden = "\n            <input type=\"hidden\" name=\"form-name\" value=\"{$formName}\">";

            $converted++;
            return $open . $hidden . $body . '</form>';
        },
        $html
    );
}

/* ---- Start from a clean dist/ ------------------------------------- */

removeDir('dist');
mkdir('dist', 0755, true);

/* ---- Render the pages --------------------------------------------- */

$built = 0;
$skipped = [];
$totalForms = 0;

foreach ($pages as $srcFile => $outFile) {

    if (!file_exists($srcFile)) {
        $skipped[] = $srcFile;
        echo "Skipped: $srcFile (not created yet)\n";
        continue;
    }

    $destPath = 'dist/' . $outFile;
    $destDir  = dirname($destPath);

    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    // Render. Included at global scope on purpose: the pages share
    // $C and the required includes across the whole build.
    ob_start();
    include $srcFile;
    $html = ob_get_clean();

    if (trim($html) === '') {
        fwrite(STDERR, "ERROR: $srcFile rendered nothing.\n");
        exit(1);
    }

    // Internal .php links become .html for the static host. Anything with a
    // scheme (tel:, mailto:, https://) has no .php in it, so it is untouched.
    $html = str_replace(
        ['.php"', ".php'", '.php#', '.php?'],
        ['.html"', ".html'", '.html#', '.html?'],
        $html
    );

    $forms = 0;
    $html  = netlifyForms($html, $forms);
    $totalForms += $forms;

    file_put_contents($destPath, $html);
    $built++;
    printf("Built:   %-16s %6.1f KB%s\n", $outFile, strlen($html) / 1024,
           $forms ? "  ({$forms} Netlify forms)" : '');
}

/* ---- Copy the static files ---------------------------------------- */

foreach ($assetDirs as $dir) {
    $n = copyDir($dir, 'dist/' . $dir);
    echo "Copied:  $dir/ ($n files)\n";
}

foreach ($rootFiles as $file) {
    if (file_exists($file) && copy($file, 'dist/' . $file)) {
        echo "Copied:  $file\n";
    }
}

/* ---- Safety net: nothing private may sit in dist/ ------------------ */

foreach ($neverPublish as $file) {
    if (file_exists('dist/' . $file)) {
        unlink('dist/' . $file);
        echo "Removed: dist/$file (must not be published)\n";
    }
}

/* ---- Verify the output actually works ------------------------------ */

$index = @file_get_contents('dist/index.html');
$checks = [
    'forms wired to Netlify' => substr_count((string)$index, 'data-netlify="true"') > 0,
    'form-name fields set'   => substr_count((string)$index, 'name="form-name"') === $totalForms,
    'hero image present'     => is_file('dist/assets/img/hero.jpg'),
    'logo present'           => is_file('dist/assets/img/logo/coming-keys.png'),
    'structured data intact' => str_contains((string)$index, 'application/ld+json'),
];

echo "\n";
$failed = 0;
foreach ($checks as $label => $ok) {
    echo ($ok ? '  ok   ' : '  FAIL ') . $label . "\n";
    $failed += $ok ? 0 : 1;
}

/* ---- Report -------------------------------------------------------- */

echo "\nBuild complete: $built page" . ($built === 1 ? '' : 's')
   . ", $totalForms form" . ($totalForms === 1 ? '' : 's') . " in dist/.\n";

if ($skipped) {
    echo "Not built: " . implode(', ', $skipped) . "\n";
}

if ($failed) {
    fwrite(STDERR, "\n$failed check(s) failed — do not deploy this build.\n");
    exit(1);
}
