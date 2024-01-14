<?php
session_start();
include 'dbconfig.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['id'];

// Fetch user's posts
$sql = "SELECT * FROM posts WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

// Check if there are posts
if ($result && mysqli_num_rows($result) > 0) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $posts = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Posts</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Your Posts</h2>

        <!-- Add Post Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Add New Post</h5>
                <form action="add_post.php" method="POST">
                    <div class="form-group">
                        <label for="postTitle">Post Title</label>
                        <input type="text" class="form-control" id="postTitle" name="postTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="postContent">Post Content</label>
                        <textarea class="form-control" id="postContent" name="postContent" rows="3"
                            required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Post</button>
                </form>
            </div>
        </div>

        <!-- Display User's Posts -->
        <?php foreach ($posts as $post) : ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($post['post_title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($post['post_content']) ?></p>
                    <!-- Update Post Button -->
                    <a href="update_post.php?id=<?= $post['id'] ?>" class="btn btn-warning mr-2">Update Post</a>
                    <!-- Delete Post Button -->
                    <a href="delete_post.php?id=<?= $post['id'] ?>" class="btn btn-danger">Delete Post</a>
                </div>
            </div>
        <?php endforeach; ?>
                <!-- Logout Button -->
        <form action="logout.php" method="POST" class="mt-3">
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
        <!-- Link back to the home page -->
        <p><a href="index.php">Back to Home</a></p>
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
