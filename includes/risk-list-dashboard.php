<?php

 if ( ! defined( 'RISKLIST_PATH' ) ) exit;

function risklist_add_dashboard_widgets() {

    wp_add_dashboard_widget(
                 'risklist_summary_widget',         // Widget slug.
                 'Heat Map',         // Title.
                 'risklist_risk_summary' // Display function.
        );  

    wp_add_dashboard_widget(
                 'risklist_overview_widget',         // Widget slug.
                 'Risk Overview',         // Title.
                 'risklist_risk_overview' // Display function.
        ); 

    wp_add_dashboard_widget(
                 'risklist_metric_widget',         // Widget slug.
                 'Metrics',         // Title.
                 'risklist_metric_overview' // Display function.
        ); 

    wp_add_dashboard_widget(
                 'risklist_action_widget',         // Widget slug.
                 'Actions',         // Title.
                 'risklist_action_overview' // Display function.
        ); 

    wp_add_dashboard_widget(
                 'risklist_process_widget',         // Widget slug.
                 'Processes',         // Title.
                 'risklist_process_overview' // Display function.
        ); 

}
add_action( 'wp_dashboard_setup', 'risklist_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function risklist_risk_summary() {
    risklist_riskbubble();
}

function risklist_risk_overview(){
    risklist_risksummary();
}

function risklist_metric_overview(){
    risklist_metricsummary();
}

function risklist_action_overview(){
    risklist_actionsummary();
}

function risklist_process_overview(){
    risklist_processsummary();
}


define('RISKLIST_DASHBOARDS',true);


?>