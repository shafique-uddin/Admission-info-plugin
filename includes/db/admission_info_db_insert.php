<?php 

$wpdb;
$admission_info_tbl_name = $wpdb->prefix.'admission_info_db';
$query = $wpdb->insert(
    $admission_info_tbl_name,
    array(
        'universityName' => $universityName,
        'link' => $post_link,
        'unitName' => $unitName,
        'sscGPA' => $SscGpa,
        'sscGROUP' => $SscGrp,
        'hscGPA' => $HscGpa,
        'hscGROUP' => $HscGrp,
        'totalGPA' => $totalGpa,
        'admission_date' => $admissionDate,
        'postPublish' => $post_publish_date
    )
);

?>