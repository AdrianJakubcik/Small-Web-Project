	<div class="cd-secondary-nav">
		<a href="#0" class="cd-secondary-nav-trigger">Menu<span></span></a> <!-- button visible on small devices -->
		<nav>
			<ul>
				<li <?php if($_SERVER['SCRIPT_NAME']=="/TestingArea51/Public/index.php") { ?>  class="active"   <?php   }  ?>>
					<a href="<?php if($_SERVER['PHP_SELF'] == "/TestingArea51/Public/index.php") {echo('../Public?d='.crypt(date('H:i:s_Y-m-d'),bin2hex(random_bytes(12))));} else {echo('../?d='.crypt(date('H:i:s_Y-m-d'),bin2hex(random_bytes(12))));}?>" id="Home">
						<b>Home</b>
						<span></span><!-- icon -->
					</a>
				</li>
				<li <?php if($_SERVER['SCRIPT_NAME']=="/TestingArea51/Public/Login/index.php") { ?>  class="active"   <?php   }  ?>>
					<a href="<?php if($_SERVER['PHP_SELF'] == "/TestingArea51/Public/index.php") {echo('Login?d=' . crypt(date('H:i:s_Y-m-d'),bin2hex(random_bytes(12))));} else {echo('../Login?d='.crypt(date('H:i:s_Y-m-d'),bin2hex(random_bytes(12))));}?>" id="Login">
						<b>Login</b>
						<span class="icons8-login"></span><!-- icon -->
					</a>
				</li>
				<li <?php if($_SERVER['SCRIPT_NAME']=="/TestingArea51/Public/Register/index.php") { ?>  class="active"   <?php   }  ?>>
					<a href="<?php if($_SERVER['PHP_SELF'] == "/TestingArea51/Public/index.php") {echo('Register?d='.crypt(date('H:i:s_Y-m-d'),bin2hex(random_bytes(12))));} else {echo('../Register?d='.crypt(date('H:i:s_Y-m-d'),bin2hex(random_bytes(12))));}?>" id="Register">
						<b>Register</b>
						<span class="icons8-database"></span><!-- icon -->
					</a>
				</li>
				<li <?php if($_SERVER['SCRIPT_NAME']=="/TestingArea51/Public/Contact/index.php") { ?>  class="active"   <?php   }  ?>>
					<a href="#cd-placeholder-4" id="Contact">
						<b>Contact</b>
						<span></span><!-- icon -->
					</a>
				</li>
				<li <?php if($_SERVER['SCRIPT_NAME']=="/TestingArea51/Public/FAQ/index.php") { ?>  class="active"   <?php   }  ?>>
					<a href="#cd-placeholder-5" id="Faq">
						<b>FAQ</b>
						<span></span><!-- icon -->
					</a>
				</li>
			</ul>
		</nav>
	</div>