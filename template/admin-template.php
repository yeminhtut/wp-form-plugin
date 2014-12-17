<?php 
global $wpdb;
$result = $wpdb->get_results( 'SELECT * FROM t_contest LIMIT 5', OBJECT );

?>
<div class="wrap">
<form action="" method="get">
<div class="tablenav top">
	<div class="tablenav-pages one-page"><span class="displaying-num">1 item</span>
	<span class="pagination-links"><a class="first-page disabled" title="Go to the first page" href="http://localhost/blog/wp-admin/users.php">«</a>
	<a class="prev-page disabled" title="Go to the previous page" href="http://localhost/blog/wp-admin/users.php?paged=1">‹</a>
	<span class="paging-input">
		<label for="current-page-selector" class="screen-reader-text">Select Page</label>
		<input class="current-page" id="current-page-selector" title="Current page" type="text" name="paged" value="1" size="1"> of <span class="total-pages">1</span>
	</span>
	<a class="next-page disabled" title="Go to the next page" href="http://localhost/blog/wp-admin/users.php?paged=1">›</a>
	<a class="last-page disabled" title="Go to the last page" href="http://localhost/blog/wp-admin/users.php?paged=1">»</a></span></div>
	<br class="clear">
</div>
<table class="wp-list-table widefat fixed users">
<thead>
	<tr>
	<th scope="col" id="username" class="manage-column column-username sortable desc" style="">		
			<span>ID</span></span>		
	</th>
	<th scope="col" id="name" class="manage-column column-name sortable desc" style="">		
			<span>Name</span>		
	</th>
	<th scope="col" id="email" class="manage-column column-email sortable desc" style="">
		<span>E-mail</span>
	</th>
	</tr>
</thead>
<tbody id="the-list" data-wp-lists="list:user">
<?php foreach ($result as $result) { ?>
	<tr id="user-1" class="alternate">
		<td class="username column-username"><?= $result->Submission_ID?></td>
		<td class="name column-name"><?= $result->Name?></td>
		<td class="email column-email"><?= $result->Email?></td>
	</tr>	
<?php } ?>	
	
	</tbody>
</table>
</form>
<br class="clear">
</div>
