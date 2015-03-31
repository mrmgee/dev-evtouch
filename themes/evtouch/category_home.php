<?php  
defined('C5_EXECUTE') or die("Access Denied.");
global $c;
global $u;
$this->inc('elements/header-home.php'); ?>

	<div id="main-content-container" class="grid_24">
		<div id="main-content-inner">
		
			<?php
			/*
			if ($u -> isLoggedIn ()) {	//ONLY display if logged-in
				$a = new Area('Main');
				$a->display($c);
			}
			*/
			if ($c->isEditMode()) {
				$hn = new Area('HomeNav');
				$homenavBl = $hn->getAreaBlocksArray($c);
				foreach ($homenavBl as $homenav) {
					$homenav->display();
				}
			} else {
				$hn = new Area('HomeNav');
				$hn->display($c);
			}
			?>
			
			<div id="content"></div>
		</div><!-- END main-content-inner -->
	
	</div>
	
	<!-- end full width content area -->
	
<?php  $this->inc('elements/footer-home.php'); ?>