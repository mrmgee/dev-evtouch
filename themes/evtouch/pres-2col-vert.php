<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header-app.php'); ?>
	
	

	<div id="main-content-container" class="grid_16 pres-2col-vert">
		<div id="main-content-inner">
		
			<div class="aTop">
			<?php  
			$t = new Area('Top');
			$t->display($c);
			?>
			</div><!-- END aTop -->
			
			<div class="aLeft">
			<?php
			$l = new Area('Left');
			$l->display($c);
			?>
			</div><!-- END aLeft -->

			<div class="aRight">
			<?php
			$r = new Area('Right');
			$r->display($c);
			?>
			</div><!-- END aRight -->
			
			<div class="aBottom">
			<?php
			$b = new Area('Bottom');
			$b->display($c);
			?>
			</div><!-- END aBottom -->
			
			<?php
			$a = new Area('Main');
			$a->display($c);
			?>
			
		</div>
	<div class="clear"></div>
	</div><!-- END main-content-container -->

	<!-- end main content columns -->
	<div class="clear"></div>
	
<?php  $this->inc('elements/footer-app.php'); ?>
