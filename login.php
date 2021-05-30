<?php 
include('connection.php');
session_start();
if(isset($_SESSION['name'])){
  header('location:welcome.php');
}
if(isset($_GET['incorrectcreds'])&&$_GET['incorrectcreds']==true){
  // header('location:welcome.php');
  echo '<script>alert("Incorrect credentials.")</script>';
}
?>

<!DOCTYPE HTML>
<html>

<head>
  <style>
    .error {
      color: #FF0000;
    }
    input[type=text],[type=password], select {
  width: 50%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 50%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

  <h2>Login Page</h2>
  <form method="post" action="checking.php">
    Username: <br><input type="text" name="name" id="name" placeholder="Enter User Name" required>
    <br><br>
    Password: <br><input type="password" name="password" id="password" placeholder="Enter password" required>
    <br><br>
    <span id="error"></span>
    <a data-toggle="modal" href="#myModal">Forget/Change Password?</a>
    <br>
    <input type="submit" name="login" value="Login">
    


    <h4>Don't have an account?<a href="signup.php">Sign Up.</a></h4>
  </form>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Forget/Change Password?</h4>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="emailID">
              <label id="forgotPassword"></label>
            </div>
            
            <button type="button" class="btn btn-default" onclick="forgotPassword()">Submit</button>
          </form>


        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>

    </div>
  </div>

<script>

function forgotPassword(){
  $.post("forgotpassword.php",{emailID:$("#emailID").val()},function(data,status){
    if(data=="sent"){
      $("#forgotPassword").html("Password has been sent on registered mail id.");
      $("#forgotPassword").css("color", "green");
    }else{
      $("#forgotPassword").html("Mail id not registered.");
      $("#forgotPassword").css("color", "red");
    }
  });
}


// function login(){
//     $n=$("#name").val();
//     $p=$("#password").val();

//     $.post("checking.php",{n:$n,p:$p},function(data,status){
//     if(data=="correct"){
//       <?php 
//       $name = $n;
//       $password = $p;

//       $sql = "select * from signup where name = '$name' and password = '$password'";
  
//       $query = mysqli_query($con, $sql);
  
//       $q = mysqli_fetch_assoc($query);
        
//         $_SESSION['name'] = $name;
//         $_SESSION['password'] = $password;
//         $_SESSION['id'] = $q['id'];
//         $_SESSION['email'] = $q['email'];
//         $_SESSION['mobile'] = $q['mobile'];
//         $_SESSION['admin'] = $q['admin'];
//         header('location:welcome.php');

//         ?>
//     }
    
//     if(data=="incorrect"){
//       $("#error").html("Incorrect credentials.");
//       $("#error").css("color", "red");
//     }
//   });
//   }

</script>


</body>

</html>