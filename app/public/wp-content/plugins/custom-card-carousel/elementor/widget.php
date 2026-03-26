<?php
/**
 * Elementor Widget — Custom Card Carousel Pro
 * Full style controls: layout, card, image, badge, title, description, button, arrows, dots.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class CCC_Elementor_Widget extends \Elementor\Widget_Base {

    public function get_name()       { return 'ccc_carousel'; }
    public function get_title()      { return 'Card Carousel'; }
    public function get_icon()       { return 'eicon-slider-push'; }
    public function get_categories() { return ['general']; }
    public function get_keywords()   { return ['carousel','slider','cards','swiper']; }

    /* ════════════════════════════════════════════════════════════
       CONTROLS
    ════════════════════════════════════════════════════════════ */
    protected function register_controls() {

        /* ── CONTENT: Slides ── */
        $this->start_controls_section('sec_slides', [
            'label' => '🎴 Slides',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('slides_note', [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => '<p style="margin:0;font-size:12px;color:#888;line-height:1.6;">Manage slide images, titles, descriptions and buttons on the <a href="' . admin_url('themes.php?page=card-carousel-settings') . '" target="_blank" style="color:#6c63ff;">Card Carousel Settings</a> page.</p>',
        ]);
        $this->end_controls_section();

        /* ── CONTENT: Carousel Behaviour ── */
        $this->start_controls_section('sec_behaviour', [
            'label' => '⚙️ Carousel Settings',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_responsive_control('desktop_cards', [
            'label'          => 'Cards Visible',
            'type'           => \Elementor\Controls_Manager::NUMBER,
            'default'        => 3,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'min'  => 1, 'max' => 6, 'step' => 0.5,
            'description' => 'Decimal allowed (e.g. 2.5 shows a peek of the next card)',
        ]);
        $this->add_control('autoplay', [
            'label' => 'Autoplay', 'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => 'On', 'label_off' => 'Off',
            'return_value' => 'true', 'default' => 'true',
        ]);
        $this->add_control('delay', [
            'label' => 'Autoplay Delay (ms)', 'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 4000, 'min' => 500, 'max' => 20000, 'step' => 100,
            'condition' => ['autoplay' => 'true'],
        ]);
        $this->add_control('loop', [
            'label' => 'Infinite Loop', 'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => 'On', 'label_off' => 'Off',
            'return_value' => 'true', 'default' => 'true',
        ]);
        $this->add_control('speed', [
            'label' => 'Transition Speed (ms)', 'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 550, 'min' => 100, 'max' => 3000, 'step' => 50,
        ]);
        $this->end_controls_section();

        /* ════════════════════════
           STYLE TAB
        ════════════════════════ */

        /* ── STYLE: Carousel Wrapper ── */
        $this->start_controls_section('style_wrap', [
            'label' => '📐 Carousel Spacing',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('padding_top', [
            'label' => 'Padding Top', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>120]],
            'default' => ['unit'=>'px','size'=>40],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-padding-top: {{SIZE}}{{UNIT}}'],
        ]);
        $this->add_control('padding_bottom', [
            'label' => 'Padding Bottom', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>120]],
            'default' => ['unit'=>'px','size'=>60],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-padding-bottom: {{SIZE}}{{UNIT}}'],
        ]);
        $this->end_controls_section();

        /* ── STYLE: Card ── */
        $this->start_controls_section('style_card', [
            'label' => '🃏 Card',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('card_bg', [
            'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-card-bg: {{VALUE}}'],
        ]);
        $this->add_control('card_border_color', [
            'label' => 'Border Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#e8e8f0',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-card-border: 1px solid {{VALUE}}'],
        ]);
        $this->add_control('card_border_width', [
            'label' => 'Border Width', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>6]],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-card-border: {{SIZE}}{{UNIT}} solid'],
        ]);
        $this->add_control('card_radius', [
            'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>40]],
            'default' => ['unit'=>'px','size'=>12],
            'selectors' => [
                '{{WRAPPER}} .ccc-wrap' => '--ccc-card-radius: {{SIZE}}{{UNIT}}; --ccc-img-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
            ],
        ]);
        $this->add_control('card_shadow', [
            'label' => 'Box Shadow', 'type' => \Elementor\Controls_Manager::BOX_SHADOW,
            'selectors' => ['{{WRAPPER}} .ccc-card' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}'],
        ]);
        $this->add_control('card_padding', [
            'label' => 'Inner Padding', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>60]],
            'default' => ['unit'=>'px','size'=>24],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-card-padding: {{SIZE}}{{UNIT}}'],
        ]);
        $this->end_controls_section();

        /* ── STYLE: Image ── */
        $this->start_controls_section('style_image', [
            'label' => '🖼 Image',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('img_ratio', [
            'label'       => 'Aspect Ratio',
            'type'        => \Elementor\Controls_Manager::SELECT,
            'options'     => [
                '56.25%' => '16:9 (landscape)',
                '75%'    => '4:3',
                '66.67%' => '3:2',
                '100%'   => '1:1 (square)',
                '125%'   => '4:5 (portrait)',
            ],
            'default'     => '56.25%',
            'selectors'   => ['{{WRAPPER}} .ccc-wrap' => '--ccc-img-ratio: {{VALUE}}'],
        ]);
        $this->end_controls_section();

        /* ── STYLE: Badge ── */
        $this->start_controls_section('style_badge', [
            'label' => '🏷 Badge',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('badge_bg', [
            'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a3a5c',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-badge-bg: {{VALUE}}'],
        ]);
        $this->add_control('badge_color', [
            'label' => 'Text Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-badge-color: {{VALUE}}'],
        ]);
        $this->add_control('badge_radius', [
            'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>50]],
            'default' => ['unit'=>'px','size'=>4],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-badge-radius: {{SIZE}}{{UNIT}}'],
        ]);
        $this->add_control('badge_font_size', [
            'label' => 'Font Size', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>8,'max'=>20]],
            'default' => ['unit'=>'px','size'=>11],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-badge-font-size: {{SIZE}}{{UNIT}}'],
        ]);
        $this->end_controls_section();

        /* ── STYLE: Title ── */
        $this->start_controls_section('style_title', [
            'label' => '✏️ Card Title',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'title_typo',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .ccc-title',
        ]);
        $this->add_control('title_color', [
            'label' => 'Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a1a2e',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-title-color: {{VALUE}}'],
        ]);
        $this->add_control('title_margin_bottom', [
            'label' => 'Spacing Below', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>40]],
            'default' => ['unit'=>'px','size'=>10],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-title-margin-bottom: {{SIZE}}{{UNIT}}'],
        ]);
        $this->end_controls_section();

        /* ── STYLE: Description ── */
        $this->start_controls_section('style_desc', [
            'label' => '📝 Description',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'desc_typo',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .ccc-desc',
        ]);
        $this->add_control('desc_color', [
            'label' => 'Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#555570',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-desc-color: {{VALUE}}'],
        ]);
        $this->add_control('desc_margin_bottom', [
            'label' => 'Spacing Below', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>40]],
            'default' => ['unit'=>'px','size'=>20],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-desc-margin-bottom: {{SIZE}}{{UNIT}}'],
        ]);
        $this->end_controls_section();

        /* ── STYLE: Button ── */
        $this->start_controls_section('style_btn', [
            'label' => '🔘 Button',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('btn_tabs');

        /* Normal */
        $this->start_controls_tab('btn_normal', ['label' => 'Normal']);
        $this->add_control('btn_bg', [
            'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a3a5c',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-btn-bg: {{VALUE}}'],
        ]);
        $this->add_control('btn_color', [
            'label' => 'Text Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-btn-color: {{VALUE}}'],
        ]);
        $this->add_control('btn_border_color', [
            'label' => 'Border Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a3a5c',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-btn-border: 2px solid {{VALUE}}'],
        ]);
        $this->end_controls_tab();

        /* Hover */
        $this->start_controls_tab('btn_hover', ['label' => 'Hover']);
        $this->add_control('btn_bg_hover', [
            'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#0f2440',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-btn-bg-hover: {{VALUE}}'],
        ]);
        $this->add_control('btn_color_hover', [
            'label' => 'Text Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-btn-color-hover: {{VALUE}}'],
        ]);
        $this->add_control('btn_border_color_hover', [
            'label' => 'Border Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#0f2440',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-btn-border-hover: 2px solid {{VALUE}}'],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control('btn_typo_divider', ['type' => \Elementor\Controls_Manager::DIVIDER]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'btn_typo',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .ccc-btn',
        ]);
        $this->add_control('btn_radius', [
            'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>0,'max'=>60]],
            'default' => ['unit'=>'px','size'=>6],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-btn-radius: {{SIZE}}{{UNIT}}'],
        ]);
        $this->add_control('btn_padding', [
            'label'      => 'Padding',
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'default'    => ['top'=>10,'right'=>22,'bottom'=>10,'left'=>22,'unit'=>'px','isLinked'=>false],
            'selectors'  => ['{{WRAPPER}} .ccc-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'],
        ]);
        $this->add_control('btn_full_width', [
            'label'        => 'Full Width Button',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes', 'label_off' => 'No',
            'return_value' => 'yes', 'default' => '',
            'selectors'    => ['{{WRAPPER}} .ccc-btn' => 'align-self: stretch; justify-content: center;'],
        ]);
        $this->end_controls_section();

        /* ── STYLE: Navigation Arrows ── */
        $this->start_controls_section('style_arrows', [
            'label' => '◀▶ Navigation Arrows',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('arrow_size', [
            'label' => 'Button Size', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>24,'max'=>80]],
            'default' => ['unit'=>'px','size'=>42],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-arrow-size: {{SIZE}}{{UNIT}}'],
        ]);
        $this->start_controls_tabs('arrow_tabs');
        $this->start_controls_tab('arrow_normal', ['label' => 'Normal']);
        $this->add_control('arrow_bg', [
            'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-arrow-bg: {{VALUE}}'],
        ]);
        $this->add_control('arrow_color', [
            'label' => 'Icon Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a1a2e',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-arrow-color: {{VALUE}}'],
        ]);
        $this->add_control('arrow_border_color', [
            'label' => 'Border Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#e0e0ee',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-arrow-border: 1.5px solid {{VALUE}}'],
        ]);
        $this->end_controls_tab();
        $this->start_controls_tab('arrow_hover', ['label' => 'Hover']);
        $this->add_control('arrow_bg_hover', [
            'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a3a5c',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-arrow-bg-hover: {{VALUE}}'],
        ]);
        $this->add_control('arrow_color_hover', [
            'label' => 'Icon Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-arrow-color-hover: {{VALUE}}'],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control('arrow_radius', [
            'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px','%'], 'range' => ['px' => ['min'=>0,'max'=>60], '%' => ['min'=>0,'max'=>50]],
            'default' => ['unit'=>'%','size'=>50],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-arrow-radius: {{SIZE}}{{UNIT}}'],
        ]);
        $this->end_controls_section();

        /* ── STYLE: Pagination Dots ── */
        $this->start_controls_section('style_dots', [
            'label' => '⚫ Pagination Dots',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('dot_color', [
            'label' => 'Inactive Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#d0d0e0',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-dot-color: {{VALUE}}'],
        ]);
        $this->add_control('dot_active_color', [
            'label' => 'Active Colour', 'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a3a5c',
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-dot-active-color: {{VALUE}}'],
        ]);
        $this->add_control('dot_size', [
            'label' => 'Dot Size', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>4,'max'=>20]],
            'default' => ['unit'=>'px','size'=>8],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-dot-size: {{SIZE}}{{UNIT}}'],
        ]);
        $this->add_control('dot_active_width', [
            'label' => 'Active Dot Width', 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'], 'range' => ['px' => ['min'=>8,'max'=>60]],
            'default' => ['unit'=>'px','size'=>24],
            'selectors' => ['{{WRAPPER}} .ccc-wrap' => '--ccc-dot-active-width: {{SIZE}}{{UNIT}}'],
        ]);
        $this->end_controls_section();
    }

    /* ════════════════════════════════════════════════════════════
       RENDER
    ════════════════════════════════════════════════════════════ */
    protected function render() {
        $s      = $this->get_settings_for_display();
        $slides = ccc_get_slides();

        /* Responsive cards per view */
        $desktop_cards = ! empty( $s['desktop_cards'] )        ? $s['desktop_cards']        : 3;
        $tablet_cards  = ! empty( $s['desktop_cards_tablet'] ) ? $s['desktop_cards_tablet'] : 2;
        $mobile_cards  = ! empty( $s['desktop_cards_mobile'] ) ? $s['desktop_cards_mobile'] : 1;

        $atts = [
            'autoplay'       => ( $s['autoplay'] === 'true' ) ? 'true' : 'false',
            'delay'          => absint( $s['delay'] ?? 4000 ),
            'loop'           => ( $s['loop'] === 'true' ) ? 'true' : 'false',
            'speed'          => absint( $s['speed'] ?? 550 ),
            'desktop_cards'  => $desktop_cards,
            'tablet_cards'   => $tablet_cards,
            'mobile_cards'   => $mobile_cards,
            'css_vars'       => [],
        ];

        include plugin_dir_path( dirname( __FILE__ ) ) . 'templates/carousel.php';
    }
}
