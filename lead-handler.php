<?php
/**
 * Lead capture — validates, stores to leads.csv, optionally emails, then PRG-redirects.
 * Included at the very top of index.php (before any output).
 */

/* Under the static build (php build.php) there is no request and no session —
   skip straight past all of this and let the page render its default state. */
if (PHP_SAPI !== 'cli' && session_status() === PHP_SESSION_NONE) {
    session_start();
}

$FLASH = null;          // ['ok'=>bool,'msg'=>string,'type'=>'enquiry|brochure|visit']
$LEADS_FILE = __DIR__ . '/leads.csv';

/* ---- Show flash after redirect ------------------------------------------ */
if (isset($_SESSION) && !empty($_SESSION['flash'])) {
    $FLASH = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type    = $_POST['form_type']   ?? 'enquiry';
    $name    = trim($_POST['name']   ?? '');
    $phone   = trim($_POST['phone']  ?? '');
    $email   = trim($_POST['email']  ?? '');
    $config  = trim($_POST['config'] ?? '');
    $message = trim($_POST['message']?? '');
    $honey   = trim($_POST['company']?? '');   // hidden honeypot

    $errors = [];

    if ($honey !== '')                                     $errors[] = 'spam';
    if (mb_strlen($name) < 2)                              $errors[] = 'Please enter your name.';
    if (!preg_match('/^[0-9+\-\s()]{8,18}$/', $phone))     $errors[] = 'Please enter a valid phone number.';
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email.';

    /* Simple flood guard: one submission per 20s per session */
    $now = time();
    if (!empty($_SESSION['last_lead']) && ($now - $_SESSION['last_lead']) < 20) {
        $errors[] = 'You just submitted a request — our team is already on it.';
    }

    if ($errors) {
        $_SESSION['flash'] = [
            'ok'   => false,
            'type' => $type,
            'msg'  => in_array('spam', $errors, true) ? 'Something went wrong. Please try again.' : $errors[0],
        ];
    } else {
        $_SESSION['last_lead'] = $now;

        $row = [
            date('Y-m-d H:i:s'),
            $type,
            $name,
            $phone,
            $email,
            $config,
            $message,
            $_POST['src'] ?? 'direct',
            $_SERVER['HTTP_REFERER'] ?? '',
            $_SERVER['REMOTE_ADDR'] ?? '',
        ];

        $new = !file_exists($LEADS_FILE);
        if ($fh = @fopen($LEADS_FILE, 'a')) {
            if ($new) {
                fputcsv($fh, ['timestamp','form','name','phone','email','configuration','message','source','referrer','ip']);
            }
            fputcsv($fh, $row);
            fclose($fh);
        }

        /* Optional: uncomment to email the sales desk.
        @mail('sales@comingkeys.com', 'New '.$type.' lead — Coming Keys',
              print_r($row, true), 'From: web@comingkeys.com');
        */

        $_SESSION['flash'] = [
            'ok'   => true,
            'type' => $type,
            'msg'  => $type === 'brochure'
                ? 'Your brochure is ready. Download it below — we have also messaged the link to you.'
                : 'Thank you, ' . $name . '. A senior relationship manager will call you within 30 minutes.',
        ];
    }

    $anchor = $type === 'brochure' ? '#brochure' : '#enquire';
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?sent=1' . $anchor, true, 303);
    exit;
}
