<?php
/**
 *
 * Staff Widget
 *
 */
class MrkDiviWidgetStaffPostType extends ET_Builder_Module
{

    public $name = 'Staff Post Type';
    public $slug = 'mrk_divi_widget_staff_post_type';
    public $fields;

    public function __construct()
    {
        $this->setup();
        parent::__construct();
    }

    public function setup()
    {
        $this->_init_fields();
    }

    public function _init_fields()
    {
        $this->fields = array();
        $this->config = array(
            'name' => 'Staff Post Type',
            'slug' => 'mrk_divi_widget_staff_post_type',
        );

        $this->fields['title_text'] = array(
                'label'           => __('Widget title', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => __('Title to display before the grid.', 'et_builder'),
        );

        $this->fields['mrk_staff_listing_search'] = array(
                        'label'             => 'Enable Search',
                        'type'              => 'yes_no_button',
                        'options'           => array(
                            'off' => __( "No", 'et_builder' ),
                            'on'  => __( 'Yes', 'et_builder' ),
                        ),
                        'description'       => 'Show search form.',
        );

        $this->fields['show_staff_paginated_listing'] = array(
                                'label'             => 'Show paginated listing',
                                'type'              => 'yes_no_button',
                                'options'           => array(
                            'off' => __( "No", 'et_builder' ),
                            'on'  => __( 'Yes', 'et_builder' ),
                        ),
                                'description'       => 'Show listings as paginated or not.',
                                'affects'           => array(
                                    '#et_pb_no_of_staff_per_page',
                ),
        );

        $this->fields['no_of_staff_per_page'] = array(
                                'label'           => 'Number of posts displayed',
                                'type'            => 'text',
                                'description'     => 'Enter the amount of posts to display',
                                'depends_show_if' => 'on',
        );

        $this->fields['include_categories'] = array(
                    'label'           => esc_html__( 'Include from only these categories', 'et_builder' ),
                    'renderer'        => 'et_builder_include_custom_categories_option',
                    'render_options'  => array('term_name' => 'staff_taxonomy'),
                    'option_category' => 'basic_option',
                    'description'     => esc_html__( 'Select the categories that you would like to include in the feed.', 'et_builder' ),
      );

        $this->fields['admin_label'] = array(
                    'label'       => __('Admin Label', 'et_builder'),
                    'type'        => 'text',
                    'description' => __('This will change the label of the module in the builder for easy identification.', 'et_builder'),
            );
    }

    public function init()
    {
        $this->whitelisted_fields = array_keys($this->fields);

        /*
         * Prefix the slug with et_pb
         */
        if (strpos($this->slug, 'et_pb_') !== 0) {
            $this->slug = 'et_pb_'.$this->slug;
        }

        $defaults = array();

        foreach ($this->fields as $field => $options) {
            if (isset($options['default'])) {
                $defaults[$field] = $options['default'];
            }
        }

        $this->field_defaults = $defaults;
    }

       /**
     * Get Fields
     *
     * @return [type] [description]
     */
    public function get_fields()
    {
        return $this->fields;
    }

    public function shortcode_callback($atts, $content = null, $function_name)
    {
        extract($atts);
        ob_start();
        require MRK_STAFF_DIVI_WIDGET_DIR . '/src/templates/mrk_divi_widget_staff_post_type.php';

        return ob_get_clean();
    }
}

new MrkDiviWidgetStaffPostType($dir);
