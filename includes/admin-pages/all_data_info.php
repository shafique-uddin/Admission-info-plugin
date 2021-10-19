<?php 

global $wpdb;
$tbl_name = $wpdb->prefix.'admission_info_db';
$results = $wpdb->get_results( 
	"SELECT * FROM $tbl_name" 
);
?>


<div class="wrap">
<h1 class="wp-heading-inline">Varsity unites by gpa</h1>

 <a href="<?php echo admin_url().'admin.php?page=add-new-varsity-info'; ?>" class="page-title-action">Add New Varsity Info</a>
<hr class="wp-header-end">

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Varsity Name</th>
      <th scope="col">Unit</th>
      <th scope="col">Admission Date</th>
      <th scope="col">Publish</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>



<?php foreach ($results as $everyRow) {
	$updatelink = admin_url('admin.php?page=add-new-varsity-info&edit='.$everyRow->id);
	$deletelink = admin_url('admin.php?page=admissioninfo&del='.$everyRow->id);
	?>
    <tr>
      <td><?php echo $everyRow->universityName; ?></td>
      <td><?php echo $everyRow->unitName; ?></td>
      <td><?php echo $everyRow->admission_date; ?></td>
      <td><?php echo $everyRow->postPublish; ?></td>
	    <td>
        <a href="<?php echo $updatelink; ?>">Edit</a> | <a href="<?php echo $deletelink; ?>">Delete</a>
      </td>
    </tr>

<?php } ?>
  </tbody>
</table>
<div id="ajax-response"></div>
<div class="clear"></div>
</div>