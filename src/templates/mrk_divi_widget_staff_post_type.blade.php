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


            @if($mrk_staff_listing_search == 'on')
            <div class="et_pb_search et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_search_0">
                <form role="search" method="get" class="et_pb_searchform" action="/" _lpchecked="1">
                    <div>
                        <label class="screen-reader-text" for="s">Search for:</label>
                        <input type="hidden" name="post_type" value="{{ $custom_post_type }}" />
                        <input type="text" value="" name="s" class="et_pb_s" style="padding-right: 74px;">
                        <input type="submit" value="Search" class="et_pb_searchsubmit">
                    </div>
                </form>
            </div>
            @endif




            <div class="et_pb_filterable_portfolio et_pb_filterable_portfolio_grid clearfix et_pb_module et_pb_bg_layout_light  et_pb_filterable_portfolio_0" style="width:100%;">

            <div class="et_pb_portfolio_filters clearfix" style="width:100%;">
                <ul class="clearfix">
                    <li class="et_pb_portfolio_filter et_pb_portfolio_filter_all"><a href="#" class="active" data-category-slug="all">{{ esc_html__( 'All', 'et_builder' ) }}</a></li>

                    @foreach ( $terms as $term  )
                    <li class="et_pb_portfolio_filter"><a href="#" data-category-slug="{{ esc_attr( urldecode( $term->slug ) ) }}">{{ esc_html( $term->name ) }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="et_pb_portfolio_items_wrapper">
                <div class="et_pb_portfolio_items">


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
                    ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class( $main_post_class ); ?>>
                            <?php $shortcode = sprintf('[et_pb_blurb admin_label="Blurb" title="%s" url_new_window="off" use_icon="off"  image="%s" icon_placement="top" animation="off" background_layout="light" text_orientation="center" use_icon_font_size="off" use_border_color="off" border_color="#ffffff" border_style="solid"]
                                %s
                         [/et_pb_blurb]', $title, $image, $role);
                         ?>
                        {{ do_shortcode( $shortcode ); }}


                    </div>

             @endwhile
             </div>
             </div>
            </div>


			@if($show_pagination)
				<div class='et_pb_gallery_pagination'>
					<div class="pagination clearfix">
						<div class="alignleft"><?php echo previous_posts_link(esc_html__('&laquo; Older Entries', 'Divi')); ?></div>
						<div class="alignright"><?php echo next_posts_link(esc_html__('Next Entries &raquo;', 'Divi')); ?></div>
					</div>

				</div>
			@endif

        </div>

				<?php $wp_query = $temp_query; ?>

    @endif
