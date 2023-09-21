<?php
require_once '../controller/connect.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: ../login.php');
    exit();
}
if (isset($_GET['id'])) {
    $beachId = $_GET['id'];
    $conn = connect();
    $sql = "SELECT * FROM beach WHERE id='$beachId'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $beach = $result->fetch_assoc();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_tmp = $_FILES['image']['tmp_name'];
                $image_name = $_FILES['image']['name'];

                if (move_uploaded_file($image_tmp, $image_name)) {
                    $sql = "UPDATE beach SET name='$name', description='$description' , category='$category' , price='$price', image='../assets/$image_name' WHERE id='$beachId'";
                    $res = $conn->query($sql);
                    if ($res) {
                        header('Location: ../beachpage.php');
                        exit();
                    } else {
                        echo 'Error: ' . $conn->error;
                    }
                } else {
                    echo 'Error: Failed to move the uploaded image.';
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../../layout/head.php'); ?>
    <link rel="stylesheet" href="../css/editbeach.css">
</head>

<body>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="text-center">Edit Beach Page</h3>
            <?php
            $username = $_SESSION['admin']['username'];
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
                        <li><a href="../beachpage.php">Beachs</a></li>
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
                            <h2 style="margin-bottom: 50px;margin-left:43%;">Edit Beach</h2>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Beach Name</label>
                                <input type="text" name="name" id="name" value="<?php echo $beach['name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Beach Description</label>
                                <textarea type="text" name="description" id="description"
                                    value="<?php echo $beach['description']; ?>" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" required>
                                    <?php
                                    $sql = "SELECT * from categories";
                                    $res = $conn->query($sql);
                                    if ($res->num_rows > 0) {
                                
                                        $rows = $res->fetch_all(MYSQLI_ASSOC);
                                        foreach($rows as $cate){
                                            echo '<option value="'. $cate['id'] . '">' .$cate['name'] .'</option>';
                                        }
                                    
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">Beach Price</label>
                                <input type="text" name="price" id="price" value="<?php echo $beach['price']; ?>"
                                    required>
                            </div>
                            <div class="form-group d-flex">
                                <label for="image">Beach Image</label>
                                <input type="file" name="image" id="image" accept="image/*" required>
                                <img id="preview-image" src="#" alt="Preview Image"
                                    style="display: none; max-width: 200px; margin-top: 10px;">
                            </div>
                            <div class="form-group">
                                <label></label>
                                <button type="submit" class="btn btn-primary" name="update">Update Beach</button>
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