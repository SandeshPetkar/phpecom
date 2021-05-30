<?php
session_start();

function sendMail($t, $s, $b)
{
  $to = $t;
  $subject = $s;
  $txt = $b;
  $headers = "From: sandeshpetkar@dainiksandesh.co.in" . "\r\n";

  $done = mail($to, $subject, $txt, $headers);
  if ($done) {
    return "Mail send successfully.";
  } else {
    return "Mail not send successfully.";
  }
}

if (isset($_POST['emailSandesh'])) {

  $e = $_POST['emailSandesh'];

  $sql = "select * from signup where email = '$e'";

  $query = mysqli_query($con, $sql);

  $q = mysqli_fetch_assoc($query);

  $count = mysqli_num_rows($query);

  if ($count == '0') {
    $otp = rand(1111, 9999);
    $html = "$otp is your otp.";
    $_SESSION['OTP'] = $otp;

    $done = sendMail($e, "New OTP", $html);

    if ($done == "Mail send successfully.") {
      echo "Mail send successfully.";
    } else {
      echo "Mail not send successfully.";
    }
  } else {
    echo "User Exist";
  }
}

?>

<!DOCTYPE HTML>
<html>

<head>
  <style>
    .error {
      color: #FF0000;
    }

    input[type=text],
    [type=password],
    select {
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

  <h2>Sign Up</h2>
  <form method="post" action="checking.php">
    Username: <br><input type="text" name="name" placeholder="Enter User Name" required>
    <br><br>
    E-mail: <br><input type="text" id="email" name="email" placeholder="Enter Email" required>
    <input type="text" id="checkEmail"><br>
    <input type="button" value="Send OTP" id="sendOTP">
    <input type="text" id="OTP" class="verifyEmailOTP">
    <input type="button" value="Verify OTP" id="verifyOTP" class="verifyEmailOTP">
    <span id="faltu" style="color: green;"></span>
    <br><br>
    Mobile: <br><input type="text" name="mobile" placeholder="Enter Mobile No" required>
    <br><br>
    Password: <br><input type="password" name="password" placeholder="Enter password" required>
    <br><br>
    <input type="submit" name="signup" id="signup" value="Sign Up">
    <h4>Already have an account?<a href="login.php">Login Here.</a></h4>
  </form>

  <script>
    $(function() {
      $("#checkEmail").hide();
      if ($("#checkEmail").val() != "1") {
        $("#signup").attr("disabled", true);
      }



      $(".verifyEmailOTP").hide();

      $("#sendOTP").click(function() {
        if ($("#email").val() != '') {
          $("#sendOTP").hide();
          $("#email").attr("disabled", true);

          $.post("signup.php", {
            emailSandesh: $("#email").val()
          }, function(data, status) {
            if (data == "Mail send") {
              $(".verifyEmailOTP").show();

            }
            if (data == "User Exist") {
              $("#faltu").html("Email id already exists.");
              $("#faltu").css("color", "red");
              $("#sendOTP").show();
              $("#email").attr("disabled", false);
            }
          });
        }
      });

      $("#verifyOTP").click(function() {
        if ($("#OTP").val() != '') {
          $.post("checkOTP.php", {
              OTP: $("#OTP").val()
            },
            function(data, status) {

              if (data == "Wrong") {
                $("#faltu").html("Enter valid OTP.");
                $("#faltu").css("color", "red");
              }
              if (data == "Verified") {
                $(".verifyEmailOTP").hide();
                $("#faltu").html("Email id verified.");
                $("#faltu").css("color", "green");
                $("#checkEmail").val("1");
                if ($("#checkEmail").val() == "1") {
                  $("#signup").attr("disabled", false);
                  $("#email").attr("disabled", false);
                }
              }

            });

        }
      });


    });
  </script>
</body>

</html>