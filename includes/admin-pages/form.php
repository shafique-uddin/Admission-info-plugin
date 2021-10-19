<?php 
// Check Have Any Edit Data
if(isset($_GET['edit'])){
    $post_id_no = sanitize_text_field($_GET['edit']); 
    global $wpdb;
    $tbl_name = $wpdb->prefix.'admission_info_db';
    $mylink = $wpdb->get_row( "SELECT * FROM $tbl_name WHERE id = $post_id_no" );
}
?>




<div class="admission-info-form-header">
    <div class="left-div">
        <?php _e('Date: '.date('d-F-Y')); ?>
    </div>
    <div class="right-div">
        <?php 
            if(isset($_GET['edit'])){ ?>
    <a type="button" href="<?php echo admin_url().'admin.php?page=add-new-varsity-info'; ?>">Add New Info</a>
        <?php } ?>
    </div>
</div>


<div id="varsityinfowrap" class="my-form-wrap"> 

<form method="POST">
<div class="mycampus-field mycampus-input-label">
    <div class="mycampus-title">
        <label for="university_name">University Name</label>
    </div>
    <div class="mycampus-input-field">
        <input type="text" autocomplete="off" name="unversity_name" id="university_name" value="<?php if(isset( $mylink->universityName)) echo $mylink->universityName; ?>">
    </div>
    </div>
    <div class="mycampus-field mycampus-input-label">
        <div class="mycampus-title">
            <label for="unit_name">Unit Name</label>
        </div>
        <div class="mycampus-input-field">
            <input type="text" autocomplete="off" name="unit_name" id="unit_name" value="<?php if(isset( $mylink->unitName)) echo $mylink->unitName; ?>">
        </div>
    </div>
    <div class="mycampus-field mycampus-input-label">
        <div class="mycampus-title">
            <label for="ssc-gpa">SSC GPA</label>
        </div>
        <div class="mycampus-input-field">
            <input type="text" autocomplete="off" name="ssc_gpa" id="ssc-gpa" value="<?php if(isset( $mylink->sscGPA)) echo $mylink->sscGPA; ?>">
        </div>
    </div>
    <div class="mycampus-field">
        <div class="mycampus-title">
            <p>SSC Group</p>
        </div>
        <div class="mycampus-input-field-radio">

        <?php 
            $ssc_group_list = array(
                'all' => 'All',
                'scienceBH' => 'Science (Biology + Higher Math)',
                'scienceM' => 'Science (Higher Math)',
                'scienceB' => 'Science (Biology)',
                'arts' => 'Arts',
                'commerce' => 'Commerce'
            );

            foreach ($ssc_group_list as $ssc_group_list_key => $ssc_group_list_value) {
                if(isset($mylink->sscGROUP)){
                    $selected = ("$mylink->sscGROUP" == "$ssc_group_list_key") ? "checked" : "" ;
                } else {
                    $selected = '';
                }
                ?>
                <input type="radio" <?php echo $selected; ?> name="ssc_group" value="<?php echo $ssc_group_list_key; ?>" id="sscGroup_<?php echo $ssc_group_list_value; ?>"><label for="sscGroup_<?php echo $ssc_group_list_value; ?>"><?php echo $ssc_group_list_value; ?></label> <br>
        <?php   } ?>
        </div>
    </div>
    <div class="mycampus-field mycampus-input-label">
        <div class="mycampus-title">
            <label for="hsc-gpa">HSC GPA</label>
        </div>
        <div class="mycampus-input-field">
            <input type="text" autocomplete="off" name="hsc_gpa" id="hsc-gpa" value="<?php if(isset($mylink->hscGPA)) echo $mylink->hscGPA; ?>">
        </div>
    </div>
    <div class="mycampus-field">
        <div class="mycampus-title">
            <p>HSC Group</p>
        </div>
        <div class="mycampus-input-field-radio">

        <?php 
        $hsc_group_list = array(

            'all' => 'All',
            'scienceBH' => 'Science (Biology + Higher Math)',
            'scienceM' => 'Science (Higher Math)',
            'scienceB' => 'Science (Biology)',
            'arts' => 'Arts',
            'commerce' => 'Commerce'
        );

        foreach ($hsc_group_list as $hsc_group_list_key => $hsc_group_list_value) { 
            if(isset($mylink->hscGROUP)){
                $selected = ("$mylink->hscGROUP" == "$hsc_group_list_key") ? "checked" : "" ;
            } else {
                $selected = '';
            }

            ?>
            <input type="radio" <?php echo $selected; ?> name="hsc_group" value="<?php echo $hsc_group_list_key; ?>" id="hscGroup_<?php echo $hsc_group_list_value; ?>"><label for="hscGroup_<?php echo $hsc_group_list_value; ?>"><?php echo $hsc_group_list_value; ?></label> <br>
        <?php   } ?>
        </div>
    </div>
    <div class="mycampus-field mycampus-input-label">
        <div class="mycampus-title">
            <label for="total_gpa">Total GPA (Minimum Required GPA)</label>
        </div>
        <div class="mycampus-input-field">
            <input type="text" autocomplete="off" name="total_gpa" id="total_gpa" value="<?php if(isset($mylink->totalGPA)) echo $mylink->totalGPA; ?>">
        </div>
    </div>
    <div class="mycampus-field mycampus-input-label">
        <div class="mycampus-title">
            <label for="datepicker">Admission Date</label>
        </div>
        <div class="mycampus-input-field">
            <input type="text" autocomplete="off" name="admission_date" id="datepicker" value="<?php if(isset($mylink->admission_date)) echo $mylink->admission_date; ?>">
        </div>
        <div class="mycampus-hidden">
            <?php 
            if(isset($_GET['edit'])){ ?>
                <input type="hidden" name="post_id" value="<?php echo $mylink->id;?>">
                <input type="hidden" name="publish_date" value="<?php echo $mylink->postPublish; ?>">
            <?php 
            }
            else {?>
                <input type="hidden" name="publish_date" value="<?php echo date('d-F-Y'); ?>">
            <?php }
            ?>
        </div>
    </div>
    <?php 
        if(isset($_GET['edit'])){
            echo submit_button( 'Update Data', 'button', 'admission_info_update', true, null );
        } else {
            echo submit_button( 'Save New Data', 'button', 'admission_info_save', true, null );
        }
    ?>
</div>

</form>
</div>




