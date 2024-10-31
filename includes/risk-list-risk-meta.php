<?php

 if ( ! defined( 'RISKLIST_PATH' ) ) exit;

/* ======================================================
  Objectives Metabox
   ====================================================== */

class risklist_MetaboxObjectives {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_objective';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_objectivedetails',
            'Select Risk(s)',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'side',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

            global $plugin_page, $wpdb;
            $screen = get_current_screen();
            #} retrieve
            $risks = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_risk' AND post_status='publish'");

            $control_meta = get_post_meta($post->ID,'risklist_objective_meta',true);

            $risks_array = $control_meta['risks'];

            echo '<select id ="risks" name="risks[]" multiple>';
            foreach($risks as $risk){
            	if(in_array($risk->ID, $risks_array)){
            		$selected = 'selected';
            	}else{
            		$selected = '';
            	}
            	echo '<option value="'.$risk->ID . '" '.$selected.'>'.$risk->post_title.'</option>';
            }
            echo '</select>';
            ?>


         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_objectivedetails'  && $post->post_type == $this->postType){

        
              	$control_meta['risks'] = $_POST['risks'];
              	update_post_meta($post->ID,'risklist_objective_meta',$control_meta);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxObjectives = new risklist_MetaboxObjectives( __FILE__ );

class risklist_MetaboxObjectivesRisks {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_objective';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_riskcontrols',
            'Risks',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'normal',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

            global $plugin_page, $wpdb;
            $screen = get_current_screen();
            #} retrieve
            $controls = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_risk' AND post_status='publish'");

            $control_meta = get_post_meta($post->ID,'risklist_objective_meta',true);
            $risks_array = $control_meta['risks'];
            echo '<table class="metric-list table striped">';
            foreach($controls as $control){
                if(in_array($control->ID, $risks_array)){
                    $risk_meta = get_post_meta($control->ID,'risklist_risk_info',true);
                    $class = risklist_risk_color($risk_meta['res_impact'], $risk_meta['res_prob']);
                    
                    echo '<tr class="metric '.$class.'">';
                    echo '<td class="rag"></td>';
                    echo '<td class="title">' . $control->post_title . '</td>';
                    echo '<td class="owner">' . get_avatar($control->post_author, 30) . '</td>';
                    echo '<td class="edit"><a href="' .  get_edit_post_link( $control->ID) . '" target="_blank">' . __('Edit','risklist') . '</a></td>';                 
                    echo '</tr>';                    
                }
            }
            echo '</table>';
            ?>


         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_riskdetails'  && $post->post_type == $this->postType){

        
                $control_meta['risks'] = $_POST['risks'];
                update_post_meta($post->ID,'risklist_risk_meta',$control_meta);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxObjectivesRisks= new risklist_MetaboxObjectivesRisks( __FILE__ );


class risklist_MetaboxRisk {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_risk';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_riskdetails',
            'Select Control(s)',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'side',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

            global $plugin_page, $wpdb;
            $screen = get_current_screen();
            #} retrieve
            $risks = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_control' AND post_status='publish'");

            $control_meta = get_post_meta($post->ID,'risklist_risk_meta',true);

            $risks_array = $control_meta['risks'];

            echo '<select id ="risks" name="risks[]" multiple>';
            foreach($risks as $risk){
            	if(in_array($risk->ID, $risks_array)){
            		$selected = 'selected';
            	}else{
            		$selected = '';
            	}
            	echo '<option value="'.$risk->ID . '" '.$selected.'>'.$risk->post_title.'</option>';
            }
            echo '</select>';
            ?>


         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_riskdetails'  && $post->post_type == $this->postType){

        
              	$control_meta['risks'] = $_POST['risks'];
              	update_post_meta($post->ID,'risklist_risk_meta',$control_meta);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxRisk = new risklist_MetaboxRisk( __FILE__ );


class risklist_MetaboxRiskControls {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_risk';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_riskcontrols',
            'Controls',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'normal',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

            global $plugin_page, $wpdb;
            $screen = get_current_screen();
            #} retrieve
            $controls = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_control' AND post_status='publish'");

            $control_meta = get_post_meta($post->ID,'risklist_risk_meta',true);
            $risks_array = $control_meta['risks'];
            echo '<table class="metric-list table striped">';
            foreach($controls as $control){
                if(in_array($control->ID, $risks_array)){
                echo '<tr class="metric green">';
                echo '<td class="title">' . $control->post_title . '</td>';
                echo '<td class="owner">' . get_avatar($control->post_author, 30) . '</td>';
                echo '<td class="edit"><a href="' .  get_edit_post_link( $control->ID) . '" target="_blank">' . __('Edit','risklist') . '</a></td>';                 
                echo '</tr>';                    
                }
            }
            echo '</table>';
            ?>


         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_riskdetails'  && $post->post_type == $this->postType){

        
                $control_meta['risks'] = $_POST['risks'];
                update_post_meta($post->ID,'risklist_risk_meta',$control_meta);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxRiskControls = new risklist_MetaboxRiskControls( __FILE__ );


class risklist_MetaboxRiskInfo {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_risk';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_riskinfo',
            'Risk Information',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'side',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

            global $plugin_page, $wpdb;
            $screen = get_current_screen();
            #} retrieve

            $risk_meta = get_post_meta($post->ID,'risklist_risk_info',true);


            if($risk_meta['res_impact'] == 1){
            	$b = '31px;';
            }
            if($risk_meta['res_impact'] == 2){
            	$b = '66px;';
            }
            if($risk_meta['res_impact'] == 3){
            	$b = '101px;';
            }
            if($risk_meta['res_impact'] == 4){
            	$b = '139px;';
            }
            if($risk_meta['res_impact'] == 5){
            	$b = '174px;';
            }


            if($risk_meta['res_prob'] == 1){
            	$l = '35px;';
            }
            if($risk_meta['res_prob'] == 2){
            	$l = '80px;';
            }
            if($risk_meta['res_prob'] == 3){
            	$l = '125px;';
            }
            if($risk_meta['res_prob'] == 4){
            	$l = '170px;';
            }
            if($risk_meta['res_prob'] == 5){
            	$l = '218px;';
            }


            ?>

            <div class='risk-bubble'>
                <div class='marker' style="left:<?php echo $l;?>bottom:<?php echo $b;?>"></div>
                <div class='rrow row-5'>
                	<div class='ccol l-1'>5</div>
                	<div class='ccol col-1'>
                	</div>
                	<div class='ccol col-2'>
                	</div>
                	<div class='ccol col-3'>
                	</div>
                	<div class='ccol col-4'>
                	</div>
                	<div class='ccol col-5'>
                	</div>
                </div>
                <div class='rrow row-4'>
                	<div class='ccol l-1'>4</div>
                	<div class='ccol col-1'>
                	</div>
                	<div class='ccol col-2'>
                	</div>
                	<div class='ccol col-3'>
                	</div>
                	<div class='ccol col-4'>
                	</div>
                	<div class='ccol col-5'>
                	</div>
                </div>
                <div class='rrow row-3'>
                	<div class='ccol l-1'>3</div>
                	<div class='ccol col-1'>
                	</div>
                	<div class='ccol col-2'>
                	</div>
                	<div class='ccol col-3'>
                	</div>
                	<div class='ccol col-4'>
                	</div>
                	<div class='ccol col-5'>
                	</div>
                </div>	                                
                <div class='rrow row-2'>
                	<div class='ccol l-1'>2</div>
                	<div class='ccol col-1'>
                	</div>
                	<div class='ccol col-2'>
                	</div>
                	<div class='ccol col-3'>
                	</div>
                	<div class='ccol col-4'>
                	</div>
                	<div class='ccol col-5'>
                	</div>
                </div>
                <div class='rrow row-1'>
                	<div class='ccol l-1'>1</div>
                	<div class='ccol col-1'>
                	</div>
                	<div class='ccol col-2'>
                	</div>
                	<div class='ccol col-3'>
                	</div>
                	<div class='ccol col-4'>
                	</div>
                	<div class='ccol col-5'>
                	</div>
                </div>
                <div class='rrow row-0'>
                	<div class='ccol l-1'></div>
                	<div class='ccol col-1'>1
                	</div>
                	<div class='ccol col-2'>2
                	</div>
                	<div class='ccol col-3'>3
                	</div>
                	<div class='ccol col-4'>4
                	</div>
                	<div class='ccol col-5'>5
                	</div>
                </div>
            </div>
            <div style="clear:both;"></div>

            <?php

            $inherent_risk_scores = array('1','2','3','4','5');
            $inherent_risk__names = array("1 - Very Low", "2 - Low", "3 - Medium", "4 - High", "5 - Very High");
            $inherent_prob__names = array("1 - Remote", "2 - Low", "3 - Possible", "4 - Probable", "5 - Certain");

            echo "<div class='residual-wrapper-select' style='display:none;'>";

            echo "<label>Inherent Impact</label>  ";
            echo '<select id ="inherent_impact" name="inherent_impact">';
            $i=0;
            foreach( $inherent_risk_scores as  $impact){
            	if($risk_meta['inherent_impact'] == $impact){
            		$selected = 'selected';
            	}else{
            		$selected = '';
            	}
            	echo '<option value="'.$impact . '" '.$selected.'>'. $inherent_risk__names[$i] .'</option>';
            $i++;
            }
            echo '</select><br/><div class="clear"></div>';
        
            echo "<label>Inherent Probability</label> ";
            echo '<select id ="inherent_prob" name="inherent_prob">';
            $i = 0;
            foreach( $inherent_risk_scores as  $impact){
            	if($risk_meta['inherent_prob'] == $impact){
            		$selected = 'selected';
            	}else{
            		$selected = '';
            	}
            	echo '<option value="'.$impact . '" '.$selected.'>'. $inherent_prob__names[$i] .'</option>';
            $i++;
            }
            echo '</select><br/><div class="clear"></div>';

            echo "</div>";

            echo "<div class='residual-wrapper-select'>";

            echo "<label>Impact</label>  ";
            echo '<select id ="res_impact" name="res_impact">';
            $i = 0;
            foreach( $inherent_risk_scores as  $impact){
            	if($risk_meta['res_impact'] == $impact){
            		$selected = 'selected';
            	}else{
            		$selected = '';
            	}
            	echo '<option value="'.$impact . '" '.$selected.'>'. $inherent_risk__names[$i] .'</option>';
            $i++;
            }
            echo '</select><br/><div class="clear"></div>';


            echo "<label>Probability</label> ";
            echo '<select id ="res_prob" name="res_prob">';
            $i = 0;
            foreach( $inherent_risk_scores as  $impact){
            	if($risk_meta['res_prob'] == $impact){
            		$selected = 'selected';
            	}else{
            		$selected = '';
            	}
            	echo '<option value="'.$impact . '" '.$selected.'>'. $inherent_prob__names[$i] .'</option>';
            $i++;
            }
            echo '</select><br/><div class="clear"></div>';

            echo "</div>"; #} end residual wrapper.


            ?>
         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_riskdetails'  && $post->post_type == $this->postType){


            
              	$risk_meta['inherent_impact'] = $_POST['inherent_impact'];
              	$risk_meta['inherent_prob'] = $_POST['inherent_prob'];
              	$risk_meta['res_impact'] = $_POST['res_impact'];
              	$risk_meta['res_prob'] = $_POST['res_prob'];

              	update_post_meta($post->ID,'risklist_risk_info',$risk_meta);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxRiskInfo = new risklist_MetaboxRiskInfo( __FILE__ );


/* ======================================================
  / Risk Metabox
   ====================================================== */


   /* ======================================================
  / Processes Metabox
   ====================================================== */

class risklist_MetaboxProcess {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_process';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_process',
            'Process Steps',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'normal',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

        global $plugin_page, $wpdb;
        $screen = get_current_screen();
        #} retrieve
        $process_data_json = get_post_meta($post->ID,'process_data', true);
        $process_data = json_decode($process_data_json);
        ?>

        <table class="table rl-process-table" id="process-tab">
            <thead>
                <th><?php _e("Step","risklist");?></th>
                <th><?php _e("Description","risklist");?></th>
                <th><?php _e("Who","risklist");?></th>
                <th><?php _e("Delete Row","risklist");?></th>
            </thead>

            <?php
                echo '<tbody>';
                $i=1;
                foreach($process_data as $process){
                    if($i==1){
                        echo '<tr>';
                    }
                    switch($i){
                        case 1: 
                            echo '<td class="priority">' . $process . '</td>';
                        break;
                        case 2: 
                            echo '<td class="title">' . $process . '</td>';
                        break;
                        case 3: 
                            echo '<td class="who">' . $process . '</td>';
                        break;
                    }
                    if($i == 3){
                        echo '<td><span class="btn btn-danger btn-delete">Delete Row</span></td>';
                        echo '</tr>';
                        $i=1;
                    }else{
                        $i++;
                    }
                }
            ?>
            </tbody>
        </table>

        <input type="hidden" name="process-data" id="process-data" value='<?php echo $process_data_json; ?>'/>

        <!-- Button trigger modal -->
        <button type="button" class="button-secondary" data-toggle="modal" data-target="#myModal">
          Add Step
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Process Step</h4>
              </div>
              <div class="modal-body">
              <label><?php _e("What:","risklist");?></label> 
                <input type="text" id="process-text" class="form-control"/>
                <hr/>
                <label><?php _e("Who:","risklist");?></label> <?php wp_dropdown_users(); ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="step-save">Save</button>
              </div>
            </div>
          </div>
        </div>
         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_process'  && $post->post_type == $this->postType){

                //save down..

                $process_data = $_POST['process-data'];

                update_post_meta($post->ID,'process_data',$process_data);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxProcess = new risklist_MetaboxProcess( __FILE__ );

class risklist_MetaboxProcessFreq {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_process';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_processfreq',
            'Process Information',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'side',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

        global $plugin_page, $wpdb;
        $screen = get_current_screen();
        #} retrieve
        $process_data = get_post_meta($post->ID,'process_freq', true);
        ?>
        <label><?php _e("Frequency","risklist"); ?></label>
        <select id="freq" name="freq">
        <?php
           $options = array('365', '7', '12');
           $labels = array(__("Daily","risklist"),__("Weekly","risklist"), __("Monthly","risklist"));
           $i = 0;
           foreach($options as $option):?>
             <option <?= ($process_data['freq']===$options[$i])?'selected':'' ?> value="<?php echo $options[$i];?>"><?php echo $labels[$i]; ?></option>
           <?php 
           $i++;
           endforeach;
        ?>

        </select>

        <hr/>

        <label><?php _e("Status","risklist"); ?></label>
        <select id="status" name="status">
        <?php
           $options = array("1", "0");
           $labels = array(__("Complete","risklist"),__("Incomplete","risklist"));
           $i = 0;
           foreach($options as $option){?>
            <option <?= ($process_data['status']===$options[$i])?'selected':'' ?> value="<?php echo $options[$i];?>"><?php echo $labels[$i]; ?></option>
           <?php 
           $i++;
            }
        ?>

        </select>


         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_processfreq'  && $post->post_type == $this->postType){

                //save down..

                $process_data['freq'] = $_POST['freq'];
                $process_data['status'] = $_POST['status'];

                update_post_meta($post->ID,'process_freq',$process_data);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxProcessFreq = new risklist_MetaboxProcessFreq( __FILE__ );


/* ======================================================
Action Metabox
====================================================== */

class risklist_MetaboxAction {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_action';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_actiondetails',
            'Select Risk(s)',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'side',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

            global $plugin_page, $wpdb;
            $screen = get_current_screen();
            #} retrieve
            $risks = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'risklist_risk' AND post_status='publish'");

            $control_meta = get_post_meta($post->ID,'risklist_action_meta',true);

            $risks_array = $control_meta['risks'];

            echo '<select id ="risks" name="risks[]" multiple>';
            foreach($risks as $risk){
            	if(in_array($risk->ID, $risks_array)){
            		$selected = 'selected';
            	}else{
            		$selected = '';
            	}
            	echo '<option value="'.$risk->ID . '" '.$selected.'>'.$risk->post_title.'</option>';
            }
            echo '</select>';
            ?>


         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_actiondetails'  && $post->post_type == $this->postType){

        
              	$control_meta['risks'] = $_POST['risks'];
              	update_post_meta($post->ID,'risklist_action_meta',$control_meta);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxAction = new risklist_MetaboxAction( __FILE__ );

class risklist_MetaboxActionDue {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_action';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_actiondetails',
            'Due Date',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'side',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

        global $plugin_page, $wpdb;
        $screen = get_current_screen();
        $due_date = get_post_meta($post->ID,'risklist_action_date',true);
        ?>


        <input type="text" name="duedate" value="<?php echo $due_date; ?>" />
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_actiondetails'  && $post->post_type == $this->postType){
                $control_meta['risks'] = $_POST['risks'];
                update_post_meta($post->ID,'risklist_action_meta',$control_meta);
                update_post_meta($post->ID,'risklist_action_date',$_POST['duedate']);
            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxActionDue = new risklist_MetaboxActionDue( __FILE__ );

/*==
Metric Metabox
=== */

class risklist_MetaboxMetric {

    //this is the class that outputs the current invoice metabox. 

    static $instance;
    #private $packPerm;
    #private $pack;
    private $postType;

    public function __construct( $plugin_file ) {
       # if ( $this->instance instanceof wProject_Metabox ) {
        #    wp_die( sprintf( __( 'Cannot instantiate singleton class: %1$s. Use %1$s::$instance instead.', 'plugin-namespace' ), __CLASS__ ) );
        #} else {
            self::$instance = $this;
        #}

        $this->postType = 'risklist_metric';
        #if (???) wp_die( sprintf( __( 'Cannot instantiate class: %1$s without pack', 'wptbp' ), __CLASS__ ) );

        add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
        add_filter( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function create_meta_box() {

        #'wptbp'.$this->postType

        add_meta_box(
            'risklist_metric',
            'History',
            array( $this, 'print_meta_box' ),
            $this->postType,
            'normal',
            'high'
        );
    }

    public function print_meta_box( $post, $metabox ) {

        global $plugin_page, $wpdb;
        $screen = get_current_screen();
        #} retrieve
        $process_data_json = get_post_meta($post->ID,'metric_data', true);
        $process_data = json_decode($process_data_json);
        ?>

        <table class="table rl-process-table" id="metric-tab">
            <thead>
                <th><?php _e("#","risklist");?></th>
                <th><?php _e("Date","risklist");?></th>
                <th><?php _e("Value","risklist");?></th>
                <th><?php _e("Delete","risklist");?></th>
            </thead>

            <?php
                echo '<tbody>';
                $i=1;
                foreach($process_data as $process){
                    if($i==1){
                        echo '<tr>';
                    }
                    switch($i){
                        case 1: 
                            echo '<td class="priority">' . $process . '</td>';
                        break;
                        case 2: 
                            echo '<td class="date">' . $process . '</td>';
                        break;
                        case 3: 
                            echo '<td class="title">' . $process . '</td>';
                        break;
                    }
                    if($i == 3){
                        echo '<td><span class="btn btn-danger btn-delete">Delete Row</span></td>';
                        echo '</tr>';
                        $i=1;
                    }else{
                        $i++;
                    }
                }
            ?>
            </tbody>
        </table>

        <input type="hidden" name="metric-data" id="metric-data" value='<?php echo $process_data_json; ?>'/>

        <!-- Button trigger modal -->
        <button type="button" class="button-secondary" data-toggle="modal" data-target="#myModal">
          Add Measurement
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Value</h4>
              </div>
              <div class="modal-body">

                <input type="hidden" id="metricdate" name="metricdate"/>
              <label><?php _e("Value:","risklist");?></label> 
                <input type="text" id="process-text" class="form-control"/>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="metric-step-save">Save</button>
              </div>
            </div>
          </div>
        </div>
         
        <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="subtitle_text" />
        <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
        <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

        <?php
    }

    public function save_meta_box( $post_id, $post ) {
        if( empty( $_POST['meta_box_ids'] ) ){ return; }
        foreach( $_POST['meta_box_ids'] as $metabox_id ){
            if( !isset($_POST[ $metabox_id . '_nonce' ]) || ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }
            #if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ continue; }

            if( $metabox_id == 'risklist_metric'  && $post->post_type == $this->postType){

                //save down..

                $process_data = $_POST['metric-data'];

                update_post_meta($post->ID,'metric_data',$process_data);



            } #} Else no meta set for this quote already? HOW?

         }

        return $post;
    }
}

$risklist_MetaboxMetric = new risklist_MetaboxMetric( __FILE__ );


define('RISKLIST_CONTROL_META',true);