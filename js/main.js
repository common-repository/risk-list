jQuery(function() {
    jQuery('input[name="duedate"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MMM/YYYY'
        }
    }, 
    function(start, end, label) {

    });

    jQuery('input[name="metricdate"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MMM/YYYY'
        }
    }, 
    function(start, end, label) {

    });


    jQuery("#step-save").unbind("click").bind("click", function(e){
        var count = jQuery('.priority').length + 1;
        var process_text = jQuery('#process-text').val();
        var process_who = jQuery("#user").val();

        jQuery.each(window.risklist_user, function(index, value) {
            if(process_who == index){
                avatar = value;
            }
        });

        if(count == 1){
            jQuery('#process-tab > tbody').html('<tr><td class="priority">'+count+'</td><td class="title">'+process_text+'</td><td class="who"><img src="'+avatar+'"/></td><td><span class="btn btn-danger btn-delete">Delete Row</span></td></tr>');
        }else{
            jQuery('#process-tab > tbody > tr:last').after('<tr><td class="priority">'+count+'</td><td class="title">'+process_text+'</td><td class="who"><img src="'+avatar+'"/></td><td><span class="btn btn-danger btn-delete">Delete Row</span></td></tr>');
        }

        console.log('saving process ' + count + ' step text ' + process_text + ' who ' + process_who);

        var processs_json = [];

        jQuery('#process-tab > tbody  > tr').each(function(){

            console.log('table row');

            jQuery(this).find('td').each (function() {
              if(jQuery(this).hasClass('priority')){
                    p_counter = jQuery(this).html();
              }
              if(jQuery(this).hasClass('title')){
                    p_title = jQuery(this).html();
              }
              if(jQuery(this).hasClass('who')){
                 p_who = jQuery(this).html();
              }
            });

            processs_json.push(p_counter, p_title, p_who);

        });

        console.log('process json');
        console.log(processs_json);

        jQuery('#process-data').val(JSON.stringify(processs_json));
    });

    jQuery("#metric-step-save").unbind("click").bind("click", function(e){
        var count = jQuery('.priority').length + 1;
        var process_text = jQuery('#process-text').val();
        var process_date = jQuery("#metricdate").val();


        if(count == 1){
            jQuery('#metric-tab > tbody').html('<tr><td class="priority">'+count+'</td><td class="date">'+process_date+'</td><td class="title">'+process_text+'</td><td><span class="btn btn-danger btn-delete">Delete Row</span></td></tr>');
        }else{
            jQuery('#metric-tab > tbody > tr:last').after('<tr><td class="priority">'+count+'</td><td class="date">'+process_date+'</td><td class="title">'+process_text+'</td><td><span class="btn btn-danger btn-delete">Delete Row</span></td></tr>');
        }

        var processs_json = [];

        jQuery('#metric-tab > tbody  > tr').each(function(){

            console.log('table row');

            jQuery(this).find('td').each (function() {
              if(jQuery(this).hasClass('priority')){
                    p_counter = jQuery(this).html();
              }
              if(jQuery(this).hasClass('title')){
                    p_title = jQuery(this).html();
              }
              if(jQuery(this).hasClass('date')){
                 p_date = jQuery(this).html();
              }
            });

            processs_json.push(p_counter, p_date, p_title);

        });

        console.log('process json');
        console.log(processs_json);

        jQuery('#metric-data').val(JSON.stringify(processs_json));
    });


});


jQuery(document).ready(function() {
    //Helper function to keep table row from collapsing when being sorted
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index)
        {
          jQuery(this).width($originals.eq(index).width())
        });
        return $helper;
    };

    //Make diagnosis table sortable
    jQuery("#process-tab tbody").sortable({
        helper: fixHelperModified,
        stop: function(event,ui) {renumber_table('#process-tab')}
    }).disableSelection();

    //Delete button in table rows
    jQuery('table').on('click','.btn-delete',function() {
        tableID = '#' + jQuery(this).closest('table').attr('id');
        r = confirm('Delete this item?');
        if(r) {
            jQuery(this).closest('tr').remove();
            renumber_table(tableID);
            }
    });
});

//Renumber table rows
function renumber_table(tableID) {
    jQuery(tableID + " tr").each(function() {
        count = jQuery(this).parent().children().index(jQuery(this)) + 1;
        jQuery(this).find('.priority').html(count);
    });
}