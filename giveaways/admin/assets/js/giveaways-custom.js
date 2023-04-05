
jQuery(document).ready(function($){

    let button = $("#giveaways_contaniner input.button");

    button.on("click",function(){

        let entrie_number_input_field_label = $("#entrie_number").val();
        let search_giveaways_label = $("#giveaways_search").val();
        let order_status = $("#giveways_order_status").val();
        let giveaways_additional_entry = $("#giveaways_additional_entry").val();

        let giveaways_estimate_value = $("#giveaways_estimate_value").val();
        let viral_sweep_api_key = $("#viral_sweep_api_key").val();

        
        /* ajax part here */

        $("#loader_img").show();

        let ajax = $.ajax({
            type: "POST",
            url: xajaxurl.xajaxurl,
            data:{
                action: 'giveaways_settings_option',
                entrie_number_input_field_label: entrie_number_input_field_label,
                search_giveaways_label: search_giveaways_label,
                giveways_order_status: order_status,
                giveaways_additional_entry: giveaways_additional_entry,
                giveaways_estimate_value: giveaways_estimate_value,
                viral_sweep_api_key: viral_sweep_api_key
                
            },
            complete: function(jqXHR) {
                
                if(jqXHR.readyState === 4) {
                    let response = jqXHR.statusText;
                    console.log(response);
                    // $("p#ppp").text(response);
                    if(response=='OK'){
                        $("#loader_img").hide();
                    }
                }   
            }  
        });
      

    }); /* end  admin settings */


    /* date and time picker section start here */
    $("#opening_date_time").datetimepicker({
        timepicker:true,
        datepicker:true,

    });

    $("#closing_date_time").datetimepicker({
        timepicker:true,
        datepicker:true,
    });

    $("#draw_date_time").datetimepicker({
        timepicker:true,
        datepicker:true,
    });
        
    /* date and time picker section end here */

/*  add new button wp-content editor  section end here */

     /* make a popup*/

     $("#giveaway_shortcode_button").on("click",function(){
        // console.log("done");
        $("#popup_modal").css("display","block");

        $(".remove_from").on("click",function(){
            $("#popup_modal").hide();
        });
    });

    // icon select dropdown
   

    $("#fonts_setup").on("change",function(){

       let forntSetup =  $(this).val();
        $(".icon_container").hide();
       if( forntSetup === "icon"){

          $(".container_font_awesome").show();

       }else if(  forntSetup === "iconsmind"){

          $(".container_iconsmind").show();

       } else if(  forntSetup === "steadysets"){

          $(".container_steadysets").show();

       }else if(  forntSetup === "lineicons"){

         $(".container_lineicons").show();

       }

        
    });

    $(".icon_container i").click(function(){
        $(".icon_container i.selected").removeClass("selected");
        $(this).addClass("selected");
    });

    $("#shortcode_submit").on("click",function(){

        let shortcode_button_text = $(".button_text").val();
        let shortcode_btn_size = $(".shortcode_btn_size").val();
        let btn_style_one = $(".btn_style_one").val();
        let button_override_color = $(".button_override_color").val();

        let container_fonts = $(".icon_container i.selected").attr('class');
       
        console.log(shortcode_button_text);
        console.log(shortcode_btn_size);
        console.log(btn_style_one);
        console.log(button_override_color);
        console.log(container_fonts);
        
        let tt = '[individual_giveaway_add_to_cart_button btn_size="'+shortcode_btn_size+'" btn_style="'+btn_style_one+'" text="'+shortcode_button_text+'" color_override="'+button_override_color+'" btn_fonts="'+container_fonts+'" ]';

        let btn = '[individual_giveaway_add_to_cart color="Accent-Color" hover_text_color_override="#fff" size="'+shortcode_btn_size+'" btn_style="'+btn_style_one+'" text="'+shortcode_button_text+'" color_override="'+button_override_color+'" image="'+container_fonts+'" ]';

        window.wp.media.editor.insert( btn );
        $("#popup_modal").hide();

    });

});

jQuery(document).on("keyup",".giveaways_search",function(){
    let parent = jQuery(this).parent().parent();
   let keyword = jQuery(this).val();
    let exids = jQuery(parent).find("input.giveways_multi_entries").val();
    jQuery.ajax({
        type:'POST',
        url: xajaxurl.xajaxurl,
        data:{
            action: 'giveaways_search',
            keyword: keyword,
            exids:exids
        },
        success: function(response){

            jQuery(parent).find(".giveaways_list").html(response);
        }
    });

});




function choose_this_giveaways(data){

    let parent = jQuery(data).parent().parent().parent().parent();
    let id = jQuery(data).attr("data-id");
    let name = jQuery(data).attr("data-name");
    let newVal = id;
    let oldVal = jQuery(parent).find("input.giveways_multi_entries").val();
    if( oldVal ){
         newVal = oldVal+','+id;
    }
    // console.log(oldVal);
    jQuery(parent).find("input.giveways_multi_entries").val(newVal);


    let html = `
       <span>
       ${name}
       <span class="giveaway_close" data-id="${id}" onclick="giveaway_list_close(this)">X</span>
       </span>
    `;


    jQuery(parent).find(".selected_giveaways").append(html);


    jQuery(data).remove();
}


function giveaway_list_close(data){
    let parent = jQuery(data).parent().parent().parent().parent();
    let oldVal = jQuery(parent).find("input.giveways_multi_entries").val();
    let id = jQuery(data).attr("data-id");

    let oldValArray=oldVal.split(',');

    let newValArray = oldValArray.filter(function(item) {
        return item !== id
    });

    let newVal = '';
    if(newValArray.length>0){
        newVal=newValArray.toString();
    }


    jQuery(parent).find("input.giveways_multi_entries").val(newVal);


    jQuery(data).parent().remove();
}






