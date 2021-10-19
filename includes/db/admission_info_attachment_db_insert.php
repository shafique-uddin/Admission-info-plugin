<?php 

$wpdb;
$admission_info_attach_tbl_name = $wpdb->prefix.'admission_info_attach_db';
$query = $wpdb->insert(
    $admission_info_attach_tbl_name,
    array(
        'universityName' => $universityName,
        'AttchFileName' => $attachedFile_fullName,
        'circularPublish' => $circularPublished,
        'postPublish' => date('d-F-Y')
    )
);

?>