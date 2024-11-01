<!-- post-list-design1.php -->
<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>


<div class="container-fluid" id="post-design-1">

<?php if ( $swift_custom_query->have_posts() ) : 
$sanitized_col = $atts['columns']; 
?>
<div class="container columns-<?php echo esc_html($sanitized_col); ?>">
  <div class="row">
  <?php
	  $column_class = 'col-md-' . (12 / $sanitized_col);
	  while ( $swift_custom_query->have_posts() ) : $swift_custom_query->the_post(); ?>
    <div class="main-column <?php echo esc_html($column_class); ?>">
  <div class="blog-card blog-card-blog">
	 <?php  if ($show_image === 'true'){ ?>
    <div class="blog-card-image" >
        <?php
            // Check if post has a featured image
            if (has_post_thumbnail()) :
            ?>
                <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                     <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title(); ?>" class="img-wrap">
                </a>
            <?php else : ?>
                <!-- Display default image -->
		         <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                <img src="<?php echo esc_url($default_image_url); ?>" alt="<?php the_title(); ?>" class="default-img">
		</a>
            <?php endif; ?>
    </div>
	 <?php } ?>
    <div class="blog-table">
		<?php  if ($show_cat === 'true'){ ?>
        <h6 class="blog-category blog-text-success"><?php echo wp_kses_post(swift_display_categories() );?></h6>
		<?php } ?>
        <?php  if ($show_title === 'true'){ ?>
        <h4 class="blog-card-caption">
            <a href="<?php the_permalink(); ?>" class="text-wrapper"><?php the_title(); ?></a>
        </h4>
    <?php } ?>
		 <?php  if ($show_content === 'true'){ ?>
        <p class="blog-card-description"><?php echo wp_kses(wp_trim_words(get_the_content(), $atts['content_words']), 'post');
?></p>
		 <?php } ?>
		<?php  if ($show_btn === 'true'){ ?>
        <div class="ftr">
                <a href="<?php the_permalink(); ?>" class="button read-more-btn text-wrapper">Read more</a>
            </div>
		<?php } ?>
    </div>
</div>
</div>
  <?php endwhile; ?>
  </div>
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
</div>