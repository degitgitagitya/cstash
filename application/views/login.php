<?php 
if ($this->session->userdata('login')) {
    if ($this->session->userdata('akses')!='siswa') {
    redirect(site_url('Admin'));
 }else{
    redirect(site_url('Siswa'));
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal Edukasi | Login</title>
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/icons/favicon.ico"/>
    <!-- Font Icon -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/faws/css/font-awesome.min.css">

    <!-- Main css -->
    <link rel="stylesheet"  href="<?php echo base_url(); ?>assets/login/css/style.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
</head>
<body>

    <div class="main">

        
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="<?php echo base_url(); ?>assets/login/images/signin-image.jpg" alt="sing up image"></figure>
                        <p style=" line-height: 120%; text-align: center;">Tidak punya akun? <br> 
                            <a type="button" data-toggle="modal" data-target="#BuatAkun" class="signup-image-link" href="#BuatAkun">Buat Akun</a></p>
                        
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Log In <br> Portal Edukasi</h2>
                        <p style="color :red;"><?php echo $this->session->flashdata('msg'); ?> </p>
                        <form method="POST" class="register-form" id="login-form" action="<?php echo site_url('Welcome/login')?>">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Nomor Induk Siswa" required />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" required />
                            </div>
                            
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Masuk"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="<?php echo base_url(); ?>assets/login/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/login/js/main.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</Html>

<!-- Modal -->
<div class="modal fade" id="BuatAkun" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <!-- <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Buat Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div> -->
  <section class="signup modal-dialog modal-lg" role="document">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form modal-content" style="border-color: white;">

                        <h2 class="form-title">Daftar</h2>
                        <form method="POST" class="register-form" id="register-form" action="<?php echo site_url('Welcome/addSiswa') ?>">
                            <div class="form-group">
                                <label for="name"><i class="fa fa-user"></i></label>
                                <input type="text" name="nama" id="name" placeholder="Nama Lengkap" required />
                            </div>
                             <div class="form-group">
                                <label for="Nomor Induk"><i class="fa fa-address-card-o"></i></label>
                                <input type="text" name="nis" id="nis" placeholder="Nomor Induk Siswa"required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Email"required/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Kata Sandi"required/>
                            </div>
                           <!--  <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div> -->
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="btn btn-primary" value="Daftar"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image modal-content" style="border-color: white; ">
                        <figure><img src="<?php echo base_url(); ?>assets/login/images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link close" type="button" data-dismiss="modal">Sudah Punya Akun</a>
                    </div>
                </div>
            </div>
        </section>
</div>
<!-- Sign up form -->
    
