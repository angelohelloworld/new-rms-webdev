<?php

include dirname(__FILE__, 4) . '/helpers/db.php';

// Check if the user is logged in

echo("<script>console.log('user_email: " . $_SESSION['user_email'] . "');</script>");
if (!isset($_SESSION['user_email'])) {
    header("Location: ../../../views/public-user/home/home.php");
    exit;
}

// Fetch user details from the database
$user_query = "SELECT * FROM table_user WHERE email = $1";
$user_result = pg_query_params($conn, $user_query, array($_SESSION['user_email']));
if (!$user_result) {
    echo "An error occurred: " . pg_last_error($conn);
    exit;
}
$user = pg_fetch_assoc($user_result);

if (!$user) {
    echo "User not found.";
    header("Location: ../../login/login.php");
    exit;
}

?>
