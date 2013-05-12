jQuery('#search-form-open').click(function(){
    jQuery(this).hide();
    jQuery(this).parent().find('form').addClass('visible');
});