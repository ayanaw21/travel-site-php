<?php
// session_start();

// // Clear all session variables
// $_SESSION = array();

// // If desired, delete the session cookie
// if (ini_get("session.use_cookies")) {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000,
//         $params["path"], $params["domain"],
//         $params["secure"], $params["httponly"]
//     );
// }

// // Finally, destroy the session
// session_destroy();

// // Redirect to login page
// header("Location: login.php");
// exit();
function logoutUser() {
    startSecureSession();
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}
?>