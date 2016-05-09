<?php
    /**
     * Type of custom post to collect
     * @var string
     */
    $custom_post_type = 'staff';
?>
        @if ($title_text)
            <h3>{{$title_text}}</h3>
        @endif

        @if ($custom_post_type)
            <?php

            $i = 0;
            //Query events according to shortcode
            $eventargs = array(
                    'post_type'      => $custom_post_type,
            );

            if ($show_staff_paginated_listing == 'on') {
                $show_pagination               = true;
                $page_no                       = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $eventargs['posts_per_page']   = $no_of_staff_per_page;

                $eventargs['paged']  = $page_no;
            } else {
                $show_pagination             = false;
                $eventargs['posts_per_page'] = -1;
            }

            $terms_args = array(
                'orderby' => 'name',
                'order'   => 'ASC',
            );

            if ( !is_null($include_categories) || $include_categories ) {
                $included_terms         = explode( ',', $include_categories );
                $terms_args['include']  = $included_terms;

                $eventargs['tax_query'] = array(
                    array(
                        'taxonomy' => 'staff_taxonomy',
                        'field'    => 'id',
                        'terms'    => $included_terms,
                        'operator' => 'IN',
                    ),
                );
            }

            $terms = get_terms( 'staff_taxonomy', $terms_args );

            global $wp_query;

            $temp_query = $wp_query;

            $wp_query = new WP_Query($eventargs);

            ?>


            @while ($wp_query->have_posts())
                    <?php
                        //Set vars
                        $wp_query->the_post();
                        $url        = get_post_permalink();
                        $title      = get_the_title( );
                        $image      = wp_get_attachment_url( get_post_thumbnail_id() );
                        $role       = get_field('role');

                        // Category Classes
                        $category_classes = array();
                        $categories       = get_the_terms( get_the_ID(), 'staff_taxonomy' );
                        if ( $categories ) {
                            foreach ( $categories as $category ) {
                                $category_classes[]    = 'project_category_' . urldecode( $category->slug );
                                $categories_included[] = $category->term_id;
                            }
                        }

                        $category_classes = implode( ' ', $category_classes );

                        $main_post_class = sprintf(
                                    'et_pb_portfolio_item et_pb_grid_item %1$s',
                                    $category_classes
                                );

                        $i++;

                        $css_class = 'et_pb_column_12';

                        if($i==4){
                            $css_class = 'et_pb_column_12 last';
                            $i=0;
                        }

                    ?>
                    
                            <?php $shortcode = sprintf('<div class="et_pb_column et_pb_column_1_4  %s">[et_pb_team_member admin_label="Person" name="%s" position="%s" image_url="%s" animation="off" background_layout="light" use_border_color="off" border_color="#ffffff" border_style="solid" facebook_url="" twitter_url="" google_url="" linkedin_url="" module_class="%s"][/et_pb_team_member]</div>', $css_class, $title, $role , $image, $css_class);
                         ?>
                        {{ do_shortcode( $shortcode ); }}
                    

            @endwhile

			@if($show_pagination)
				<div class='et_pb_gallery_pagination'>
					<div class="pagination clearfix">
						<div class="alignleft"><?php echo previous_posts_link(esc_html__('&laquo; Older Entries', 'Divi')); ?></div>
						<div class="alignright"><?php echo next_posts_link(esc_html__('Next Entries &raquo;', 'Divi')); ?></div>
					</div>

				</div>
			@endif

		<?php $wp_query = $temp_query; ?>

    @endif
