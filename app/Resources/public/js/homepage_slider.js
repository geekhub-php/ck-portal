jQuery(document).ready(function() {
    window.change_slides = 1;
    jQuery('.slider ul li:first-child').addClass('current');
    jQuery('a#1').addClass('active');
    setTimeout("changeSlides(1);", 5000);
});

jQuery('.splash li a').click(function() {
    var $i = jQuery(this).attr('id');
    window.change_slides = 0;
    jQuery('.slider ul li a').removeClass('current');
    jQuery('.splash li a').removeClass('active');
    jQuery('.slider li:nth-child('+$i+') a').addClass('current');
    jQuery('a#'+$i).addClass('active');

});

function changeSlides($i) {
    if (window.change_slides != 0) {
        jQuery('.slider ul li').removeClass('current');
        jQuery('a#'+$i).removeClass('active');

        if ($i == 4) {
            jQuery('.slider ul li:first-child').addClass('current');
            jQuery('a#1').addClass('active');
            $i = 1;
        } else {
            $i++;
            jQuery('.slider ul li:nth-child('+$i+')').addClass('current');
            jQuery('a#'+$i).addClass('active');
        }
        setTimeout('changeSlides('+$i+');', 5000);
    }

}