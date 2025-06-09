<?php
// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering
ob_start();

// Include the initialization file
require_once 'init.php';

// Get the output
$output = ob_get_clean();

// Add some styling
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Travel Site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .success {
            color: #27ae60;
        }
        .error {
            color: #c0392b;
        }
        .next-steps {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Setup</h1>
        <?php echo $output; ?>
        
        <div class="next-steps">
            <h2>Next Steps</h2>
            <ol>
                <li>Run the test suite to verify the setup: <a href="../tests/run_tests.php">Run Tests</a></li>
                <li>Create an admin user: <a href="../admin/create_admin.php">Create Admin</a></li>
                <li>Start using the application: <a href="../index.php">Go to Homepage</a></li>
            </ol>
        </div>
    </div>
</body>
</html> 