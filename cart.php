<?php
session_start();
include('connection.php');
$total_amount=0;

$in_cart_porducts=mysqli_query($con,"select * from incart where user_id=".$_SESSION['id']);
$count = mysqli_num_rows($in_cart_porducts);

if (isset($_GET['removefromcart'])&&$_GET['removefromcart']=='true') {
    $pid=$_GET['id'];
    $delete="delete from incart where p_id=".$pid." and user_id=".$_SESSION['id'];
    mysqli_query($con,$delete);
    header('location:cart.php');
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

    <h2>Shopping Cart</h2>

    <table style="background-color: yellowgreen;">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Amount</th>
            <th>Action</th>
        </tr>
        <?php while($row=mysqli_fetch_assoc($in_cart_porducts)){?>
            <tr>
                <td><?php echo $row['p_name']; ?></td>
                <td><?php echo $row['p_price']; ?></td>
                <td><?php echo $row['quantity']?></td>
                <td><?php
                    $total_amount += $row['p_price'] * $row['quantity'];
                    echo $row['p_price'] * $row['quantity']; ?></td>
                    <td><?php echo '<a href="?removefromcart=true&id=' . $row['p_id'] . '">Delete</a>';?></td>
            </tr>
        <?php };
         ?>
        <tr>
            <th></th>
            <th></th>
            <th>Total Amount</th>
            <th><?php echo $total_amount; ?></th>
            <th></th>
        </tr>
    </table>
    <a href="welcome.php">Home</a>
<?php if ($count>0){echo '
    <form action="checking.php" method="POST">
    Enter an address for delivering products:</br><textarea rows = "5" cols = "50" name = "address"></textarea></br>
    Payment Type: <input type="radio" name="payment" value="cod">cod &nbsp;&nbsp;  <input type="radio" name="payment" value="payu">payu </br>
    <input type="hidden" name="totalamount" value="'.$total_amount.'">
    <input type="submit" name="checkout" value="Place Order">
    </form>';}

    ?>
</body>

</html>

