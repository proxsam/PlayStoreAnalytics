<?php
session_start();
include 'dbconfig.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

// Check if post ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: posts.php");
    exit;
}

$user_id = $_SESSION['id'];
$post_id = $_GET['id'];

// Fetch the post
$sql = "SELECT * FROM posts WHERE id = $post_id AND user_id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $post = mysqli_fetch_assoc($result);
} else {
    // Redirect if the post does not belong to the user
    header("Location: posts.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Update Post</h2>

        <!-- Update Post Form -->
        <form action="update_post_process.php" method="POST">
            <input type="hidden" name="postId" value="<?= $post['id'] ?>">
            <div class="form-group">
                <label for="updateTitle">Post Title</label>
                <input type="text" class="form-control" id="updateTitle" name="updateTitle" value="<?= htmlspecialchars($post['post_title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="updateContent">Post Content</label>
                <textarea class="form-control" id="updateContent" name="updateContent" rows="3"
                    required><?= htmlspecialchars($post['post_content']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>

        <!-- Link back to the home page -->
        <p class="mt-3"><a href="posts.php">Back to Your Posts</a></p>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
</body>

</html>
