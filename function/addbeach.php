<?php
session_start();
if ($_SESSION['role'] == "user") {
    header('location: index.php');
    exit();
}

$conn = connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];


        if (move_uploaded_file($image_tmp, $image_name)) {

            $sql = "INSERT INTO beaches (beaches_name, beaches_description, beaches_img) VALUES ('$name', '$description', $category, $price, '../assets/$image_name')";
            $res = $conn->query($sql);
            if ($res) {

                header('Location: admin.php');
                exit();
            } else {
                echo 'Error: ' . $conn->error;
            }
        } else {
            echo 'Error: Failed to move the uploaded image.';
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('./layouts/header.php'); ?>
    <link rel="stylesheet" href="./assets/css/editbeach.css">
</head>

<body>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="text-center">Add Beach Page</h3>
            <?php
            $cookieData = json_decode($_COOKIE['user'], true);
            $username = $cookieData['username'];
            echo '<div class="d-flex align-items-center text-align-center">';
            echo '<div>Hello Admin <h3>' . $username . '</h3></div>';
            echo '<button onclick="dologout(event)" class="btn lout btn-primary">Logout</button>';
            echo '</div>';
            ?>
        </div>
        <div class="page-wrap d-flex" style="margin-top:10px">
            <div class="content-1">
                <div class="control-wrap">
                    <h2 style="background-color: gray;">Admin Menu</h2>
                    <ul>
                        <li><a href="#">Admin</a></li>
                        <li><a href="#">Customer</a></li>
                        <li><a href="../beaches.php">Beachs</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="feedback.php">Feedback</a></li>
                        <li><a href="#">Cart</a></li>
                    </ul>
                </div>
            </div>
            <div class="content-2">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <div class="title_editbeach" style="background-color: gray;">
                            <h2 style="margin-bottom: 50px;margin-left:43%;">Add Beach</h2>
                        </div>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Beach Name</label>
                                <input type="text" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Beach Description</label>
                                <textarea name="description" id="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" required>
                                    <option value="">Select a category</option>
                                    <option value="East">East</option>
                                    <option value="West">West</option>
                                    <option value="Southern">Southern</option>
                                    <option value="North">North</option>
                                </select>
                            </div>
                            <div class="form-group d-flex">
                                <label for="image">Beach Image</label>
                                <input type="file" name="image" id="image" accept="image/*" required>
                                <img id="preview-image" src="#" alt="Preview Image"
                                    style="display: none; max-width: 200px; margin-top: 10px;">
                            </div>
                            <div class="form-group">
                                <label for=""></label>
                                <button type="submit" class="btn btn-primary">Add Beach</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function dologout(e) {
        e.preventDefault();
        if (confirm('Bạn có muốn đăng xuất không?')) {
            window.location.href = '../logout.php';
        }
    }
    document.getElementById('image').addEventListener('change', function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var imagePreview = document.getElementById('preview-image');
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
</script>

</html>