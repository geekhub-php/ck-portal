jQuery(document).ready(function() {
    jQuery('.slider ul li:first-child').addClass('current');
    jQuery('a#dream-1').addClass('active');
    setTimeout("changeSlides(1);", 5000);
});

function changeSlides($i) {
    jQuery('.slider ul li').removeClass('current');
    jQuery('a#dream-'+$i).removeClass('active');

    if ($i == 4) {
        jQuery('.slider ul li:first-child').addClass('current');
        jQuery('a#dream-1').addClass('active');
        $i = 1;
    } else {
        $i++;
        jQuery('.slider ul li:nth-child('+$i+')').addClass('current');
        jQuery('a#dream-'+$i).addClass('active');
    }
    setTimeout('changeSlides('+$i+');', 5000);
}