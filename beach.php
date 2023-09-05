<?php
require_once '.\layouts\header.php';
?>

<section class='py-5'>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['beach_id'])) {
    $beachId = $_GET['beach_id'];

  $sql = 'SELECT * FROM beaches WHERE beaches_id="' . $beachId . '"';
  $result = mysqli_query($conn, $sql);  
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $rid = $row["regions_id"];
      $nid = $row["nations_id"];
      $sql3 = 'SELECT * FROM nations WHERE nations_id="' . $nid . '"';
      $result3 = mysqli_query($conn, $sql3);  
      $nidname2 = $result3->fetch_assoc();
      $nidname = $nidname2["nations_name"];
      $sql2 = 'SELECT * FROM regions WHERE regions_id="' . $rid . '"';
      $result2 = mysqli_query($conn, $sql2);  
      $ridname2 = $result2->fetch_assoc();
      $ridname = $ridname2["regions_name"];
      $address = $row["beaches_address"];
      $img = $row["beaches_img"];
      $name = $row["beaches_name"];
      $rate = $row["beaches_rating"];
      $desc = $row["beaches_description"];
      echo "<div class='container'>
<div class='row gx-5'>
  <aside class='col-lg-6'>
    <div class='border rounded-4 mb-3 d-flex justify-content-center'>
      <a data-fslightbox='mygalley' class='rounded-4' target='_blank' data-type='image' href='" . $img . "'>
        <img style='max-width: 100%; max-height: 100vh; margin: auto;' class='rounded-4 fit' src='" . $img . "' />
      </a>
    </div>
    <div class='d-flex justify-content-center mb-3'>
      <a data-fslightbox='mygalley' class='border mx-1 rounded-2' target='_blank' data-type='image' href='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big1.webp' class='item-thumb'>
        <img width='60' height='60' class='rounded-2' src='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big1.webp' />
      </a>
      <a data-fslightbox='mygalley' class='border mx-1 rounded-2' target='_blank' data-type='image' href='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big2.webp' class='item-thumb'>
        <img width='60' height='60' class='rounded-2' src='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big2.webp' />
      </a>
      <a data-fslightbox='mygalley' class='border mx-1 rounded-2' target='_blank' data-type='image' href='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big3.webp' class='item-thumb'>
        <img width='60' height='60' class='rounded-2' src='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big3.webp' />
      </a>
      <a data-fslightbox='mygalley' class='border mx-1 rounded-2' target='_blank' data-type='image' href='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big4.webp' class='item-thumb'>
        <img width='60' height='60' class='rounded-2' src='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big4.webp' />
      </a>
      <a data-fslightbox='mygalley' class='border mx-1 rounded-2' target='_blank' data-type='image' href='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big.webp' class='item-thumb'>
        <img width='60' height='60' class='rounded-2' src='https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big.webp' />
      </a>
    </div>
    <!-- thumbs-wrap.// -->
    <!-- gallery-wrap .end// -->
  </aside>
<main class='col-lg-6'>
    <div class='ps-lg-3'>
      <h5 class='title text-dark'>
      " . $name . " <br />
      </h5>
      <p>Nations: " . $nidname . "</p>
      <p>Regions: " . $ridname . "</p>
      <div class='d-flex flex-row my-3'>
        <div class='text-warning mb-1 me-2'>
          <i class='fa fa-star'></i>
          <i class='fa fa-star'></i>
          <i class='fa fa-star'></i>
          <i class='fa fa-star'></i>
          <i class='fas fa-star-half-alt'></i>
          <span class='ms-1'>
           " . $rate . "
          </span>
        </div>           
      </div>
      <p>
      " . $desc . "
      </p>
      <a href='feedback.php' class='btn btn-warning shadow-0'> Feedback </a>
      <a href='#' class='btn btn-primary shadow-0'> <i class='me-1 fa fa-shopping-basket'></i> Download </a>
    </div>
  </main>
</div>
</div>
</section>
<!-- content -->
<iframe src='" . $address . "' width='100%' height='200' style='border:0;' allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>
";
    }
  } else {
    echo '<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Page Not Found</title>
  <style>
      body {
          background-color: #f8f8f8;
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
      }

      .container {
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
          text-align: center;
      }

      .error-code {
          font-size: 120px;
          font-weight: bold;
          color: #333;
      }

      .error-message {
          margin-top: 20px;
          font-size: 24px;
          color: #777;
      }
  </style>
</head>
<body>
  <div class="container">
      <div class="error">
          <div class="error-code">404</div>
          <div class="error-message">Page Not Found</div>
      </div>
  </div>
</body>';
  }
} else {
  echo '<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Page Not Found</title>
  <style>
      body {
          background-color: #f8f8f8;
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
      }

      .container {
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
          text-align: center;
      }

      .error-code {
          font-size: 120px;
          font-weight: bold;
          color: #333;
      }

      .error-message {
          margin-top: 20px;
          font-size: 24px;
          color: #777;
      }
  </style>
</head>
<body>
  <div class="container">
      <div class="error">
          <div class="error-code">404</div>
          <div class="error-message">Page Not Found</div>
      </div>
  </div>
</body>';
}}
?>
<section class='bg-light border-top py-4'>

<?php
require_once './layouts/footer.php';
?> 
</div>