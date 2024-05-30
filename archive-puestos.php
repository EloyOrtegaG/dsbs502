<?php 
/*
Template Name: Puestos
*/
get_header(); 
the_post();

?>  
<div class="container mt-5">
	<div class="row">
	<div class="fichas-puestos mt-50 row">  
      <?php
            $my_query = new WP_Query( array(        
              'post_type' => 'Puesto',
              'posts_per_page' => 9,
              'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            ) );
            while ($my_query->have_posts()) : $my_query->the_post(); ?>
              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 col-xxs-12 mb-30">

                <div class="panel"><?php if ( has_post_thumbnail($post->ID)) : ?>
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">          
                      <?php the_post_thumbnail('full', array('class' => 'img-responsive alignright','alt' => trim(strip_tags( $post->post_title ))));?>                
                    </a>
                  <?php endif; ?>                
                  <h2 class="h4"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>                                    
                  <!--<p> <?php echo (pll__("Puesto").': '); ?><?php   // Get terms for post
                      $terms = get_the_terms( $post->ID , 'puesto' );
                      // Loop over each item since it's an array
                      if ( $terms != null ){
                      foreach( $terms as $term ) {
                      // Print the name method from $term which is an OBJECT
                      print $term->name;
                      // Get rid of the other data stored in the object, since it's not needed
                      unset($term);
                      } } ?>
                  </p>-->
                  <?php the_excerpt() ;?>   
                  <div class="mb-1">
                  <a href="<?php the_permalink() ?>" class="btn btn-default" role="button" title="Leer más"><?php echo pll__("Leer más") ?></a>
                </div>
                  </div>
              </div>
          <?php endwhile; ?>
          <div class="clearfix"></div>
          <div class="paginador mb-50">
  <?php  
//if ( is_user_logged_in() && members_user_has_role( get_current_user_id(), 'clientes' ) || is_user_logged_in() && members_user_has_role( get_current_user_id(), 'administrator' ) ) {

$big = 999999999; // need an unlikely integer
 echo paginate_links( array(
    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $my_query->max_num_pages,
    'prev_next'          => true,
  'prev_text'          => __('« '),
  'next_text'          => __(' »')
) );

wp_reset_postdata();

 

?>
</div>
        
      </div>
		</div>
	</div>	
<?php get_footer();?>