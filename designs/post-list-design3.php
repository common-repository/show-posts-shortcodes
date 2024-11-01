<!-- post-list-design3.php -->
<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<section class="post-design-3" id="post-design-3">
  <?php if ( $swift_custom_query->have_posts() ) : ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="main-timeline">
              <?php while ( $swift_custom_query->have_posts() ) : $swift_custom_query->the_post(); ?>
                <div class="timeline">
                    <div class="timeline-content">
                      <?php  if ($show_image === 'true'){ ?>
                      <?php $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); ?> 
                        <div class="circle"><span class="homebox">
                           <?php
            // Check if post has a featured image
            if (has_post_thumbnail()) :
            ?>
                <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title(); ?>" class="img">
                </a>
            <?php else : ?>
                <!-- Display default image -->
             <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                <img src="<?php echo esc_url($default_image_url); ?>" alt="<?php the_title(); ?>" class="img">
    </a>
            <?php endif; ?>
                         </span></div>
                         <?php } ?>
                        <div class="content">
                            <span class="year">
                              <?php  if ($show_cat === 'true'){ ?>
							<div class="timeline-cat">
                              <?php echo wp_kses_post(swift_display_categories() );?>
							</div>
                               <?php } ?>
                               <?php  if ($show_date === 'true'){ ?>
								<div class="timeline-date">
                               <?php $date_to_display = get_the_date('j-F-Y');
                               echo esc_html($date_to_display);?></div></span>
                              <?php } ?>
                              <?php  if ($show_title === 'true'){ ?>
                            <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php } ?>
                            <?php  if ($show_content === 'true'){ ?>
                            <p class="description">
                                <?php echo wp_kses(wp_trim_words(get_the_content(), $atts['content_words']), 'post');
?>
                            </p>
                            <?php } ?>
                            <div class="icon"><span></span></div>
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
        </div>
    </div>
</div>
<?php endif; ?>
</section>