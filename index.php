<?php
include 'config/database.php';
session_start();

if(isset($_SESSION['login'])){
    header('location: admin?menu=');
}
else{

?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'views/partials/head.php'; ?>
</head>
<body>
	<div class="view jarallax custom animated fadeIn" style="background-image: url('assets/img/gradient3.png'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="mask rgba-gradient d-flex justify-content-center align-items-center">
			<div class="container-fluid full-page-container">
				<div class="row h-100 justify-content-center align-items-center">
					<div class="col-lg-4 col-sm-8 animated fadeIn">
                        <section class="form-elegant slow bounceInDown animated">
                            <div class="card" style="">
                              <div class="card-body mx-4">

                                    <div class="row delay-2s fadeIn animated">
                                        <div class="col-12">
                                            <div class="align-items-center">
                                                <div class="text-center"><img src="assets/img/logo.png" width="200px" class="m-lr-auto"></div>
                                                <!--<h1 class="display-4 text-center mt-2 text-white">POS App</h1>-->
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" class="form-login">
                                        <div class="md-form delay-2s fadeIn animated mb-5">
                                            <input type="text" id="username" name="username" class="form-control ">
                                            <label for="username" class="" >USERNAME</label>
                                        </div>
                                        <div class="md-form delay-2s fadeIn animated mb-4">
                                            <input type="password" id="password" name="password" class="form-control ">
                                            <label for="password" class="" >PASSWORD</label>
                                        </div>

                                        <div class="text-center mb-3 delay-2s fadeIn animated">
                                            <button class="btn blue-gradient btn-block btn-rounded z-depth-1a waves-effect waves-light" id="submitlogin">Login</button>
                                        </div>
                              
                                    </form>
                                </div>
                            </div>
                        </section>  
					</div>
				</div>
			</div>
        </div>
    </div>
	<?php include 'views/partials/footer.php'; ?>
    <script type="text/javascript">

        $(document).ready(function(){
            $("#submitlogin").click(function(e){
                e.preventDefault();
                var url_admin    = 'admin/?menu=';
                var url_kasir    = 'admin/?menu=transaksi';
                
                var data = $('.form-login').serialize();
                $.ajax({
                    url     : 'controllers/login.ctrl.php',
                    data    : data, 
                    type    : 'POST',
                    success : function(pesan){
                        console.log(pesan)
                        window.location.href = 'admin/?menu=';
                        
                    },
                });
            });
        });
    </script>
</body>
</html>

<?php
}
?>