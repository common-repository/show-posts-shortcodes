<!-- post-list-design2.php -->
<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="container" id="post-design-2">
<?php if ( $swift_custom_query->have_posts() ) : 
$sanitized_col = $atts['columns'];  
?>
<div class="row columns-<?php echo esc_html($sanitized_col); ?>">
<?php
     $column_class = 'col-md-' . (12 / $sanitized_col);
    while ( $swift_custom_query->have_posts() ) : $swift_custom_query->the_post(); ?>
  <div class="main-column <?php echo esc_html($column_class); ?>">
  <div class="card card-1">
  <?php $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); ?> 
    <div class="card-img">
     <?php
            // Check if post has a featured image
            if (has_post_thumbnail()) :
            ?>
                <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                    <?php the_post_thumbnail('medium'); ?>
                </a>
            <?php else : ?>
                <!-- Display default image -->
             <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                <img src="<?php echo esc_url($default_image_url); ?>" alt="Default Image">
    </a>
            <?php endif; ?>
    </div>
	  <?php
        $background_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : $default_image_url;
        ?>
    <a href="<?php the_permalink(); ?>" class="card-link">
      <div class="card-img-hovered" style="background-image: var(--card-img-hovered-overlay), url('<?php echo esc_url($background_image_url); ?>');"></div>
    </a>
    <div class="card-info">
      <div class="card-about">
        <?php  if ($show_cat === 'true'){ ?>
		 <div class="cat-wrapper card-cat">
			  <?php echo wp_kses_post(swift_display_categories() );?>
		  </div>
    <?php } ?>
       <?php  if ($show_date === 'true'){ 
       $date_to_display = get_the_date('j-F-Y');
       
        ?>
      <div class="card-time"><?php echo esc_html($date_to_display); ?></div>
      <?php } ?>
      </div>
      <?php  if ($show_title === 'true'){ ?>
      <h1 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
      <?php } ?>
      <?php  if ($show_tag === 'true'){ ?>
      <div class="card-tags"><?php echo wp_kses_post(swift_display_tags() );?></div>
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
