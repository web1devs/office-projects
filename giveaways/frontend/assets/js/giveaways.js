jQuery(document).ready(function(){
    // giveaways add to cart
    jQuery(".giveaways_add_to_cart").click(function(){
        let pid = jQuery(this).attr("data-id"); // product id
        let gid = jQuery(this).attr("data-g"); // giveaway id
        if(pid && gid){
            jQuery(this).addClass("disabled");
            jQuery.post("/wp-admin/admin-ajax.php",{'action':'giveaways_add_to_cart','pid':pid,'gid':gid},function(res){
                let obj = JSON.parse(res);
                if(obj.type=='success'){
                    window.location.href=obj.redirect_url;
                }else{
                    alert(obj.successMessages);
                }
            });
        }else{
            alert("Product id or giveaway id not selected!");
        }
    });
});