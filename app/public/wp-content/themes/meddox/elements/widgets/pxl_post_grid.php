<?php
$pt_supports = ['post','department','gallery','careers'];
pxl_add_custom_widget(
    array(
        'name' => 'pxl_post_grid',
        'title' => esc_html__('Pxl Post Grid', 'meddox' ),
        'icon' => 'eicon-posts-grid',
        'categories' => array('pxltheme-core'),
        'scripts' => [
            'imagesloaded',
            'isotope',
            'pxl-post-grid',
        ],
        'params' => array(
            'sections' => array(
                array(
                    'name'     => 'tab_layout',
                    'label'    => esc_html__( 'Layout', 'meddox' ),
                    'tab'      => 'layout',
                    'controls' => array_merge(
                        array(
                            array(
                                'name'     => 'post_type',
                                'label'    => esc_html__( 'Select Post Type', 'meddox' ),
                                'type'     => 'select',
                                'multiple' => true,
                                'options'  => meddox_get_post_type_options($pt_supports),
                                'default'  => 'post'
                            ) 
                        ),
                        meddox_get_post_grid_layout($pt_supports),
                    ),
                ),
                array(
                    'name'     => 'tab_layout2',
                    'label'    => esc_html__( 'Icon & Heading', 'meddox' ),
                    'tab'      => 'layout',
                    'controls' => array_merge(
                        array(
                            array(
                                'name' => 'icon_heading',
                                'label' => esc_html__('Icon Heading', 'meddox' ),
                                'type' => \Elementor\Controls_Manager::ICONS,
                                'label_block' => true,
                                'fa4compatibility' => 'icon',
                            ),
                            array(
                                'name' => 'heading',
                                'label' => esc_html__('Heading', 'meddox' ),
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'default' => esc_html__('Click Here', 'meddox'),
                            ),
                            array(
                                'name' => 'bg_title_color',
                                'label' => esc_html__('Background Title Color', 'meddox' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .pxl-gallery-grid-layout2 .wrap-title' => 'background-color: {{VALUE}};',
                                ],
                            ),
                        ),
                        
                    ),
                   
                ),
                
                array(
                    'name' => 'tab_source',
                    'label' => esc_html__('Source', 'meddox' ),
                    'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
                    'controls' => array_merge(
                        array(
                            array(
                                'name'     => 'select_post_by',
                                'label'    => esc_html__( 'Select posts by', 'meddox' ),
                                'type'     => 'select',
                                'multiple' => true,
                                'options'  => [
                                    'term_selected' => esc_html__( 'Terms selected', 'meddox' ),
                                    'post_selected' => esc_html__( 'Posts selected ', 'meddox' ),
                                ],
                                'default'  => 'term_selected'
                            ) 
                        ),
                        meddox_get_grid_term_by_posttype($pt_supports, ['custom_condition' => ['select_post_by' => 'term_selected']]),
                        meddox_get_grid_ids_by_posttype($pt_supports, ['custom_condition' => ['select_post_by' => 'post_selected']]),
                        array(
                            array(
                                'name' => 'orderby',
                                'label' => esc_html__('Order By', 'meddox' ),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'default' => 'date',
                                'options' => [
                                    'date' => esc_html__('Date', 'meddox' ),
                                    'ID' => esc_html__('ID', 'meddox' ),
                                    'author' => esc_html__('Author', 'meddox' ),
                                    'title' => esc_html__('Title', 'meddox' ),
                                    'rand' => esc_html__('Random', 'meddox' ),
                                ],
                            ),
                            array(
                                'name' => 'order',
                                'label' => esc_html__('Sort Order', 'meddox' ),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'default' => 'desc',
                                'options' => [
                                    'desc' => esc_html__('Descending', 'meddox' ),
                                    'asc' => esc_html__('Ascending', 'meddox' ),
                                ],
                            ),
                            array(
                                'name' => 'limit',
                                'label' => esc_html__('Total items', 'meddox' ),
                                'type' => \Elementor\Controls_Manager::NUMBER,
                                'default' => '6',
                            ),
                        )
                    ),
                ),
                array(
                    'name' => 'tab_grid',
                    'label' => esc_html__('Grid', 'meddox' ),
                    'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
                    'controls' => array(
                        array(
                            'name' => 'img_size',
                            'label' => esc_html__('Image Size', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'description' => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Default: 370x300 (Width x Height)).',
                        ),
                        array(
                            'name' => 'pxl_animate',
                            'label' => esc_html__('Case Animate', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => meddox_widget_animate(),
                            'default' => '',
                        ),
                        array(
                            'name' => 'filter',
                            'label' => esc_html__('Filter on Masonry', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'false',
                            'options' => [
                                'true' => esc_html__('Enable', 'meddox' ),
                                'false' => esc_html__('Disable', 'meddox' ),
                            ],
                            'condition' => [
                                'select_post_by' => 'term_selected',
                            ],
                        ),
                        array(
                            'name' => 'filter_default_title',
                            'label' => esc_html__('Filter Default Title', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => esc_html__('All', 'meddox' ),
                            'condition' => [
                                'filter' => 'true',
                                'select_post_by' => 'term_selected',
                            ],
                        ),
                        array(
                          'name' => 'filter_alignment',
                          'label' => esc_html__( 'Filter Alignment', 'meddox' ),
                          'type' => \Elementor\Controls_Manager::CHOOSE,
                          'control_type' => 'responsive',
                          'options' => [
                            'left' => [
                                'title' => esc_html__( 'Left', 'meddox' ),
                                'icon' => 'eicon-text-align-left',
                            ],
                            'center' => [
                                'title' => esc_html__( 'Center', 'meddox' ),
                                'icon' => 'eicon-text-align-center',
                            ],
                            'right' => [
                                'title' => esc_html__( 'Right', 'meddox' ),
                                'icon' => 'eicon-text-align-right',
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .pxl-grid .pxl-grid-filter' => 'text-align: {{VALUE}};',
                        ],
                        'condition' => [
                            'filter' => 'true',
                            'select_post_by' => 'term_selected',
                        ],
                    ),
                        array(
                            'name' => 'pagination_type',
                            'label' => esc_html__('Pagination Type', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'false',
                            'options' => [
                                'pagination' => esc_html__('Pagination', 'meddox' ),
                                'loadmore' => esc_html__('Loadmore', 'meddox' ),
                                'false' => esc_html__('Disable', 'meddox' ),
                            ],
                        ),
                        array(
                            'name' => 'pagination_style',
                            'label' => esc_html__('Pagination Style', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'pxl-pagination-style1',
                            'options' => [
                                'pxl-pagination-style1' => 'Style 1',
                                'pxl-pagination-style2' => 'Style 2',
                            ],
                            
                        ),
                        array(
                            'name' => 'col_xs',
                            'label' => esc_html__('Columns XS Devices', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '1',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'col_sm',
                            'label' => esc_html__('Columns SM Devices', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '2',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'col_md',
                            'label' => esc_html__('Columns MD Devices', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '3',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'col_lg',
                            'label' => esc_html__('Columns LG Devices', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '4',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'col_xl',
                            'label' => esc_html__('Columns XL Devices', 'meddox' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '4',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'grid_masonry',
                            'label' => esc_html__('Grid Masonry', 'meddox'),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'controls' => array(
                                array(
                                    'name' => 'col_xs_m',
                                    'label' => esc_html__('Columns XS Devices', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '1',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'col_sm_m',
                                    'label' => esc_html__('Columns SM Devices', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '2',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'col_md_m',
                                    'label' => esc_html__('Columns MD Devices', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '3',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'col_lg_m',
                                    'label' => esc_html__('Columns LG Devices', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '4',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'col_xl_m',
                                    'label' => esc_html__('Columns XL Devices', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '4',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'img_size_m',
                                    'label' => esc_html__('Image Size', 'meddox' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'description' => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Default: 370x300 (Width x Height)).',
                                ),
                            ),
),
),
),
array(
    'name' => 'tab_display',
    'label' => esc_html__('Display', 'meddox' ),
    'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
    'controls' => array(
        array(
            'name' => 'show_category',
            'label' => esc_html__('Show Category', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'true',
            
        ),
        array(
            'name' => 'show_date',
            'label' => esc_html__('Show Date', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'true',
            
            
        ),
        array(
            'name' => 'show_title',
            'label' => esc_html__('Show Title', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'true',
            
        ),
        array(
            'name' => 'show_comment',
            'label' => esc_html__('Show Comment', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'true',
            
        ),
        array(
            'name' => 'show_author',
            'label' => esc_html__('Show Author', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'true',
            
        ),
        array(
            'name' => 'show_button',
            'label' => esc_html__('Show Button Readmore', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'true',
            
        ),
        array(
            'name' => 'button_text',
            'label' => esc_html__('Button Text', 'meddox' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            
        ),
        array(
            'name' => 'show_excerpt',
            'label' => esc_html__('Show Excerpt', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'true',
            
        ),
        array(
            'name' => 'num_words',
            'label' => esc_html__('Number of Words', 'meddox' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 25,
            'separator' => 'after',
            
        ),
        
    ),
),
array(
    'name' => 'tab_style_general',
    'label' => esc_html__('General', 'meddox' ),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'style_post_l1',
            'label' => esc_html__('Style', 'meddox' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => esc_html__('Style 1', 'meddox' ),
                'style2' => esc_html__('Style 2', 'meddox' ),
            ],
           
        ),
        array(
          'name' => 'box_align',
          'label' => esc_html__( 'Box Alignment', 'meddox' ),
          'type' => \Elementor\Controls_Manager::CHOOSE,
          'control_type' => 'responsive',
          'options' => [
            'left' => [
                'title' => esc_html__( 'Left', 'meddox' ),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__( 'Center', 'meddox' ),
                'icon' => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => esc_html__( 'Right', 'meddox' ),
                'icon' => 'eicon-text-align-right',
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .pxl-department-grid-layout1 .item--holder' => 'text-align: {{VALUE}};',
        ],
        
    ),
    ),
),
array(
    'name' => 'tab_style_title',
    'label' => esc_html__('Title', 'meddox' ),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'title_color',
            'label' => esc_html__('Title Color', 'meddox' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pxl-department-grid-layout1 .item--title' => 'color: {{VALUE}};',
            ],
            
        ),
        array(
            'name' => 'title_typography',
            'label' => esc_html__('Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-department-grid-layout1 .item--title',
            
        ),
    ),
),
array(
    'name' => 'tab_style_category',
    'label' => esc_html__('Category', 'meddox' ),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'category_typography',
            'label' => esc_html__('Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-department-grid-layout1 .item--category',
            
        ),
    ),
),
array(
    'name' => 'tab_style_filter',
    'label' => esc_html__('Filter', 'meddox' ),
    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    'controls' => array(
        array(
            'name' => 'filter_typography',
            'label' => esc_html__('Typography', 'meddox' ),
            'type' => \Elementor\Group_Control_Typography::get_type(),
            'control_type' => 'group',
            'selector' => '{{WRAPPER}} .pxl-grid-filter .filter-item',
            
        ),
    ),
),
),
),
),
meddox_get_class_widget_path()
);