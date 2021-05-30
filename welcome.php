<?php
require('connection.php');
session_start();
if (isset($_SESSION['name']) && isset($_SESSION['password'])) {
  $id = $_SESSION['id'];
  $admin = $_SESSION['admin'];
} else {
  header('location:signup.php');
}

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
  session_destroy();
  header('location:login.php');
}
//print_r($_SESSION['cart']);
$products = mysqli_query($con, "select * from products where product_status = 1");

function check_product($productid)
{
    $array_of_ids = array_column($_SESSION['cart'], 'productid');
    if (in_array($productid, $array_of_ids)) {
        return "true";
    } else {
        return "false";
    }
}

function disableAddtocart($con,$uid,$pid){
  $q=mysqli_query($con,"select * from incart where user_id='$uid' and p_id='$pid'");
 $no=mysqli_num_rows($q);
 if($no==1){
   return true;
 }else{
   return false;
 }
}
$in_cart_porducts=mysqli_query($con,"select * from incart where user_id=".$_SESSION['id']);
$count = mysqli_num_rows($in_cart_porducts);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  

  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <style>

img {
  width: 100%;
  height: 100%;
}

#mySidenav{
  overflow-x: hidden;
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
}
  </style>

</head>

<body style="background-color: blueviolet;">

<!-- side navigation bar -->
<div class="md:flex flex-col md:flex-row md:min-h-screen w-full" id="mySidenav">

  <div @click.away="open = false" class="flex flex-col w-full md:w-64 text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0" x-data="{ open: false }">
    <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between">
      <a href="#" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">Hi <?php echo $_SESSION['name'] ?>;</a><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <button class="rounded-lg md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
          <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
          <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>
    <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block px-4 pb-4 md:pb-0 md:overflow-y-auto">
      <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-200 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Blog</a>
      <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Portfolio</a>
      <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">About</a>
      <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Contact</a>
      <div @click.away="open = false" class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
          <span>Dropdown</span>
          <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
          <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #1</a>
            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #2</a>
            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #3</a>
          </div>
        </div>
      </div>
    </nav>
  </div>
  
</div>

<!-- side navigation bar end-->

  <header class="text-gray-600 body-font bg-red-500">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
      <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
        </svg>
        <span class="ml-3 text-xl font-extrabold" onclick="openNav()">My cart</span>
      </a>
      <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
        
        <a class="mr-5 hover:text-gray-900 text-white font-extrabold " href="welcome.php">Home</a>
        <a class="mr-5 hover:text-gray-900 text-white font-extrabold " href="myorders.php">My Orders</a>
        <a class="mr-5 hover:text-gray-900 text-white font-extrabold " href="cart.php">Shopping Cart (<span><?php
                                                                                                                          echo $count;
                                                                                                                          ?>)</span></a>
      </nav>
      <?php
      if ($_SESSION['admin'] == 1) {
        echo '<h3><a href="admin_panel.php" class="mr-5 hover:text-gray-900 text-white font-extrabold ">Go to admin panel.</a></h3>';
      }
      echo '<h3><a href="?logout=1">
    
    <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">Logout
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
      </svg>
    </button>

    </a></h3>';
      ?>

    </div>
  </header>

  Welcome <?php echo $_SESSION['name'] ?>

  <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
      <div class="flex flex-wrap -m-4">

        <?php


        while ($row = mysqli_fetch_assoc($products)) { ?>

          <div class="lg:w-1/4 md:w-1/2 p-4 w-full bg-yellow-400 border-gray-900">
            <a class="block relative h-40 rounded overflow-hidden">
              <?php echo '<img alt="ecommerce" class="object-contain w-30 h-30 block" src="' . $row['product_image'] . '">'; ?>
            </a>
            <div class="mt-4">

              <?php echo '<h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">' . $row['product_category'] . '</h3>'; ?>
              <?php echo '<h2 class="text-gray-900 title-font text-lg font-medium">' . $row['product_name'] . '</h2>'; ?>
              <?php echo '<p class="mt-1">' . $row['product_price'] . '</p>'; ?>
              
              <form action="checking.php" method="post">
                Quantity(max 50.) : <input type="number" name="quantity" value="1" min="1" max="50" style="border: 3px solid #ccc"><br><br>
                <input type="hidden" name="productid" value="<?php echo $row['product_id']; ?>">
                <input type="hidden" name="productname" value="<?php echo $row['product_name']; ?>">
                <input type="hidden" name="productprice" value="<?php echo $row['product_price']; ?>">
                
                <?php
                $checkProduct=disableAddtocart($con,$_SESSION['id'],$row['product_id']);
                if($checkProduct==false){
                  echo '<input type="submit" name="addtocart" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" value="Add to cart">';
                }
                // $fot=check_product($row['product_id']);
                // if($fot=="true"){
                //   echo '<input type="submit" name="addtocart" value="Remove from cart">';
                // }else{
                //   echo '<input type="submit" name="addtocart" value="Add to cart">';
                // }
                ?>
              </form>

            </div>
          </div>

        <?php } ?>

      </div>
    </div>
  </section>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>

</body>

</html>