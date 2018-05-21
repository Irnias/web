<div class="container-fluid">
	<div class="col-sm-4"></div>

	<div class="col-sm-4" style="background-color: rgba(0,0,0,0.4);">
    <form class ="form-group"  action ="functions\changepassword.php" method ="POST">
    <!--Actual PASSWORD INPUT-->
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				<input id="actual_password" type="password" class="form-control" name="actual_password" placeholder="Password" required>
			</div>
    <!--NEW PASSWORD INPUT-->
    <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				<input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password" required>
			</div>
    <!--NEW PASSWORD RE-INPUT-->
    <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				<input id="new_re_password" type="password" class="form-control" name="new_re_password" placeholder="Re enter the new Password" required>
			</div>   
	</br>
	<button type="submit"  name="submit" class="btn btn-lg btn-primary btn-block">Log in</button>
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
