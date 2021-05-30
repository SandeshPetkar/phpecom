<?php
require('connection.php');

if (isset($_POST['signup'])) {

    
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $password = $_POST['password'];
    // $name = $_POST['name'];
    // $email = $_POST['email'];
    // $mobile = $_POST['mobile'];
    // $password = $_POST['password'];
    $sql = "INSERT INTO signup (name, email, mobile, password)
    VALUES ('$name', '$email', '$mobile', '$password')";

    mysqli_query($con, $sql);
    header('location:login.php');
}

if (isset($_POST['login'])) {
    session_start();
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "select * from signup where name = '$name' and password = '$password'";

    $query = mysqli_query($con, $sql);

    $q = mysqli_fetch_assoc($query);

    $count = mysqli_num_rows($query);
    // var_dump($count);
    // echo $count;

    if ($count=='1') {
        $_SESSION['name'] = $name;
        $_SESSION['password'] = $password;
        $_SESSION['id'] = $q['id'];
        $_SESSION['email'] = $q['email'];
        $_SESSION['mobile'] = $q['mobile'];
        $_SESSION['admin'] = $q['admin'];
        header('location:welcome.php');
    }else{
        header('location:login.php?incorrectcreds=true');
        // echo '<html><body><script>alert("Incorrect credentials.")</script></body></html>';
    }
}

if (isset($_POST['addtocart'])) {
    session_start();
    $quantity = $_POST['quantity'];
    $productid = $_POST['productid'];
    $productprice = $_POST['productprice'];
    $productname = $_POST['productname'];
    $id = $_SESSION['id'];

    $cart = "insert into incart(user_id,p_name,p_price,quantity,p_id) values('$id','$productname','$productprice','$quantity','$productid')";
    mysqli_query($con, $cart);
    // if (isset($_SESSION['cart'])) {

    //     $tof = check_product($productid);
    //     if ($tof == "true") {

    //         header("location:welcome.php");
    //     } else {
    //         $b = array("productid" => $productid, "productname" => $productname, "productprice" => $productprice, "quantity" => $quantity);
    //         $count = count($_SESSION['cart']);
    //         $_SESSION['cart'][$count] = $b;
    //     }
    // } else {
    //     $a = array("productid" => $productid, "productname" => $productname, "productprice" => $productprice, "quantity" => $quantity);
    //     $_SESSION['cart'][0] = $a;
    // }
    // print_r($_SESSION['cart']);

    header('location:welcome.php');
}

function check_product($productid)
{
    $array_of_ids = array_column($_SESSION['cart'], 'productid');
    if (in_array($productid, $array_of_ids)) {
        return "true";
    } else {
        return "false";
    }
}


if (isset($_POST['checkout'])) {
    session_start();
    // $orderid=$_SESSION['name'].uniqid();
    
    $orderid = $_SESSION['name'] . uniqid();

    $in_cart_porducts = mysqli_query($con, "select * from incart where user_id=" . $_SESSION['id']);

    while ($row = mysqli_fetch_assoc($in_cart_porducts)) {

        $id = $row['user_id'];
        $productid = $row['p_id'];
        $productname = $row['p_name'];
        $productprice = $row['p_price'];
        $quantity = $row['quantity'];

        $cart = "insert into orderdetails(order_id,user_id,p_name,p_price,quantity,p_id) values('$orderid','$id','$productname','$productprice','$quantity','$productid')";
        mysqli_query($con, $cart);
    }
    mysqli_query($con, "delete from incart where user_id=" . $_SESSION['id']);

    $totalamount = $_POST['totalamount'];
    $address = $_POST['address'];
    $payment = $_POST['payment'];
    $userid = $_SESSION['id'];

    $orders = "insert into orders(order_id,user_id,total_amount,address,payment_type) values('$orderid','$userid','$totalamount','$address','$payment')";
    mysqli_query($con, $orders);
    header('location:myorders.php');
}
