function giftCardCustomPriceEnable(data){
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent();
    jQuery(parent).find("input[name=gift_card_default_price]:checked").prop("checked",false);
    jQuery(data).removeAttr("readonly");
    jQuery(parent).find(".gift-card-amount-error").html("<p>Vinsamlegast sláið inn upphæðina sem þið viljið gefa</p>");
}

function giftCardCustomPriceChange(data){
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent();
    let price=jQuery(data).val();
    let min=jQuery(data).attr("data-min");
    if(parseInt(price)<parseInt(min)){
        jQuery(data).addClass("error");
        jQuery(parent).find(".gift-card-amount-error").html("<p>Custom amount should be greater than minimum amount</p>");
        jQuery(parent).find(".single_add_to_cart_button").prop("disabled",true);
        giftCardAmountShow(parent,min);
    }else{
        jQuery(parent).find(".gift-card-amount-error").html("");
        jQuery(parent).find(".single_add_to_cart_button").prop("disabled",false);
        giftCardAmountShow(parent,price);
    }

    
}

function giftCardDefaultPrice(data){
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent();
    let price=jQuery(data).val();
    giftCardAmountShow(parent,price);
    jQuery(parent).find("input[name=custom_price]").val("");
    jQuery(parent).find("input[name=custom_price]").attr("readonly",true);
}

function giftCardAmountShow(parent,amount){
    jQuery(parent).find("input[name=gift_card_amount]").val(amount);
    let value = accounting.formatMoney(amount, {
        symbol: 'kr.',
        decimal: ',',
        thousand: '.',
        precision: '0',
        format: '%v %s'
      });
      jQuery(parent).find(".gift_card_value").html(value);  
}

function giftCardMessagePreview(data){
    //var message = jQuery(data).val();
    var message = data.value;
    //message = jQuery.parseHTML( message.replace(/(<([^>]+)>)/gi, "").replace(/\n/g, '<br/>') );
    data.closest(".entry-summary").previousElementSibling.querySelector(".gift_card_message_text").innerHTML=message.replace(/(<([^>]+)>)/gi, "").replace(/\n/g, '<br/>');
}

function giftCardCustomAmountFocus(data){
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent();
    let price=parseInt(jQuery(data).val());
    let min=parseInt(jQuery(data).attr("data-min"));
    if(price>0){
        if(price<min){
            jQuery(parent).find("input[name=gift_card_default_price].gift_card_default_amount").prop("checked",true);
            giftCardAmountShow(parent,min);
            jQuery(data).val("");
            jQuery(data).attr("readonly",true); 
            jQuery(parent).find(".gift-card-amount-error").html("");
            jQuery(parent).find(".single_add_to_cart_button").prop("disabled",false);
        }
    }else{
        jQuery(parent).find("input[name=gift_card_default_price].gift_card_default_amount").prop("checked",true);
        jQuery(data).val("");
        jQuery(data).attr("readonly",true);
        jQuery(parent).find(".gift-card-amount-error").html("");
        jQuery(parent).find(".single_add_to_cart_button").prop("disabled",false);
    }
}

function selectThisGiftCardImage(data){
    
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent().parent().parent();
    jQuery(parent).find("img.active").removeClass("active");
    let img = jQuery(data).attr("src");
    let cls=jQuery(data).attr("data-class");
    jQuery(data).addClass("active");
    //jQuery("input[name=gift_card_image]").val(img);
    //jQuery("#gift_card_image").attr("src",img);
    
    
    data.closest(".img_thumbnail").nextElementSibling.value=img;
    data.closest(".entry-summary").previousElementSibling.querySelector(".gift_card_image").src=img;
}

function openImgCat(data, evt, cityName) {
    jQuery(data).parent().find('.active').removeClass("active");
    jQuery(data).addClass("active");

    jQuery(data).parent().parent().parent().find('div.tabcontent').hide();
    jQuery(data).parent().parent().parent().find('div.'+cityName+'').show();
}


  function deliveryDate(data) {
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent().parent().parent().parent();
    var deliveryDate = jQuery(data).val();
    jQuery(parent).find('._Date').text(deliveryDate.split("-").reverse().join("/"));
  }

function toggleDateDiv(checkbox) {
    if(checkbox.checked == true){
        checkbox.closest(".toggleDateDivClass").nextElementSibling.style.display='block';
    }else{
        checkbox.closest(".toggleDateDivClass").nextElementSibling.style.display='none';
   }
}