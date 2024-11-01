<!-- post-list-design4.php -->
<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="post-design-4" id="post-design-4">
    <?php if ( $swift_custom_query->have_posts() ) : 
    $sanitized_col = $atts['columns'];   
    ?>
    <div class="row">

<?php
	$column_class = 'col-md-' . (12 / $sanitized_col);
    while ( $swift_custom_query->have_posts() ) : $swift_custom_query->the_post(); ?>
<div class="main-column <?php echo esc_html($column_class); ?>">
  <div class="blog-card">
    <div class="meta">
		<?php  if ($show_image === 'true'){ ?>
        <?php
        $background_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : $default_image_url;
        ?>
      <div class="photo" style="background-image: url('<?php echo esc_url($background_image_url); ?>')"></div>
		<?php } ?>
      <ul class="details">
		 <?php  if ($show_author === 'true'){ ?>
        <li class="author"><a href="<?php the_permalink(); ?>"><?php the_author(); ?></a></li>
		  <?php } ?>
		 <?php  if ($show_date === 'true'){ 
       $date_to_display = get_the_date('j-F-Y');
      ?>
        <li class="date"><?php echo esc_html($date_to_display) ?></li>
		  <?php } ?>
		 <?php  if ($show_tag === 'true'){ ?>
        <li class="tags">
          <?php echo wp_kses_post(swift_display_tags() );?>
        </li>
		<?php } ?>
		   <?php  if ($show_cat === 'true'){ ?>
		  <li class="categorary">
             <?php echo wp_kses_post(swift_display_categories() );?>
		  </li>
          <?php } ?>
      </ul>
    </div>
    <div class="description">
	   <?php  if ($show_title === 'true'){ ?>
      <h2>
		  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </h2>
		 <?php } ?>
	   <?php  if ($show_content === 'true'){ ?>
      <p> <?php echo wp_kses(wp_trim_words(get_the_content(), $atts['content_words']), 'post'); ?></p>
	   <?php } ?>
	<?php  if ($show_btn === 'true'){ ?>
      <p class="read-more">
        <a href="<?php the_permalink(); ?>">Read More</a>
      </p>
	<?php } ?>
    </div>
  </div>
</div>
  <?php endwhile; ?>
		<div class="pagination" id="pagination-wrapper">
            <?php
           echo wp_kses(
					 paginate_links(array(
						 'total'      => ceil($total_posts / $atts['posts_per_page']),
						  'current'    => max(1, $paged),
						  'format'     => '?paged=%#%',
						  'type'       => 'list',
						  'prev_text'  => '&laquo;',
						  'next_text'  => '&raquo;',
						 'before_page_number' => '<span class="pagination-number">',
                         'after_page_number'  => '</span>', 
   )),
   array('ul' => array('class' => array('pagination-num')), 'li' => array(), 'span' => array('class' => array()), 'a' => array('href' => array()))
);
			?>
</div>
<?php endif; ?>
</div>