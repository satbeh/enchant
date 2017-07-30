<nav>
	<ul class="nav nav-pills nav-stacked">
		<li <?php if($_REQUEST['selectednav'] == "list_sales") echo 'class="active"' ?>>
		<a href="<?php echo APPURL; ?>list_sales">Sales(sales@lt.com)</a>
		</li>
		<li <?php if($_REQUEST['selectednav'] == "list_ws") echo 'class="active"' ?>>
		<a href="<?php echo APPURL; ?>list_ws">Wholesale(wholesale@lt.com)</a>
		</li>
		<li <?php if($_REQUEST['selectednav'] == "list_bec") echo 'class="active"' ?>>
		<a href="<?php echo APPURL; ?>list_bec">PR(bec@lt.com)</a>
		</li>
		<li <?php if($_REQUEST['selectednav'] == "list_hello") echo 'class="active"' ?>>
		<a href="<?php echo APPURL; ?>list_hello">Marketing(hello@lt.com)</a>
		</li>
	</ul>
</nav>