<?php
session_start();
if ($_SESSION['role'] == "admin") {
#    echo "<script>alert('Hello Admin!');</script>";
} else{
    header('location: index.php');
    exit();
}
function getBeach() {
    $conn = connect();
    $sql = "SELECT * FROM beaches";
    $result = $conn->query($sql);
    $beachs = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $beachs[] = $row;
        }
    }
    return $beachs;
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('./layouts/header.php');
    ?>
    <link rel="stylesheet" href="./assets/css/beachpage.css">
</head>

<body>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="text-center">Beach Page</h3>
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
                        <li><a href="beachpage.php">Beachs</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="feedback.php">Feedback</a></li>
                        <li><a href="#">Cart</a></li>
                    </ul>
                </div>
            </div>
            <div class="content-2">
                <div class="d-flex align-items-center justify-content-between mb-2" style="background-color: gray;">
                    <h1 style="margin-left:43%;">Beach</h1>
                </div>
                <div class="functions">
                    <a style="margin-top: 20px;margin-bottom:20px;float:right;" class="btn btn-primary"
                        href="./function/addbeach.php">Add new Beach</a>
                </div>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Beach Name</th>
                            <th>Beach Img</th>
                            <th>Beach Description</th>
                            <th>Beach Region</th>
                            <th>Price</th>
                            <th>Sua</th>
                            <th>Xoa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $beachs = getBeach();

                        foreach ($beachs as $beach) {
                            $sql2 = 'SELECT * FROM regions WHERE regions_id="' . $beach['regions_id'] . '"';
                            $result2 = mysqli_query($conn, $sql2);
                            $ridname2 = $result2->fetch_assoc();
                            $ridname = $ridname2["regions_name"];
                            echo "<tr>";
                            echo "<td>" . $beach['beaches_id'] . "</td>";
                            echo "<td>" . $beach['beaches_name'] . "</td>";
                            echo "<td><img src=" . $beach['beaches_img'] . "></td>";
                            echo "<td>" . $beach['beaches_description'] . "</td>";
                            echo "<td>" . $ridname . "</td>";
                            echo '<td><a href="./function/editbeach.php?id=' . $beach['beaches_id'] . '">Sửa</a></td>';
                            echo '<td><a onclick="deletebeach(event, ' . $beach['beaches_id'] . ')" href="#">Xóa</a></td>';
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    function dologout(e) {
        e.preventDefault();
        if (confirm('Bạn có muốn đăng xuất không?')) {
            window.location.href = './logout.php';
        }
    }
    function deletebeach(event, beachId) {
        event.preventDefault();
        if (confirm('Bạn có muốn xóa biển này không?')) {
            window.location.href = './function/deletebeach.php?id=' + beachId;
        }
    }
</script>

</html>