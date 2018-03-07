<?php
require_once('config.php');
// Initialize the session
session_start();
var_dump($_SESSION);
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: index.php");
  exit;
 
}
?>

<!DOCTYPE html>
<html>
<head>
	<script src="assets/jquery-1.12.4.min.js"></script>
	<!--<script src="assets/jquery-3.3.1.js"></script>-->
	<script src="assets/js/bootstrap.min.js"></script>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" type="text/css" href="stile.css">
	<title>Profile</title>
</head> 
<body>
<!-- Include the above in your HEAD tag -->

<div class="container">
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="login.png" class="img-responsive" style="width: 50%; height: 22%; margin: 0 auto;">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<p><?php
							if($_SESSION['username'])
							{
							$SESSION = $_SESSION['username'];
							$sql = mysqli_query($link, "select * from `biodata` where 
							`username` = '$SESSION'");
							$show = mysqli_fetch_assoc($sql);
							echo 'Welcome, <strong style="color: purple; font-size: 20px;">' . $show['fname'] . '</strong>';
							//echo '<p style="color: purple; font-size: 15px;">' . $show['email'] . '</p>'; 
							//echo '<p style="color: purple; font-size: 15px;">' . $show['fname'] . " " . $show['lname'] . '</p>';
							//echo '<p style= "color: purple; font-size: 15px;">' . $show['nik'] . '</p>';
							}
							 ?>
						<p> </p>
						<a class="btn btn-danger" href="logout.php" ><i class="glyphicon glyphicon-trash"></i>Logout</a>&nbsp;
						

					</div>
					<div class="profile-usertitle-job">
						
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->

				<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						</div>
				
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li>
							<a href="home.php">
							<i class="glyphicon glyphicon-home"></i>
							Home </a>
							
						</li>
						<li class="active">
							<a href="profile.php">
							<i class="glyphicon glyphicon-user"></i>
							My Profile </a>
						</li>
						<li>
							<a href=".php">
							<i class="glyphicon glyphicon-ok"></i>
							Jadwal </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
            <div class="profile-content">
           		<img src="login.png" style="border: 2px solid black; height: 150px; width: 150px; float: left; margin-top: 15px;">

          		<h3 style="float: left; text-align: justify; padding-left: 50px;">
          			<p>Nama: <?php echo $show['fname']. " " .$show['lname']; ?></p>
          			<p>Email: <?php echo $show['email']; ?></p>
          			<p>Phone: <?php echo $show['phone']; ?></p>
          			<p>Division: <?php echo $show['division']; ?></p>
          		</h3>  	

          		<a role="button" href="#" class='open_modal btn btn-sm btn-primary' style="float: left; margin-top: 25px; margin-right: 350px;" id='<?php echo  $show['username']; ?>'> <i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;
            </div>
		</div>
	</div>
</div>
<center>
<strong>@ Copyright </strong>
</center>
<br>
<br>
<!-- Javascript untuk popup modal Edit--> 

<script type="text/javascript">
   $(document).ready(function () {
   $(".open_modal").click(function(e) {
      var m = $(this).attr("id");
		   $.ajax({
    			   url: "modal_edit.php",
    			   type: "GET",
    			   data : {nik: m,},
    			   success: function (ajaxData){
      			   $("#ModalEdit").html(ajaxData);
      			   $("#ModalEdit").modal('show',{backdrop: 'true'});

      			   if(response.status == "sukses"){ // Jika Statusnya = sukses
					// Ganti isi dari div view dengan view yang diambil dari proses_simpan.php
					
					/*
					 * Ambil pesan suksesnya dan set ke div pesan-sukses
					 * Lalu munculkan div pesan-sukes nya
					 * Setelah 10 detik, sembunyikan kembali pesan suksesnya
					 */
					$("#pesan-sukses").html(response.pesan).fadeIn().delay(1000).fadeOut();
					
					$("#form input, #form select").val(""); // Untuk meng-clear isian pada form
					$("#form-modal").modal('hide'); // Close / Tutup Modal Dialog
				}else{ // Jika statusnya = gagal
					/*
					 * Ambil pesan errornya dan set ke div pesan-error
					 * Lalu munculkan div pesan-error nya
					 */
					$("#pesan-error").html(response.pesan).show();
				}

      		   },

      		   error: function (xhr, ajaxOptions, thrownError) { // Ketika terjadi error
				alert(xhr.responseText); // munculkan alert
				}

    		   });
        });
      });
</script>
</body>
</html>