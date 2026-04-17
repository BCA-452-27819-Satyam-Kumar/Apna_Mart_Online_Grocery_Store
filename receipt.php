<?php
include 'config.php';
session_start();

// check admin login
$admin_id = $_SESSION['admin_id'] ?? null;

if(!isset($admin_id)){
   header('location:login.php');
   exit();
}

// get order id
if(!isset($_GET['id'])){
   echo "Invalid ID";
   exit();
}

$order_id = intval($_GET['id']);

// fetch order
$result = mysqli_query($conn, "SELECT * FROM orders WHERE id='$order_id'");

if(mysqli_num_rows($result) == 0){
   echo "Order not found";
   exit();
}

$order = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
   <title>Receipt</title>

   <style>
      body{
         font-family: Arial;
         background:#f2f2f2;
         padding:20px;
      }

      .receipt{
         background:#fff;
         padding:30px;
         width:600px;
         margin:auto;
         border-radius:10px;
         box-shadow:0 0 10px #ccc;
      }

      h2{
         text-align:center;
      }

      .line{
         border-bottom:1px dashed #999;
         margin:10px 0;
      }

      .btn{
         display:block;
         width:120px;
         margin:20px auto;
         padding:10px;
         background:blue;
         color:white;
         text-align:center;
         text-decoration:none;
      }

      @media print{
         .btn{
            display:none;
         }
      }
   </style>
</head>

<body>

<div class="receipt">

<h2>ApnaMart Receipt</h2>

<div class="line"></div>

<p><b>Order ID:</b> <?php echo $order['id']; ?></p>
<p><b>Name:</b> <?php echo $order['name']; ?></p>
<p><b>Phone:</b> <?php echo $order['number']; ?></p>
<p><b>Email:</b> <?php echo $order['email']; ?></p>
<p><b>Address:</b> <?php echo $order['address']; ?></p>

<div class="line"></div>

<p><b>Products:</b> <?php echo $order['total_products']; ?></p>
<p><b>Total Price:</b> ₹<?php echo $order['total_price']; ?></p>

<div class="line"></div>

<p><b>Payment Method:</b> <?php echo $order['method']; ?></p>
<p><b>Status:</b> <?php echo $order['payment_status']; ?></p>

<div class="line"></div>

<p><b>Thank you for shopping!</b></p>

<a href="#" onclick="window.print()" class="btn">Print</a>

</div>

</body>
</html>