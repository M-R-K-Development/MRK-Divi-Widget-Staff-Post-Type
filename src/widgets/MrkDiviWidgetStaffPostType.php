<?php
/**
 *
 * Staff Widget
 *
 */
class MrkDiviWidgetStaffPostType extends DiviCustomWidget
{

    public function __construct($dir)
    {
        $this->config = array(
            'name' => 'Staff Post Type',
            'slug' => 'mrk_divi_widget_staff_post_type',
        );

        $this->addField(
            array(
                'title_text' => array(
                'label'           => __('Widget title', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => __('Title to display before the grid.', 'et_builder'),
                ),
            )
        );

        $this->addField(
                array(
                    'show_staff_paginated_listing' => array(
                                'label'             => 'Show paginated listing',
                                'type'              => 'yes_no_button',
                                'description'       => 'Show listings as paginated or not.',
                                'affects'           => array(
                                    '#et_pb_no_of_staff_per_page',
                                ),
                        ),
                )
        );

        $this->addField(
                array(
                    'no_of_staff_per_page' => array(
                                'label'           => 'Number of posts displayed',
                                'type'            => 'text',
                                'description'     => 'Enter the amount of posts to display',
                                'depends_show_if' => 'on',
                        ),
                )
        );

        $this->addField(array(
                 'include_categories' => array(
                    'label'           => esc_html__( 'Include from only these categories', 'et_builder' ),
                    'renderer'        => 'et_builder_include_custom_categories_option',
                    'render_options'  => array('term_name' => 'staff_taxonomy'),
                    'option_category' => 'basic_option',
                    'description'     => esc_html__( 'Select the categories that you would like to include in the feed.', 'et_builder' ),
                ),
      ));

        $this->addField(
                array(
                    'admin_label' => array(
                    'label'       => __('Admin Label', 'et_builder'),
                    'type'        => 'text',
                    'description' => __('This will change the label of the module in the builder for easy identification.', 'et_builder'),
                    ),
                )
            );

        parent::__construct($dir);
    }
}

new MrkDiviWidgetStaffPostType($dir);
