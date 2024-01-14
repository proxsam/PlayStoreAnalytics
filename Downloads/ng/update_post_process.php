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
    $postId = $_POST['postId'];
    $updateTitle = $_POST['updateTitle'];
    $updateContent = $_POST['updateContent'];

    // Update the post in the database
    $updatePostQuery = "UPDATE posts SET post_title = ?, post_content = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $updatePostQuery);

    mysqli_stmt_bind_param($stmt, "ssii", $updateTitle, $updateContent, $postId, $user_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Redirect to the posts page after successful update
        header("Location: posts.php");
        exit;
    } else {
        echo "Error updating the post: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>
