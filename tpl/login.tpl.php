
	<div class="container  col-md-6 col-md-offset-3">
		<h2 class="form-signin-heading">Please sign in</h2>
		<form action="functions\login.php" method="POST">
	 		<label class="sr-only">User</label> <input type="text" name="userid" class="form-control" placeholder="User ID" value="<?php if (isset($_SESSION['login'])) { echo $_SESSION['login']; }?>">
			<label class="sr-only">PinCode</label><input type="password" name="pincode" class="form-control" placeholder="Pincode">
			<input type="submit" name="submit" value="Sign In" class="btn btn-lg btn-primary btn-block">
		</form>
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
