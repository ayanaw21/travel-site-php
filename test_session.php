<?php
// test_session.php
require_once 'includes/auth_functions.php';
require_once 'includes/debug.php';

startSecureSession();

// Store some test data
if (empty($_SESSION['test_data'])) {
    $_SESSION['test_data'] = 'Session is working! ' . date('Y-m-d H:i:s');
}

debugSession();
?>

<h1>Session Test</h1>
<p>Try refreshing this page. The timestamp should persist.</p>
<p><a href="test_session.php?logout=1">Clear Session</a></p>

<?php
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: test_session.php");
    exit();
}
?>