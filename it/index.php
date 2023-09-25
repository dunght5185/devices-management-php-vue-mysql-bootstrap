<?php $option = $_GET['option']; ?>
<section id="menu">
	<div class="container-fluid">
		<ul class="links">
			<li<?php echo ($option == 'device' || $option == NULL)? ' class="active"' : ''; ?>><a href="index.php?view=IT&option=device">Thiết Bị</a></li>
			<li<?php echo ($option == 'card')? ' class="active"' : ''; ?>><a href="index.php?view=IT&option=card">Thẻ Từ</a></li>
			<li<?php echo ($option == 'ip')? ' class="active"' : ''; ?>><a href="index.php?view=IT&option=ip">IP Tĩnh</a></li>
		</ul>
	</div>
</section>
<?php
if ($option == 'device')
{
	include 'device/index.php';
} 
elseif ($option == 'card')
{
	include 'card/index.php';
}
elseif ($option == 'ip')
{
	include 'ip/index.php';
}
else
{
	include 'device/index.php';
}