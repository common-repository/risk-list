<?php
/*
Plugin Name: Risk List
Plugin URI: http://risklist.co.uk
Description: Risk List is Risk Management Software running on the WordPress CMS platform
Version: 1.0
Author: epicplugins
http://risklist.co.uk
*/

global $risklist_version;
$risklist_version = '1.0';

global $risklist_slugs;

$risklist_slugs['home'] = 'risk-list-home';
$risklist_slugs['bubble'] = 'risk-bubble';

#COMMENT} Define Paths
define( 'RISKLIST_PATH', plugin_dir_path(__FILE__) );
define( 'RISKLIST_URL', plugin_dir_url(__FILE__) );


if(!defined('RISKLIST_INC_CPT')) require_once(RISKLIST_PATH. 'includes/risk-list-cpt.php');
if(!defined('RISKLIST_CONTROL_META')) require_once(RISKLIST_PATH. 'includes/risk-list-risk-meta.php');
if(!defined('RISKLIST_DASHBOARDS')) require_once(RISKLIST_PATH. 'includes/risk-list-dashboard.php');


#} general
add_action('init', 'risklist_init');
add_action('admin_init','risklist_admin_init');


   /* ======================================================
    User Roles
   ====================================================== */

function risklist_add_roles_on_plugin_activation() {
   risklist_addUserRoles();
}
register_activation_hook( __FILE__, 'risklist_add_roles_on_plugin_activation' );


function risklist_risk_color($impact, $prob){
             if($impact == 1 && $prob == 1){
                return 'green';
             }
             if($impact == 1 && $prob == 2){
                return 'green';
             }
             if($impact == 1 && $prob == 3){
                return 'green';
             }
             if($impact == 1 && $prob == 4){
                return 'yellow';
             }
             if($impact == 1 && $prob == 5){
                return 'yellow';
             }


             if($impact == 2 && $prob == 1){
                return 'green';
             }
             if($impact == 2 && $prob == 2){
                return 'green';
             }
             if($impact == 2 && $prob == 3){
                return 'yellow';
             }
             if($impact == 2 && $prob == 4){
                return 'yellow';
             }
             if($impact == 2 && $prob == 5){
                return 'yellow';
             }


             if($impact == 3 && $prob == 1){
                return 'green';
             }
             if($impact == 3 && $prob== 2){
                return 'yellow';
             }
             if($impact == 3 && $prob == 3){
                return 'yellow';
             }
             if($impact == 3 && $prob == 4){
                return 'yellow';
             }
             if($impact == 3 && $prob == 5){
               return 'red';
             }


             if($impact == 4 && $prob == 1){
                return 'yellow';
             }
             if($impact == 4 && $prob == 2){
                return 'yellow';
             }
             if($impact == 4 && $prob == 3){
                return 'yellow';
             }
             if($impact == 4 && $prob == 4){
                return 'red';
             }
             if($impact == 4 && $prob == 5){
                return 'red';
             }



             if($impact == 5 && $prob == 1){
                return 'yellow';
             }
             if($impact == 5 && $prob == 2){
                return 'yellow';
             }
             if($impact == 5 && $prob == 3){
                return 'red';
             }
             if($impact == 5 && $prob == 4){
                return 'red';
             }
             if($impact == 5 && $prob == 5){
                return 'red';
             }
}

function risklist_addUserRoles(){


        #=====================================================

        #COMMENT} Risk Manager
        $result = add_role( 'risklist_riskmanager', __(

            'Risk Manager' ),

            array(

            'read' => true, // true allows this capability
            'edit_posts' => true, // Allows user to edit their own posts
            'edit_pages' => false, // Allows user to edit pages
            'edit_others_posts' => false, // Allows user to edit others posts not just their own
            'create_posts' => true, // Allows user to create new posts
            'manage_categories' => false, // Allows user to manage post categories
            'publish_posts' => false, // Allows the user to publish, otherwise posts stays in draft mode

            )

        );

        // gets the author role
        $role = get_role( 'risklist_riskmanager' );

        $role->add_cap( 'read' );
        $role->add_cap( 'admin_risklist_usr' ); #} For all zerobs users :)
        $role->add_cap( 'manage_risks' );
        $role->add_cap( 'manage_objectives' );
        $role->add_cap( 'manage_actions' );
        $role->add_cap( 'manage_metrics' );
        $role->add_cap( 'manage_processes' );
        $role->add_cap( 'risk_dash' ); # WH added 1.2 - has rights to view ZBS Dash
        $role->add_cap('publish_posts');
        $role->add_cap('edit_posts');

        unset($role);

        $role = get_role( 'administrator' );

        $role->add_cap( 'admin_risklist_usr' ); #} For all zerobs users :)
        $role->add_cap( 'manage_risks' );
        $role->add_cap( 'manage_objectives' );
        $role->add_cap( 'manage_actions' );
        $role->add_cap( 'manage_metrics' );
        $role->add_cap( 'manage_processes' );
        $role->add_cap( 'risk_dash' ); # WH added 1.2 - has rights to view ZBS Dash

        unset($role);
}

function risklist_init(){
	risklist_setupPostTypes();
}

add_action( 'admin_menu', 'risklist_remove_menu' );
function risklist_remove_menu(){

    global $risklist_slugs;
	$risklist = add_menu_page('Risk List', 'Risk List', 'manage_risks', $risklist_slugs['home'] ,'risklist_dash','dashicons-welcome-view-site',3);
	add_action( "admin_print_styles-{$risklist}", 'risklist_global_admin_styles' );
	add_action("admin_print_styles-{$risklist}", 'risklist_admin_enqueue_bs');
}

function risklist_dash(){
    ?>
        <h2>Welcome to Risk List</h2>
    <?php
}

#} Translations
//add_filter( 'gettext', 'change_publish_button', 10, 2 );
function risklist_change_publish_button( $translation, $text ) {
    global $post;
    if($post->post_type == 'risklist_risk' || $post->post_type == 'risklist_objective' || $post->post_type == 'risklist_metric' || $post->post_type == 'risklist_action' || $post->post_type == 'risklist_process' || $post->post_type == 'risklist_control'){
    if ( $text == 'Publish' )
        return 'Save';
    if ($text == 'Author')
    	return 'Owner';
    }
    return $translation;
}


/* DASHBOARD FUNCTIONS */
function risklist_riskbubble(){
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_risk' AND post_status='publish'";
    $risks = $wpdb->get_results($sql);

    $matrix = array();

    $matrix[0] = array_fill(0,5,0);
    $matrix[1] = array_fill(0,5,0);    
    $matrix[2] = array_fill(0,5,0);
    $matrix[3] = array_fill(0,5,0);
    $matrix[4] = array_fill(0,5,0);

    foreach($risks as $risk){

        $risk_meta = get_post_meta($risk->ID,'risklist_risk_info',true);

             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 1){
                $matrix[0][0]++;
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 2){
                $matrix[0][1]++;
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 3){
                $matrix[0][2]++;
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 4){
                $matrix[0][3]++;
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 5){
                $matrix[0][4]++;
             }


             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 1){
                $matrix[1][0]++;
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 2){
                $matrix[1][1]++;
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 3){
                $matrix[1][2]++;
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 4){
                $matrix[1][3]++;
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 5){
                $matrix[1][4]++;
             }


             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 1){
                $matrix[2][0]++;
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 2){
                $matrix[2][1]++;
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 3){
                $matrix[2][2]++;
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 4){
                $matrix[2][3]++;
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 5){
                $matrix[2][4]++;
             }


             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 1){
                $matrix[3][0]++;
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 2){
                $matrix[3][1]++;
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 3){
                $matrix[3][2]++;
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 4){
                $matrix[3][3]++;
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 5){
                $matrix[3][4]++;
             }



             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 1){
                $matrix[4][0]++;
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 2){
                $matrix[4][1]++;
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 3){
                $matrix[4][2]++;
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 4){
                $matrix[4][3]++;
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 5){
                $matrix[4][4]++;
             }
    }  

    ?>
    <div class='risk-bubble'>
        <div class='rrow row-5'>
            <div class='ccol l-1'><?php echo risklist_score_to_name(5,'impact');?></div>
            <div class='ccol col-1'>
                <span class='count count-a'><?php echo $matrix[4][0]; ?></span>
            </div>
            <div class='ccol col-2'>
                <span class='count count-a'><?php echo $matrix[4][1]; ?></span>
            </div>
            <div class='ccol col-3'>
                <span class='count count-r'><?php echo $matrix[4][2]; ?></span>
            </div>
            <div class='ccol col-4'>
                <span class='count count-r'><?php echo $matrix[4][3]; ?></span>
            </div>
            <div class='ccol col-5'>
                <span class='count count-r'><?php echo $matrix[4][4]; ?></span>
            </div>
        </div>
        <div class='rrow row-4'>
            <div class='ccol l-1'><?php echo risklist_score_to_name(4,'impact');?></div>
            <div class='ccol col-1'>
                <span class='count count-a'><?php echo $matrix[3][0]; ?></span>
            </div>
            <div class='ccol col-2'>
                <span class='count count-a'><?php echo $matrix[3][1]; ?></span>
            </div>
            <div class='ccol col-3'>
                <span class='count count-a'><?php echo $matrix[3][2]; ?></span>
            </div>
            <div class='ccol col-4'>
                <span class='count count-r'><?php echo $matrix[3][3]; ?></span>
            </div>
            <div class='ccol col-5'>
                <span class='count count-r'><?php echo $matrix[3][4]; ?></span>
            </div>
        </div>
        <div class='rrow row-3'>
            <div class='ccol l-1'><?php echo risklist_score_to_name(3,'impact');?></div>
            <div class='ccol col-1'>
                <span class='count count-g'><?php echo $matrix[2][0]; ?></span>
            </div>
            <div class='ccol col-2'>
                <span class='count count-a'><?php echo $matrix[2][1]; ?></span>
            </div>
            <div class='ccol col-3'>
                <span class='count count-a'><?php echo $matrix[2][2]; ?></span>
            </div>
            <div class='ccol col-4'>
                <span class='count count-a'><?php echo $matrix[2][3]; ?></span>
            </div>
            <div class='ccol col-5'>
                <span class='count count-r'><?php echo $matrix[2][4]; ?></span>
            </div>
        </div>                                  
        <div class='rrow row-2'>
            <div class='ccol l-1'><?php echo risklist_score_to_name(2,'impact');?></div>
            <div class='ccol col-1'>
                <span class='count count-g'><?php echo $matrix[1][0]; ?></span>
            </div>
            <div class='ccol col-2'>
                <span class='count count-g'><?php echo $matrix[1][1]; ?></span>
            </div>
            <div class='ccol col-3'>
                <span class='count count-a'><?php echo $matrix[1][2]; ?></span>
            </div>
            <div class='ccol col-4'>
                <span class='count count-a'><?php echo $matrix[1][3]; ?></span>
            </div>
            <div class='ccol col-5'>
                <span class='count count-a'><?php echo $matrix[1][4]; ?></span>
            </div>
        </div>
        <div class='rrow row-1'>
            <div class='ccol l-1'><?php echo risklist_score_to_name(1,'impact');?></div>
            <div class='ccol col-1'>
                <span class='count count-g'><?php echo $matrix[0][0]; ?></span>
            </div>
            <div class='ccol col-2'>
                <span class='count count-g'><?php echo $matrix[0][1]; ?></span>
            </div>
            <div class='ccol col-3'>
                <span class='count count-g'><?php echo $matrix[0][2]; ?></span>
            </div>
            <div class='ccol col-4'>
                <span class='count count-a'><?php echo $matrix[0][3]; ?></span>
            </div>
            <div class='ccol col-5'>
                <span class='count count-a'><?php echo $matrix[0][4]; ?></span>
            </div>
        </div>
        <div class='rrow row-0'>
            <div class='ccol l-1'></div>
            <div class='ccol col-1'><?php echo risklist_score_to_name(1,'prob');?>
            </div>
            <div class='ccol col-2'><?php echo risklist_score_to_name(2,'prob');?>
            </div>
            <div class='ccol col-3'><?php echo risklist_score_to_name(3,'prob');?>
            </div>
            <div class='ccol col-4'><?php echo risklist_score_to_name(4,'prob');?>
            </div>
            <div class='ccol col-5'><?php echo risklist_score_to_name(5,'prob');?>
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>

    <?php
}

function risklist_risksummary(){
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_risk' AND post_status='publish'";
    $risks = $wpdb->get_results($sql);

    $matrix = array();

    $matrix[0] = array_fill(0,5,0);
    $matrix[1] = array_fill(0,5,0);    
    $matrix[2] = array_fill(0,5,0);
    $matrix[3] = array_fill(0,5,0);
    $matrix[4] = array_fill(0,5,0);
    $i = 0;

    foreach($risks as $risk){

        $risk_meta = get_post_meta($risk->ID,'risklist_risk_info',true);

             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 1){
                $green[$i]->risk = $risk;
                $green[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 2){
                $green[$i]->risk = $risk;
                $green[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 3){
                $green[$i]->risk = $risk;
                $green[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 4){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 5){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }


             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 1){
                $green[$i]->risk = $risk;
                $green[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 2){
                $green[$i]->risk = $risk;
                $green[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 3){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 4){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 5){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }


             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 1){
                $green[$i]->risk = $risk;
                $green[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 2){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 3){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 4){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 5){
                $red[$i]->risk = $risk;
                $red[$i]->meta = $risk_meta;
             }


             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 1){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 2){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 3){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 4){
                $red[$i]->risk = $risk;
                $red[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 5){
                $red[$i]->risk = $risk;
                $red[$i]->meta = $risk_meta;
             }



             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 1){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 2){
                $yellow[$i]->risk = $risk;
                $yellow[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 3){
                $red[$i]->risk = $risk;
                $red[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 4){
                $red[$i]->risk = $risk;
                $red[$i]->meta = $risk_meta;
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 5){
                $red[$i]->risk = $risk;
                $red[$i]->meta = $risk_meta;
             }


             $i++;
    }  

    ?>
    <table class='risk-list table'>
        <thead class="heading">
            <th><?php _e("RAG","risklist");?></th>
            <th style="text-align:left"><?php _e("Risk","risklist");?></th>
            <th><?php _e("Score","risklist");?></th>
            <th><?php _e("Owner","risklist"); ?></th>
            <th><?php _e("Updated","risklist");?></th>   
            <th><?php _e("Edit","risklist");?></th>
        </thead>
        <tbody>
            <?php 
            $overall = 0;
            foreach($red as $r){
                if($overall < 7){
                echo '<tr class="red">';
                echo '<td class="rag"></td>';
                echo '<td class="title">' . $r->risk->post_title . '</td>';
                echo '<td>(' . $r->meta['res_impact'] . ',' . $r->meta['res_prob'] . ')</td>';

                echo '<td class="owner">' . get_avatar($r->risk->post_author, 30) . '</td>';

                echo '<td class="updated">' . human_time_diff( strtotime($r->risk->post_modified), current_time('timestamp') ) . ' ago </td>';
                echo '<td><a href="' .  get_edit_post_link( $r->risk->ID) . '" target="_blank">' . __('Edit','risklist') . '</a></td>'; 
                echo '</tr>';
                $overall++;
                }
            } 
            ?>
            <?php 
            if($overall < 7){
                foreach($yellow as $r){
                    if($overall < 7){
                        echo '<tr class="yellow">';
                        echo '<td class="rag"></td>';
                        echo '<td class="title">' . $r->risk->post_title . '</td>';
                        echo '<td>(' . $r->meta['res_impact'] . ',' . $r->meta['res_prob'] . ')</td>';
                         echo '<td class="owner">' . get_avatar($r->risk->post_author, 30) . '</td>';

                        echo '<td class="updated">' . human_time_diff( strtotime($r->risk->post_modified), current_time('timestamp') ) . ' ago </td>';
                        echo '<td><a href="' .  get_edit_post_link( $r->risk->ID) . '" target="_blank">' . __('Edit','risklist') . '</a></td>';                 
                        echo '</tr>';
                        $overall++;
                    }
                } 
            }
            ?>
            <?php 
            if($overall < 7){
                foreach($green as $r){
                    if($overall < 7){
                        echo '<tr class="green">';
                        echo '<td class="rag"></td>';
                        echo '<td class="title">' . $r->risk->post_title . '</td>';
                        echo '<td>(' . $r->meta['res_impact'] . ',' . $r->meta['res_prob'] . ')</td>';

                         echo '<td class="owner">' . get_avatar($r->risk->post_author, 30) . '</td>';

                        echo '<td class="updated">' . human_time_diff( strtotime($r->risk->post_modified), current_time('timestamp') ) . ' ago </td>';
                        echo '<td><a href="' .  get_edit_post_link( $r->risk->ID) . '" target="_blank">' . __('Edit','risklist') . '</a></td>';                 
                        echo '</tr>';
                        $overall++;
                    }
                } 
            }
            ?>
        </tbody>                              
    </table>
    <div style="clear:both;"></div>

    <div class="view-all-risks"><a href="<?php echo admin_url('edit.php?post_type=risklist_risk');?>"><?php _e("View All", "risklist"); ?></a></div>

    <?php
}

function risklist_metricsummary(){
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_metric' AND post_status='publish'";
    $risks = $wpdb->get_results($sql);
    ?>
    <table class='metric-list table'>
        <thead class="heading">
            <th style="text-align:left;"><?php _e("Metric","risklist");?></th>
            <th><?php _e("Value","risklist");?></th>
            <th><?php _e("Trend","risklist");?></th>
            <th><?php _e("Last updated","risklist");?></th>            
            <th><?php _e("Edit","risklist");?></th>
        </thead>
        <tbody>
            <?php 
            foreach($risks as $r){
                $metric_meta = json_decode(get_post_meta($r->ID,'metric_data',true),true);
                $m_count = count($metric_meta);
                $latest_metric = $metric_meta[$m_count -1];
                if($latest_metric==''){
                    $latest_metric = '-';
                }
                $prev = $metric_meta[$m_count -4];
                if($prev == ''){
                    $prev = 0;
                }

                if($latest_metric > $prev){
                    $tag = 'green';
                    $dir = 'fa-arrow-circle-up';
                }
                if($latest_metric == $prev){
                    $tag = 'yellow';
                    $dir = 'fa-arrow-circle-right';
                }
                if($latest_metric < $prev){
                    $tag = 'red';
                    $dir = 'fa-arrow-circle-down';
                }

                echo '<tr class="metric">';
                echo '<td class="title">' . $r->post_title . '</td>';
                echo '<td class="value">'.$latest_metric.'</td>';
                echo '<td class="trend '.$tag.'"><i class="fa '.$dir.'"></i></td>';
                echo '<td class="updated">' . human_time_diff( strtotime($r->post_modified), current_time('timestamp') ) . ' ago </td>';
                echo '<td class="edit"><a href="' .  get_edit_post_link( $r->ID) . '" target="_blank">' . __('Edit','risklist') . '</a></td>';                 
                echo '</tr>';
            } ?>
        </tbody>                              
    </table>
    <div style="clear:both;"></div>

    <div class="view-all-risks"><a href="<?php echo admin_url('edit.php?post_type=risklist_metric');?>"><?php _e("View All", "risklist"); ?></a></div>

    <?php
}

function risklist_actionsummary(){
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_action' AND post_status='publish'";
    $risks = $wpdb->get_results($sql);
    ?>
    <table class='metric-list table'>
        <thead class="heading">
            <th style="text-align:left;"><?php _e("Action","risklist");?></th>
            <th><?php _e("Who","risklist");?></th>
            <th><?php _e("Due Date","risklist"); ?></th>
            <th><?php _e("Updated","risklist");?></th>            
            <th><?php _e("Edit","risklist");?></th>
        </thead>
        <tbody>
            <?php 
            foreach($risks as $r){

           //     risklist_prettyprint($r);

                $metric_meta    = get_post_meta($r->ID,'risklist_metric_meta',true);
                $due_date       = get_post_meta($r->ID,'risklist_action_date',true);
                
                echo '<tr class="metric green">';
                echo '<td class="title">' . $r->post_title . '</td>';
                echo '<td class="owner">' . get_avatar($r->post_author, 30) . '</td>';
                echo '<td class="due">'. $due_date .'</td>';
                echo '<td class="updated">' . human_time_diff( strtotime($r->post_modified), current_time('timestamp') ) . ' ago </td>';
                echo '<td class="edit"><a href="' .  get_edit_post_link( $r->ID) . '" target="_blank">' . __('Edit','risklist') . '</a></td>';                 
                echo '</tr>';
            } ?>
        </tbody>                              
    </table>
    <div style="clear:both;"></div>

    <div class="view-all-risks"><a href="<?php echo admin_url('edit.php?post_type=risklist_action');?>"><?php _e("View All", "risklist"); ?></a></div>

    <?php
}

function risklist_processsummary(){
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_process' AND post_status='publish'";
    $risks = $wpdb->get_results($sql);
    ?>
    <table class='metric-list table'>
        <thead class="heading">
            <th><?php _e("Complete","risklist"); ?></th>
            <th style="text-align:left;"><?php _e("Process","risklist");?></th>
            <th><?php _e("Owner","risklist");?></th>
            <th><?php _e("When","risklist"); ?></th>        
            <th><?php _e("Edit","risklist");?></th>
        </thead>
        <tbody>
            <?php 
            foreach($risks as $r){

           //     risklist_prettyprint($r);
                $process_data = get_post_meta($r->ID,'process_freq', true);

                echo '<tr class="metric">';
                if($process_data['status'] == 0){
                echo '<td class="status red"><i class="fa fa-times-circle"></i></td>';
                }else{
                echo '<td class="status green"><i class="fa fa-check-circle"></i></td>';
                }
                echo '<td class="title">' . $r->post_title . '</td>';
                echo '<td class="owner">' . get_avatar($r->post_author, 30) . '</td>';
                echo '<td class="due" style="text-align:center;">'. risklist_freq_text($process_data['freq']) .'</td>';
                echo '<td class="edit"><a href="' .  get_edit_post_link( $r->ID) . '" target="_blank">' . __('Edit','risklist') . '</a></td>';                 
                echo '</tr>';
            } ?>
        </tbody>                              
    </table>
    <div style="clear:both;"></div>

    <div class="view-all-risks"><a href="<?php echo admin_url('edit.php?post_type=risklist_process');?>"><?php _e("View All", "risklist"); ?></a></div>

    <?php
}

/* <- END DASHBOARD FUNCTIONS */

function risklist_freq_text($data){
    if($data == '365'){
        return __('Daily','risklist');
    }
    if($data == '12'){
        return __('Monthly','risklist');
    }
    if($data == '7'){
        return __('Weekly','risklist');
    }
}

function risklist_risklist(){
	global $wpdb;

	$sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_objective' AND post_status='publish'";
	$objectives = $wpdb->get_results($sql);




	echo "<table class='risk-table table striped'>";
	echo "<tbody class='tbody'>";

	foreach($objectives as $o){
		$risks = get_post_meta($o->ID,'risklist_objective_meta',true);
		$risk_meta = $risks['risks'];
		$rowspan = count($risk_meta);
		echo "<tr class='obj-wrap'>";
			echo '<td class="obj">' . $o->post_title . '</td>';
			echo '<td class="risk-wrap"><table class="table striped risks">';
				$ri = 0;
				foreach($risk_meta as $r){
					$rp = get_post($r);
					if($rp->post_status == 'publish'){
					echo '<tr class="risk risk-'.$ri.'">';
						echo '<td class="risk-title risk-'.$ri.'">' . $rp->post_title . '<div class="desc">' . $rp->post_content . '</div></td>';
						$controls = get_post_meta($r,'risklist_risk_meta',true);
						$control_meta = $controls['risks'];
						echo '<td class="control-wrap"><table class="table controls striped">';
						$ci = 0;
						foreach($control_meta as $c){
							$cp = get_post($c);
							$terms = wp_get_post_terms($c, 'risklist_controltag');
							echo '<tr class="control">';
							echo '<td class="control-title control-'.$ci.'">' . $cp->post_title . '<div class="desc">' . $cp->post_content . '</div></td>';
							echo '<td class="control-'.$ci.'">' . $terms[0]->name . '</td>';
							echo '</tr>';
							$ci++;
						}
						echo '</table></td>';
					echo '</tr>';
					$ri++;
					}
				}
			echo '</table></td>';
		echo '</tr>';
	}
	echo "</tbody></table>";
}


function risklist_remove_screen_options($display_boolean, $wp_screen_object){
  $blacklist = array('post.php', 'post-new.php', 'index.php', 'edit.php');
  if (in_array($GLOBALS['pagenow'], $blacklist)) {
    $wp_screen_object->render_screen_layout();
    $wp_screen_object->render_per_page_options();
    return false;
  } else {
    return true;
  }
}
//add_filter('screen_options_show_screen', 'risklist_remove_screen_options', 10, 2);


function risklist_filter_by_the_author() {
    $params = array(
        'name' => 'author', // this is the "name" attribute for filter <select>
        'show_option_all' => 'All Owners' // label for all authors (display posts without filter)
    );
 
    if ( isset($_GET['user']) )
        $params['selected'] = $_GET['user']; // choose selected user by $_GET variable
 
    wp_dropdown_users( $params ); // print the ready author list
}
add_action('restrict_manage_posts', 'risklist_filter_by_the_author');



function risklist_prettyprint($array){
	echo '<pre>';
	var_dump($array);
	echo '</pre>';
}

function risklist_admin_init(){
	wp_register_style('risklistadmcss', 	plugins_url('/css/risklist.css',__FILE__),'', 1.17 );
	wp_register_style('risklist-fa-corecss', plugins_url('/css/font-awesome.min.css',__FILE__) );
	wp_register_style('risklist-swa', plugins_url('/css/sweetalert.min.css',__FILE__) );
	wp_register_style('risklist-bs', plugins_url('/css/bootstrap.min.css',__FILE__) );
}

function risklist_admin_enqueue_bs(){
	wp_enqueue_style('risklist-bs');
}


function risklist_global_admin_styles(){
	//enqueue these (via the admin_print_styles-{$page})
	wp_enqueue_style('risklistadmcss');
	wp_enqueue_style('risklist-fa-corecss');
	wp_enqueue_style('risklist-swa');
    wp_enqueue_style('risklist-bs');
   
    wp_enqueue_script('risklist_bootstrap',      plugins_url('/js/bootstrap.min.js',__FILE__),array('jquery')); 
    wp_enqueue_script('risklist_moment',      plugins_url('/js/moment.min.js',__FILE__),array('jquery'));
    wp_enqueue_script('risklist_daterange',      plugins_url('/js/daterangepicker.min.js',__FILE__),array('jquery','risklist_moment','risklist_bootstrap'));
    wp_enqueue_script('risklist_main',      plugins_url('/js/main.js',__FILE__),array('jquery','risklist_daterange'));


    wp_enqueue_script('jquery-ui-core');
}

function risklist_add_admin_styles( $hook ) {
    risklist_global_admin_styles();
}
add_action( 'admin_enqueue_scripts', 'risklist_add_admin_styles', 10, 1 );

#} For (if shown mobile) - restrict things shown
//add_action( 'admin_bar_menu', 'remove_wp_items', 100 );
function risklist_remove_wp_items( $wp_admin_bar ) {

	global $zeroBSCRM_Settings; #req

	#} Retrieve setting
	   $customheadertext = 'Risk List';	
		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('site-name');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_menu('my-account');
		#$wp_admin_bar->remove_menu('top-secondary');

		if (!empty($customheadertext)){

			# https://codex.wordpress.org/Class_Reference/WP_Admin_Bar/add_menu
			# https://codex.wordpress.org/Function_Reference/add_node
			
			 $wp_admin_bar->add_node( array(

			 	'id' => 'zbshead',
			 	'title' => '<div class="wp-menu-image dashicons-before dashicons-feedback" style="display: inline-block;margin-right: 6px;"><br></div>'.$customheadertext,
			 	'href' => 'admin.php?page=risklist',
			 	'meta' => array(
			 		#'class' => 'wp-menu-image dashicons-before dashicons-groups'
			 	)


			 ) );
			 

		}
}


add_filter( 'manage_risklist_risk_posts_columns', 'risklist_set_custom_edit_risklist_risk_columns' );
add_action( 'manage_risklist_risk_posts_custom_column' , 'risklist_custom_risklist_risk_column', 10, 2 );

function risklist_set_custom_edit_risklist_risk_columns($columns) {
    
    $columns['rag'] = __( 'Risk Rating', 'risklist' );
    $columns['score'] = __('(Impact,Probability)','risklist');


    return $columns;
}

function risklist_custom_risklist_risk_column( $column, $post_id ) {
    switch ( $column ) {

        case 'rag' :
            $risk_meta = get_post_meta( $post_id , 'risklist_risk_info' , true ); 

             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 1){
             	$rag_class = 'green';
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 2){
             	$rag_class = 'green';
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 1){
             	$rag_class = 'green';
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 2){
             	$rag_class = 'green';
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 1){
             	$rag_class = 'green';
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 3){
             	$rag_class = 'green';
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 1){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 1){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 2){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 2){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 2){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 3){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 3){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 3){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 3){
             	$rag_class = 'red';
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 4){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 4){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 4){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 4){
             	$rag_class = 'red';
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 4){
             	$rag_class = 'red';
             }
             if($risk_meta['res_impact'] == 1 && $risk_meta['res_prob'] == 5){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 2 && $risk_meta['res_prob'] == 5){
             	$rag_class = 'amber';
             }
             if($risk_meta['res_impact'] == 3 && $risk_meta['res_prob'] == 5){
             	$rag_class = 'red';
             }
             if($risk_meta['res_impact'] == 4 && $risk_meta['res_prob'] == 5){
             	$rag_class = 'red';
             }
             if($risk_meta['res_impact'] == 5 && $risk_meta['res_prob'] == 5){
             	$rag_class = 'red';
             }

            echo '<div class="rag '. $rag_class .'"></div>';

            break;

            case 'score':
            $risk_meta = get_post_meta( $post_id , 'risklist_risk_info' , true ); 
            echo '<div class="score">(' . risklist_score_to_name($risk_meta['res_impact'],'impact') . ',' . risklist_score_to_name($risk_meta['res_prob'],'prob') . ')</div>'; 

            break;

    } 
}

function risklist_score_to_name($score, $type){
    if(wp_is_mobile()){
        return $score;
    }else{
        if($type == 'prob'){
            switch($score){
                case '1':
                    return 'Remote';
                break;
                case '2':
                    return 'Unlikely';
                break;
                case '3':
                    return 'Possible';
                break;
                case '4':
                    return 'Probable';
                break;
                case '5':
                    return 'Certain';
                break;
            }
        }

        if($type == 'impact'){
            switch($score){
                case '1':
                    return 'Very Low';
                break;
                case '2':
                    return 'Low';
                break;
                case '3':
                    return 'Medium';
                break;
                case '4':
                    return 'High';
                break;
                case '5':
                    return 'Very High';
                break;
            }
        }
    }
}


add_action('admin_footer', 'risklist_admin_footer_function');
function risklist_admin_footer_function() {

    global $wpdb;

    $users = $wpdb->get_results("SELECT * FROM $wpdb->users");
    foreach($users as $u){
        $aurl = get_avatar_url($u->ID);
        $user[$u->ID] = $aurl;
    }

    echo '<script type="text/javascript">';
    echo 'var risklist_user = ' . json_encode($user);
    echo '</script>';
}

add_filter('manage_risklist_risk_columns', 'risklist_thumbnail_column_order');
function risklist_thumbnail_column_order($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='title') // Put the Thumbnail column before the Author column
      $new['rag'] = 'RAG';
    $new[$key] = $title;
  }
  return $new;
}

function risklist_remove_footer_admin (){
    echo '<span id="footer-thankyou">Manage risks with <a href="http://risklist.co.uk" target="_blank">Risk List</a></span>';
}
 
add_filter('admin_footer_text', 'risklist_remove_footer_admin');

function risklist_footer_ver(){
	global $risklist_version;
	 return '<p id="footer-upgrade" class="alignright">Version '.$risklist_version.'</p>';
}
add_filter('update_footer', 'risklist_footer_ver', 11);

function risklist_write_log ( $log )  {

        if ( is_array( $log ) || is_object( $log ) ) {
            error_log( print_r( $log, true ) );
        } else {
            error_log( $log );
        }
}


/* ======================================================
    Before You go... (Uninstall Wizard)
   ====================================================== */

#COMMENT} Uninstall
register_deactivation_hook(__FILE__,'risklist_uninstall');
function risklist_uninstall(){

    #Debug delete_option('zbsfeedback');exit();
    $feedbackAlready = get_option('riskfeedback');

    if (!defined('RISKDEACTIVATINGINPROG') && $feedbackAlready == false){

        #} Show stuff + Deactivate
        #} Define is to stop an infinite loop :)
        #} (Won't get here the second time)
        define('RISKDEACTIVATINGINPROG',true);


        #} Before you go...
        if (function_exists('file_get_contents')){

            try {

                $beforeYouGo = file_get_contents(RISKLIST_PATH.'html/before-you-go/index.html');

                if (!empty($beforeYouGo)){

                    #} replace this ###ADMINURL###
                    $beforeYouGo = str_replace('###ADMINURL###',admin_url('plugins.php'),$beforeYouGo);
                    $beforeYouGo = str_replace('###ADMINASSETSURL###',RISKLIST_URL.'html/before-you-go/assets/',$beforeYouGo); 
                    $beforeYouGo = str_replace('###AJAXURL###',admin_url('admin-ajax.php'),$beforeYouGo);   


                    #} Also manually deactivate before exit
                    deactivate_plugins( plugin_basename( __FILE__ ) );

                    #} Go
                    echo $beforeYouGo; exit();

                }


            } catch (Exception $e){

                #} Nada 

            }

        }   

    }

}

/* ======================================================
    / Before You go... (Uninstall Wizard)
   ====================================================== */