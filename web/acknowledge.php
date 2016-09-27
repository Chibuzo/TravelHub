<?php require_once "includes/header.php";

$headers = "To: Travelhub <admin@travelhub.ng>\r\n";
$headers .= "From: ". $_POST['name'] . "<" . $_POST['email'] . ">\r\n";
$headers .= "Return-Path: info@travelhubng.com.ng\r\n";
$headers .= "Reply-To: admin@travelhub.ng\r\n";

mail('admin@travelhub.ng', 'From Our Website', $_POST['msg'] . "\r\nEmail: {$_POST['email']}", $headers);

?>



<div class="fh5co-about animate-box">
    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
        <h2>Message Acknowledgement</h2>
        <div class="alert alert-success">
            Thank you for contacting us. We will get back to you immediately.
        </div>
    </div>

</div>
<br><br>

<?php require_once "includes/footer.php" ?>
</div>
<script src="js/jquery.waypoints.min.js"></script>

</body>
</html>

