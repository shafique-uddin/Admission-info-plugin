<?php 
global $wpdb;
$tbl_name = $wpdb->prefix.'admission_info_attach_db';
$results = $wpdb->get_results( 
	"SELECT * FROM $tbl_name" 
);
?>

<div class="wrap">
<h1 class="wp-heading-inline">Attach PDF Circular</h1>
<hr class="wp-header-end">

<form method="POST" enctype="multipart/form-data">
    <table class="table attachment">
        <tr>
            <th>
                <label for="attach_varsity_name">University Name</label>
            </th>
            <td class="mycampus-input-field">
                <input type="text" name="admission_info_attach_varsity_name" id="attach_varsity_name">
            </td>
        </tr>

        <tr>
            <th>
                <label for="attach_varsity_file">Attachment</label>
            </th>
            <td>
                <input type="file" name="admission_info_attach_varsity_file" id="attach_varsity_file">
            </td>
        </tr>

        <tr>
            <th>
                <div class="mycampus-title">
                    <label for="datepicker">Circular Published</label>
                </div>
            </th>
            <td>
                <div class="mycampus-input-field">
                    <input type="text" autocomplete="off" name="admission_info_circular_published_date" id="datepicker" value="<?php if(isset($mylink->admission_date)) echo $mylink->admission_date; ?>">
                </div>
            </td>
        <tr>
            <th>
                <?php 
                    echo submit_button( 'Save', 'button', 'admission_info_attach_frm_save', true, null );
                ?>
            </th>
            <td></td>
    </table>
</form>
<!--
    IF HAVE DATA THEN BELOW TABLE WILL BE SHOWED, OTHERWISE IT WILL BE HIDDEN.
-->
<table class="table table-hover">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Varsity Name</th>
      <th scope="col">Circular Published</th>
      <th scope="col">Post Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    
<?php 
    foreach ($results as $row_info) {
	    $deletelink = admin_url('admin.php?page=admission-info-file-attachment&attachdel='.$row_info->AttachFileId);        
?>
    <tr>
        <td><?php if(isset($row_info)){echo ucfirst($row_info->universityName);} ?></td>
        <td><?php if(isset($row_info)){echo $row_info->circularPublish;} ?></td>
        <td><?php if(isset($row_info)){echo $row_info->postPublish;} ?></td>
        <td>
            <a href="<?php echo $deletelink; ?>">Delete</a>
        </td>
    </tr>
<?php
    }
?>
    
  </tbody>
</table>


		
		
    <div id="ajax-response"></div>
    <div class="clear"></div>
</div>