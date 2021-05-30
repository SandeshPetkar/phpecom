<?php
session_start();
include('connection.php');

$emailID = $_POST['emailID'];

$sql = "select * from signup where email = '$emailID'";

$query = mysqli_query($con, $sql);

$q = mysqli_fetch_assoc($query);

$count = mysqli_num_rows($query);
// echo $count;
// echo $emailID;

if ($count == 1) {
    $password=$q['password'];
    $html = "Your password is $password.";

    include('smtp/PHPMailerAutoload.php');
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->Username = "sandeshpetkar2@gmail.com";
    $mail->Password = "andeshpet";
    $mail->SetFrom("sandeshpetkar2@gmail.com");
    $mail->addAddress($emailID);
    $mail->IsHTML(true);
    $mail->Subject = "Registered Password";
    $mail->Body = $html;
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    echo "sent";
} else {
    echo 'not sent';
}
