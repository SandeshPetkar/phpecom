<?php
session_start();
require('connection.php');

if($admin = 0){
  session_destroy();
  header('location:login.php');
}

$sql = "select * from products";
$query = mysqli_query($con, $sql);


if (isset($_GET['status']) && isset($_GET['id'])) {
  $check_status = $_GET['status'];
  $check_id = $_GET['id'];
  $sql = "update products set product_status='$check_status' where product_id='$check_id'";
  mysqli_query($con, $sql);
  header('location:admin_panel.php');
}

if (isset($_GET['id']) && $_GET['operation']=='delete') {
  $check_id = $_GET['id'];
  $sql = "delete from products where product_id='$check_id'";
  mysqli_query($con, $sql);
  header('location:admin_panel.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .button {
      background-color: #4CAF50;
      /* Green */
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }

    .button3 {
      background-color: #f44336;
      font-weight: bold;
    }

    /* Red */

    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #4CAF50;
      color: white;
    }
    .actions{
      text-decoration: none;
      font-weight: bold;
      color: black;
    }
  </style>
</head>

<body>
  <h1>Admin Panel</h1>
  <a href="add_products.php"><button class="button button3">Add Product</button></a>

  <table id="customers">
    <tr>
      <th>id </th>
      <th>name</th>
      <th>image</th>
      <th>price </th>
      <th>description</th>
      <th>category</th>
      <th>status</th>
      <th>actions</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($query)) {

    ?>
      <tr>
        <td><?php echo $row['product_id']; ?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo '<img src="'.$row['product_image'].'" width="50px" height="50px" object-fit="cover"/>' ?></td>
        <td><?php echo $row['product_price']; ?></td>
        <td><?php echo $row['product_description']; ?></td>
        <td><?php echo $row['product_category']; ?></td>
        <td><?php
            if ($row['product_status'] == 0) {
              echo 'Deactive';
            }
            if ($row['product_status'] == 1) {
              echo 'Active';
            }
            ?></td>
        <td>
          <?php
          if ($row['product_status'] == 0) {
            echo '<a href="?status=1&id=' . $row['product_id'] . '" class="actions">Active</a>&nbsp&nbsp';
          }
          if ($row['product_status'] == 1) {
            echo '<a href="?status=0&id=' . $row['product_id'] . '" class="actions">Deactive</a>&nbsp&nbsp';
          }

          echo '<a href="manage_products.php?operation=edit&id=' . $row['product_id'] . '" class="actions">Edit</a>&nbsp&nbsp';

          echo '<a href="?operation=delete&id=' . $row['product_id'] . '" class="actions">Delete</a>';
          ?>
        </td>
      </tr>
    <?php } ?>
  </table>

</body>

</html>