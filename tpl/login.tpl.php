<div class="container-fluid">
	<div class="col-sm-4"></div>

<!--FORMULARIO-->
	<div class="col-sm-4" style="background-color: rgba(0,0,0,0.4);">
		<form class ="form-group"  action ="functions\login.php" method ="POST">
			<h2 class="text-center"><font color="white"> Sign in</font></h2>
			<div style ="text-align:center;">
				<?php if (isset($_SESSION['jpg'])) { ?>
				<img src="images/"<?php  echo $_SESSION['jpg']; ?> .jpg" class="img-circle" alt="bio-image" width="200" height="200">
			<?php } else
			{ ?>
				<img src="images/default.png" class="img-circle" style="background-color: #FFFFFF;"  alt="bio-image" width="200" height="200">
			<?php } ?>
			</div>
	</br>
	<!--USER NAME INPUT-->
			<div class="input-group" >
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input id="userid" type="text" class="form-control" name="userid" placeholder="User Name" value= "<?php if (isset($_SESSION['login'])) { echo $_SESSION['login']; }?>" required>
			</div>
	</br>
	<!--PASSWORD INPUT-->
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				<input id="password" type="password" class="form-control" name="pincode" placeholder="Password" required>
			</div>
	<!--CAMPOS PARA RECORDAR, CREAR Y RECUPERAR CUENTA-->
			<div class="checkbox">
				<label><font color="white"> <input type="checkbox"> Remember me</font></label>
			</div>
			<button type="submit"  name="submit" class="btn btn-lg btn-primary btn-block">Log in</button>
			<div class="pull-right">
				<label  class="pull-right"><a href="http://www.google.com">Forgot my password</a></label>
			</div>
	</br>
		</form>
	</div>
	<div class="col-sm-4"></div>
	</div>
<p class="bg-danger" align="center">
			<?php
				if(isset($_SESSION['log']))
				{
					if($_SESSION['log']==2)
						{echo "Empty fields deteted.";}
					if($_SESSION['log']==3)
						{echo "User or PinCode incorrect.";}
				}
				else
				{
					$_SESSION['log']=0;
				}
			?>
		</p>
	</div>
	<div class="clearfix"></div>
</body>
