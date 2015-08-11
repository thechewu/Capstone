<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" 
      type="image/png" 
      href="assets/img/favicon.png">
	<title>Learning Management System</title>
	<link rel="stylesheet" href="assets/css/bootstrap.sandstorm.min.css"/>	
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/ckeditor/ckeditor.js"></script>	
	<script src="assets/ckeditor/adapters/jquery.js"></script>	
	<script src="assets/js/color.animate.js"></script>
	<link rel="stylesheet" href="assets/css/lms_main.css"/>	
</head>
<body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="<?=base_url()?>index.php?/home"><div id="logo"></div></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?if($active == 0):?>class="active"<?endif;?>><a href="<?=base_url()?>index.php?/home">Home</a></li>
            <li <?if($active == 1):?>class="active"<?endif;?>><a href="<?=base_url()?>index.php?/questions">Quizzes</a></li>
            <li <?if($active == 2):?>class="active"<?endif;?>><a href="<?=base_url()?>index.php?/lectures">Lectures</a></li>
			<?if($this->ion_auth->logged_in()):?>
			<li <?if($active == 6):?>class="active"<?endif;?>><a href="<?=base_url()?>index.php?/ias">IAS</a></li>
			<?endif;?>
          </ul>
		  
		  <ul class="nav navbar-nav navbar-right">
		  
		  <?if($this->ion_auth->logged_in()){?>
			<!--<li><div style="width:50px;margin-top:5px;height:50px;border:2px solid white;background-size:contain;border-radius:50%;background-image:url(userimg/<?=$this->ion_auth->user()->row()->image?>)"></div></li>-->
			<li <?if($active == 3):?>class="active"<?endif;?>><a href="<?=base_url()?>index.php?/user"><img class="header-profile" src="userimg/<?=$this->ion_auth->user()->row()->image?>"/><?=$this->ion_auth->user()->row()->first_name?></a></li>
			<li><a href="<?=base_url()?>/index.php?/auth/logout">Log Out</a></li>
		  <?}else{?>
			<li <?if($active == 4):?>class="active"<?endif;?>><a href="<?=base_url()?>index.php?/auth/login">Login</a></li>
			<li <?if($active == 5):?>class="active"<?endif;?>><a href="<?=base_url()?>index.php?/auth/create_user">Register</a></li>
		  <?}?>
		  </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>