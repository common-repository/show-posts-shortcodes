document.addEventListener('DOMContentLoaded', function() {
jQuery(function($){
$('#post-design-2').find('.card-1').each(function(){
let link = $(this).find('a').attr('href');
$(this).wrapAll( document.createElement( 'a' ) );
$(this).closest('a').attr('href', link);
});
});
});

document.addEventListener('DOMContentLoaded', function() {
jQuery(function($){
$('#post-design-1').find('.blog-card-image').each(function(){
let link = $(this).find('a').attr('href');
$(this).wrapAll( document.createElement( 'a' ) );
$(this).closest('a').attr('href', link);
});
});
});
