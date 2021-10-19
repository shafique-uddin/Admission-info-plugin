<?php 
/**
* Plugin Name
*
* @package           PluginPackage
* @author            Your Name
* @copyright         2019 Your Name or Company Name
* @license           GPL-2.0-or-later
*
* @wordpress-plugin
* Plugin Name:       Admission Info
* Plugin URI:        https://example.com/plugin-name
* Description:       Description of the plugin.
* Version:           1.0.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Muhammad Shafique Uddin
* Author URI:        https://example.com
* Text Domain:       admission_info
* License:           GPL v2 or later
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/
 
 // ADMISSION INFO DB VERSION
 global $admission_info_define_db_version;
 $admission_info_define_db_version = '1.1.1';
 
/**
* Activate the plugin.
*/
function admission_info_installing_db() { 
    global $admission_info_define_db_version;
    global $wpdb;
    $db_collate = $wpdb->get_charset_collate();
    $admission_info_details_tbl = $wpdb->prefix.'admission_info_db';

    $basic_admission_info_start_tbl_query = "CREATE TABLE $admission_info_details_tbl (
        id INT(250) NOT NULL AUTO_INCREMENT,
        universityName VARCHAR(250) NOT NULL,
        unitName VARCHAR(250) NOT NULL,
        sscGPA FLOAT(20) NOT NULL,
        sscGROUP VARCHAR(250) NOT NULL,
        hscGPA FLOAT(20) NOT NULL,
        hscGROUP VARCHAR(250) NOT NULL,
        totalGPA FLOAT(20) NOT NULL,
        admission_date VARCHAR(250) NOT NULL,
        postPublish VARCHAR(250) NOT NULL,
        PRIMARY KEY  (id)
    )$db_collate;";
    

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta( $basic_admission_info_start_tbl_query );
    
    add_option( 'admission_info_db_version_value', "$admission_info_define_db_version");

    $wpdb->insert(
        $admission_info_details_tbl,
        array(
            'universityName' => 'Sample Data',
            'unitName' => 'Sample Data',
            'sscGPA' => 5.00,
            'sscGROUP' => 'Sample Data',
            'hscGPA' => 3.63,
            'hscGROUP' => 'Sample Data',
            'totalGPA' => 7.00,
            'admission_date' => 'Sample Data',
            'postPublish' => 'Sample Data',
        )
    );



    // PDF ATTACHMENT TABLE CREATE
    $admission_info_pdf_attach_tbl = $wpdb->prefix.'admission_info_attach_db';

    $admission_info_attach_tbl_query = "CREATE TABLE $admission_info_pdf_attach_tbl (
        AttachFileId INT(250) NOT NULL AUTO_INCREMENT,
        universityName VARCHAR(250) NOT NULL,
        AttchFileName VARCHAR(250) NOT NULL,
        circularPublish VARCHAR(250) NOT NULL,
        postPublish VARCHAR(250) NOT NULL,
        PRIMARY KEY  (AttachFileId)
    )$db_collate;";

    dbDelta( $admission_info_attach_tbl_query );
    $wpdb->insert(
        $admission_info_pdf_attach_tbl,
        array(
            'universityName' => 'Sample Data',
            'circularPublish' => 'Sample Data',
            'postPublish' => 'Sample Data'
        )
    );


    // Clear the permalinks after the post type has been registered.
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'admission_info_installing_db');

 
 
/**
* Deactivation hook.
*/
function admission_info_deactivation_db_info() {
    global $admission_info_define_db_version;
    global $wpdb;
    $admission_info_details_tbl = $wpdb->prefix.'admission_info_db';

    $admission_info_details_tbl_sample_data_clean_query = "DELETE FROM $admission_info_details_tbl WHERE postPublish LIKE 'Sample Data'";
    $wpdb->query($admission_info_details_tbl_sample_data_clean_query);

    $admission_info_pdf_attach_tbl = $wpdb->prefix.'admission_info_attach_db';
    $admission_info_pdf_attach_tbl_sample_data_clean_query = "DELETE FROM $admission_info_pdf_attach_tbl WHERE postPublish LIKE 'Sample Data'";
    $wpdb->query($admission_info_pdf_attach_tbl_sample_data_clean_query);


    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'admission_info_deactivation_db_info' );


/**
 * Database Update hook.
 */
function admission_info_update_checking_hndl(){
    global $admission_info_define_db_version;
    global $wpdb;
    $db_tbl_name = $wpdb->prefix.'admission_info_db';

    if(get_option( 'admission_info_db_version_value' ) != $admission_info_define_db_version){
        $query = "CREATE TABLE $db_tbl_name (
            id INT(250) NOT NULL AUTO_INCREMENT,
            universityName TEXT(250) NOT NULL,
            unitName TEXT(250) NOT NULL,
            sscGPA FLOAT(20) NOT NULL,
            sscGROUP TEXT(250) NOT NULL,
            hscGPA FLOAT(20) NOT NULL,
            hscGROUP TEXT(250) NOT NULL,
            totalGPA FLOAT(20) NOT NULL,
            admission_date TEXT(250) NOT NULL,
            postPublish TEXT(250) NOT NULL,
            PRIMARY KEY (id)
        )$db_collate;";
    
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta( $query );
    
        update_option( 'admission_info_db_version_value', "$admission_info_define_db_version");
    
        $wpdb->update(
            $db_tbl_name,
            array(
                'universityName' => 'Sample Data',
                'unitName' => 'Sample Data',
                'sscGPA' => 5.00,
                'sscGROUP' => 'Sample Data',
                'hscGPA' => 3.63,
                'hscGROUP' => 'Sample Data',
                'totalGPA' => 7.00,
                'admission_date' => 'Sample Data',
                'postPublish' => 'Sample Data',
            ),
            array(
                'id' => 1
            )
        );


        // IF NEED ANY COLUMN DELETE
    }
}
add_action( 'plugins_loaded', 'admission_info_update_checking_hndl' );


/**
 * Admin menu page
 */
function admission_info_admin_menu_hndlr(){
    add_menu_page( 'Admission Information', 'Admission Info', 'manage_options', 'admissioninfo', 'admission_info_all_varsity_info_hndlr', 'dashicons-database-view' );
    add_submenu_page( 'admissioninfo', 'All Varsity', 'All Varsity', 'manage_options', 'admissioninfo' );
    add_submenu_page( 'admissioninfo', 'Add Varsity', 'Add Varsity', 'manage_options', 'add-new-varsity-info', 'admission_info_add_new_info_frm_hndlr' );
    add_submenu_page( 'admissioninfo', 'Admission Info File Attachment', 'Attachment', 'manage_options', 'admission-info-file-attachment', 'admission_info_file_attachment_frm_hndlr' );
}
add_action('admin_menu','admission_info_admin_menu_hndlr');


/**
 * All Varsity Information page Handler 
 */
function admission_info_all_varsity_info_hndlr(){
    include_once('includes/admin-pages/all_data_info.php');
}


/**
 * Delete Data From All Varsity Info Page
 */
if(isset($_GET['del'])){
    global $wpdb;
    $db_tbl_name = $wpdb->prefix.'admission_info_db';
    $tbl_id = (int) $_GET['del'] ;
    $wpdb->delete( "$db_tbl_name", array( 'ID' => $tbl_id ) );
    header('Location: '.admin_url( 'admin.php?page=admissioninfo'));
}


/**
 * Delete Data From ATTACHMENT TABLE BY ID (ADMIN ATTACHMENT PAGE INFO)
 */
if(isset($_GET['attachdel'])){
    global $wpdb;
    $db_tbl_name = $wpdb->prefix.'admission_info_attach_db';
    $tbl_id = (int) $_GET['attachdel'] ;

    $wpdb->delete( "$db_tbl_name", array( 'AttachFileId ' => $tbl_id ) );
    header('Location: '.admin_url( 'admin.php?page=admission-info-file-attachment'));
}


/**
 * Add New Varsity Information page Handler
 */
function admission_info_add_new_info_frm_hndlr(){
    include_once ('includes/admin-pages/form.php');
}


/**
 * ADMIN ATTACHMENT FILE page Handler
 */
function admission_info_file_attachment_frm_hndlr(){
    include_once ('includes/admin-pages/attachment.php');
}


/**
 * Plugin Admin Menu Page Styling
 * Add CSS AND JS
 */
function admission_info_admin_page_CSS_JS_include_hndlr($screen){
    if(('toplevel_page_admissioninfo' == $screen)||('admission-info_page_add-new-varsity-info' == $screen) || ('admission-info_page_admission-info-file-attachment' == $screen)){
        wp_enqueue_style( 'admission-info-custom-css', plugin_dir_url( __FILE__ ).'admin/css/main.css', null, time() );
        wp_enqueue_style( 'admission-info-bootstrap-css-handler', '//cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css');
        wp_enqueue_style( 'admission-info-date-picker-stylesheet', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        wp_enqueue_style( 'admission-info-date-picker-demo-stylesheet', '/resources/demos/style.css');
       wp_enqueue_script( 'admission-info-main-jquery', plugin_dir_url( __FILE__ ).'admin/js/main.js', null , null , true );
       wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-1.12.4.js', array('json2'), '1.12.4', true );
       wp_enqueue_script( 'jquery-ui-datepicker', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), '1.11.4', true );
    }
}
add_action( 'admin_enqueue_scripts', 'admission_info_admin_page_CSS_JS_include_hndlr', 1);



/**
 * Admin Admission Info Pages Notice
 */
 ################################### EMPTY FIELD NOTICE ###################################
function empty_field_callable_hndler(){ ?>
    <div class="notice notice-error is-dismissible">
        <p>
            <?php _e("All Field is Empty. Please Check Again."); ?>
        </p>
    </div>
<?php 
}

################################### SINGLE EMPTY FIELD NOTICE ###################################
function admission_info_admin_single_empty_field_notice(){?>
    <div class="notice notice-warning is-dismissible">
        <p>
            <?php _e("Please Check, All Field Must Be Filled Up. There Some Field is Empty."); ?>
        </p>
    </div>
<?php
}
################################### SINGLE EMPTY FIELD NOTICE ###################################
function admission_info_admin_data_insert_success_notice(){?>
    <div class="notice notice-success is-dismissible">
        <p>
            <?php _e("Your Data Successfully Inserted."); ?>
        </p>
    </div>
<?php
}

################################### ATTACHMENT PAGE EMPTY ATTACH FIELD NOTICE ###################################
function no_attach_file_callable_hndler(){?>
    <div class="notice notice-error is-dismissible">
        <p>
            <?php _e("Attach Field is Empty. Please Check Again."); ?>
        </p>
    </div>
<?php 
}
################################### ADMIN NOTICE SECTION IS END ###################################


// FORM SUBMIT AND CHECKING
if(isset($_POST['admission_info_save'])){
    if(empty(mb_strlen($_POST['unversity_name'])) && empty(mb_strlen($_POST['unit_name'])) && empty(mb_strlen($_POST['ssc_gpa'])) && !isset($_POST['ssc_group']) && empty(mb_strlen($_POST['hsc_gpa'])) && !isset($_POST['hsc_group']) && empty(mb_strlen($_POST['total_gpa'])) && empty(mb_strlen($_POST['admission_date']))){
        add_action( 'admin_notices', 'empty_field_callable_hndler' );
    }
    elseif(empty(mb_strlen($_POST['unversity_name'])) || empty(mb_strlen($_POST['unit_name'])) || empty(mb_strlen($_POST['ssc_gpa'])) || !isset($_POST['ssc_group']) || empty(mb_strlen($_POST['hsc_gpa'])) || !isset($_POST['hsc_group']) || empty(mb_strlen($_POST['total_gpa'])) || empty(mb_strlen($_POST['admission_date']))){
        add_action( 'admin_notices', 'admission_info_admin_single_empty_field_notice' );
    }
    else{
        $universityName = sanitize_text_field( $_POST['unversity_name']);
        $unitName = sanitize_text_field( $_POST['unit_name']);
        $SscGpa = sanitize_text_field( $_POST['ssc_gpa']);
        $SscGrp = $_POST['ssc_group'] ? sanitize_text_field( $_POST['ssc_group']):' ';
        $HscGpa = sanitize_text_field( $_POST['hsc_gpa']);
        $HscGrp = $_POST['hsc_group'] ? sanitize_text_field( $_POST['hsc_group']) : ' ';
        $totalGpa = sanitize_text_field( $_POST['total_gpa']);
        $admissionDate = sanitize_text_field( $_POST['admission_date']);
        $post_publish_date = sanitize_text_field( $_POST['publish_date']);
        include_once('includes/db/admission_info_db_insert.php');
        add_action('admin_notices', 'admission_info_admin_data_insert_success_notice' );
    } 
}

// FORM UPDATE
if(isset($_POST['admission_info_update'])){
    if(empty(mb_strlen($_POST['unversity_name'])) && empty(mb_strlen($_POST['unit_name'])) && empty(mb_strlen($_POST['ssc_gpa'])) && !isset($_POST['ssc_group']) && empty(mb_strlen($_POST['hsc_gpa'])) && !isset($_POST['hsc_group']) && empty(mb_strlen($_POST['total_gpa'])) && empty(mb_strlen($_POST['admission_date']))){
        add_action( 'admin_notices', 'empty_field_callable_hndler' );
    }
    elseif(empty(mb_strlen($_POST['unversity_name'])) || empty(mb_strlen($_POST['unit_name'])) || empty(mb_strlen($_POST['ssc_gpa'])) || !isset($_POST['ssc_group']) || empty(mb_strlen($_POST['hsc_gpa'])) || !isset($_POST['hsc_group']) || empty(mb_strlen($_POST['total_gpa'])) || empty(mb_strlen($_POST['admission_date']))){
        add_action( 'admin_notices', 'admission_info_admin_single_empty_field_notice' );
    }
    else{
        $universityName = sanitize_text_field( $_POST['unversity_name']);
        $unitName = sanitize_text_field( $_POST['unit_name']);
        $SscGpa = sanitize_text_field( $_POST['ssc_gpa']);
        $SscGrp = $_POST['ssc_group'] ? sanitize_text_field( $_POST['ssc_group']):' ';
        $HscGpa = sanitize_text_field( $_POST['hsc_gpa']);
        $HscGrp = $_POST['hsc_group'] ? sanitize_text_field( $_POST['hsc_group']) : ' ';
        $totalGpa = sanitize_text_field( $_POST['total_gpa']);
        $admissionDate = sanitize_text_field( $_POST['admission_date']);
        $post_id_no = sanitize_text_field( $_POST['post_id']);
        $post_publish_date = sanitize_text_field( $_POST['publish_date']);
        include_once('includes/db/update_admission_info_db.php');
        add_action('admin_notices', 'admission_info_admin_data_insert_success_notice' );
    } 
}


// ATTACHMENT FORM SUBMIT AD CHECKING [FILE PATH -> includes/admin-pages/attachment.php]
if(isset($_POST['admission_info_attach_frm_save'])){

    // FILE PATH -> includes/admin-pages/attachment.php

    if($_FILES['admission_info_attach_varsity_file']['size'] == 0){
        add_action( 'admin_notices', 'no_attach_file_callable_hndler' );
    }
    elseif((empty(mb_strlen($_POST['admission_info_attach_varsity_name']))) && (empty(mb_strlen($_POST['admission_info_circular_published_date'])))){
        add_action( 'admin_notices', 'empty_field_callable_hndler' );
    }
    elseif((empty(mb_strlen($_POST['admission_info_attach_varsity_name']))) || (empty(mb_strlen($_POST['admission_info_circular_published_date'])))){
        add_action( 'admin_notices', 'admission_info_admin_single_empty_field_notice' );
    }
    else{

        $universityName = sanitize_text_field( $_POST['admission_info_attach_varsity_name']);
        $attachFileName = $_FILES['admission_info_attach_varsity_file'];
        $circularPublished = sanitize_text_field( $_POST['admission_info_circular_published_date']);

        if("application/pdf" == $attachFileName['type']){

            $attachedFile_fullName = $universityName.'-'.$attachFileName["name"];

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/WPplugin/wp-content/plugins/admission-info/uploads/'.$attachedFile_fullName;

            move_uploaded_file($attachFileName["tmp_name"], $upload_dir);
            include_once('includes/db/admission_info_attachment_db_insert.php');
            add_action('admin_notices', 'admission_info_admin_data_insert_success_notice' );
        }
        else {
            return;
        }
    } 
}
?>