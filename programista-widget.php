<?php
/*
Plugin Name: Widget Magazynu "Programista"
Plugin URI: http://programistamag.pl/
Description: Widget wyświetlający okładkę najnowszego wydania magazynu "Programista"
Version: 1.1
Author: michak&ml
Author URI: http://programistamag.pl/
License: Public domain
*/

class Programista_Widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct('programista_widget', __('Programista - okładka', 'text_domain'),
            array('description' => __('Okładka aktualnego "Programisty"', 'text_domain'),));
    }

    private function widget_content($instance)
    {
        $from_param = urlencode(base64_encode(get_site_url())); // do celów statystycznych
        $redirect_link = '//programista-widget.lunahost.pl/api.php?v=1.1&action=redirect-latest&partner_url=' . $from_param;
        $img_src_link  = '//programista-widget.lunahost.pl/api.php?v=1.1&action=latest-cover&partner_url=' . $from_param;
        $content = '<a href="' . $img_src_link . '" rel="nofollow">';
        $content .= '<img width="' . $instance['scale'] . '" height="' . $instance['scale'] . '" src="' . $img_src_link . '">';
        $content .= '</a>';
        return $content;
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] .
                apply_filters('widget_title', $instance['title']) .
                $args['after_title'];
        }

        echo __($this->widget_content($instance), 'text_domain');
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : __('Polecamy magazyn Programista', 'text_domain');
        $scale = !empty($instance['scale']) ? $instance['scale'] : __('100%', 'text_domain');
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tytuł widgetu:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">

            <label
                for="<?php echo $this->get_field_id('scale'); ?>"><?php _e('Skalowanie (wartość % lub piksele):'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('scale'); ?>"
                   name="<?php echo $this->get_field_name('scale'); ?>" type="text"
                   value="<?php echo esc_attr($scale); ?>">
        </p>
    <?php
    }
}

function register_programista_widget()
{
    register_widget('Programista_Widget');
}

add_action('widgets_init', 'register_programista_widget');

