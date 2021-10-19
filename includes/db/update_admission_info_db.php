<?php 

$wpdb;
$admission_info_tbl_name = $wpdb->prefix.'admission_info_db';
$query = $wpdb->update(
    $admission_info_tbl_name,
    array(
        'universityName' => $universityName,
        'unitName' => $unitName,
        'sscGPA' => $SscGpa,
        'sscGROUP' => $SscGrp,
        'hscGPA' => $HscGpa,
        'hscGROUP' => $HscGrp,
        'totalGPA' => $totalGpa,
        'admission_date' => $admissionDate,
        'postPublish' => $post_publish_date
    ),
    array(
        'id' => $post_id_no
    )
);

?>