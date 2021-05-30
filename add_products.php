
<?php

require('connection.php');
$query ='';

if(isset($_POST['addproduct'])){

  $productname = $_POST['productname'];
  $image = $_POST['image'];
  $productprice = $_POST['productprice'];
  $productdesc = $_POST['productdesc'];
  $category = $_POST['category'];
  $status = $_POST['status'];

  if($status='active'){
    $status=1;
  }else{
    $status=0;
  }

  $sql = "INSERT INTO products (product_name, product_image, product_price, product_description, product_category,
   product_status)
  VALUES ('$productname', '$image', '$productprice', '$productdesc', '$category', '$status')";

  $query = mysqli_query($con,$sql);
  
  header("Refresh:5");

}

?>


<!DOCTYPE html>
<html>
<head>
<style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
</head>
<body>

<h2>Add Product Details</h2>


<div class="container">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <div class="row">
    <div class="col-25">
      <label for="fname">Product Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="fname" name="productname" placeholder="Product name.." required>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Product Image</label>
    </div>
    <div class="col-75">
      <input type="file" id="lname" name="image" required>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fname">Product Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="fname" name="productprice" placeholder="Product Price.." required>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fname">Product Description</label>
    </div>
    <div class="col-75">
      <textarea id="fname" name="productdesc" placeholder="Product description.." required></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="country">Product Category</label>
    </div>
    <div class="col-75">
      <select id="country" name="category">
        <option value="mobiles">Mobiles</option>
        <option value="mensclothing">Mens Clothing</option>
        <option value="womensclothing">Womens Clothing</option>
        <option value="householdelectronics">Household Electronics</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fname">Product Status</label>
    </div>
    <div class="col-75">
      <select id="country" name="status">
        <option name="deactive">Deactive</option>
        <option name="active">Active</option>
      </select>
    </div>
  </div>
  </br></br></br>
  <div class="row">
    <input type="submit" value="Add Product" name="addproduct">
  </div>
  <h4><a href="admin_panel.php"><---Go back to admin panel.</a></h4>
  </form>
  <h1><?php
  
  if($query==1){
  echo "Product added successfully !!!";
  }

  ?></h1>
</div>

</body>
</html>
