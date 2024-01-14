<?php
session_start();
include 'dbconfig.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['postContent'];

    // Insert the new post into the database
    $insertPostQuery = "INSERT INTO posts (user_id, post_title, post_content, status) VALUES (?, ?, ?, 0)";
    $stmt = mysqli_prepare($conn, $insertPostQuery);

    mysqli_stmt_bind_param($stmt, "iss", $user_id, $postTitle, $postContent);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Redirect to the posts page after successful addition
        header("Location: posts.php");
        exit;
    } else {
        echo "Error adding the post: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>
