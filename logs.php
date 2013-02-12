<?
require_once('functions.php');
require_once('config.php');
require_once('db.php');
require_once('header.php');
if(!isloggedin()){header('location SUBDIR');}
?>
<class="row-fluid">
	<div class="span3">
		<ul class="nav nav-list">
          		<li><a href="import.php"><i class="icon-chevron-right"></i> Import</a></li>
          		<li class="active"><a href="logs.php"><i class="icon-chevron-right"></i> Logs</a></li>
        	</ul>
	</div>
	<div class="span9">
		<h2>Logs</h2>
		<table>
		<thead>
			<th>Inserted</th>
			<th>Description</th>
		</thead>
		<tbody>
		<?
		$query = "SELECT * from logs order by id desc";	
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());
		while ($row = mysql_fetch_assoc($result)) {
			?>
			<tr>
			<td><?=$row['date']?></td>
			<td><?=$row['log']?></td>
			</tr>
			<?
		}
		?>
		</tbody>
		</table>
	</div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.lazyload.js"></script>
<script src="js/jquery.infinitescroll.js"></script>
<script src="js/functions.js"></script>
<? require_once('footer.php'); ?>
