<?php
session_start();
include('connection.php');

$my_orders=mysqli_query($con,"select * from orders where user_id=".$_SESSION['id']);

if (isset($_GET['cancelorder'])) {
    $oid=$_GET['orderid'];
    $s="cancelled";
    $cancelorder="UPDATE `orders` SET `order_status`='cancelled' WHERE `order_id`='$oid'";
    $uq=mysqli_query($con,$cancelorder);
    header('location:myorders.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
<?php include('topnav.php'); ?>

    <h2>My Orders</h2>

    <table>
        <tr>
            <th>Order Id</th>
            <th>Total Amount</th>
            <th>Address</th>
            <th>Payment Type</th>
            <th>Payment Status</th>
            <th>Order Status</th>
            <th>Cancel Order</th>
        </tr>
        <?php while($row=mysqli_fetch_assoc($my_orders)){?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>
                <td><?php echo $row['address'];?></td>
                <td><?php echo $row['payment_type'];?></td>
                <td><?php echo $row['payment_status']; 
                if($row['payment_status']=='pending'&&$row['payment_type']=='payu'&&$row['order_status']!='cancelled'){
                    echo '&nbsp<a href="insert.php?orderid='.$row['order_id'].'&totalamount='.$row['total_amount'].'&email='.$_SESSION['email'].'&mobile='.$_SESSION['mobile'].'">[Make Online Payment]</a>';
                }?></td>
                <td><?php echo $row['order_status'];?></td>
                <td><?php if($row['order_status']!="cancelled"){echo '<a href="?cancelorder=true&orderid=' . $row['order_id'] . '">Cancel Order</a>';}?></td>
            </tr>
        <?php };
         ?>
    
    </table>
    <a href="welcome.php">Home</a>
</body>

</html>

