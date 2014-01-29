<?php
/*
Plugin Name: EventBrite WP
Plugin URI: 
Description: 
Version: 0.1.0
Author: Eugenio Petullà
Author URI: http://www.eugeniopetulla.com/contattami.html
License: GPL3
*/

/*
eventbrite WP (Wordpress Plugin)
Copyright (C) 2012 Eugenio Petullà
Contact me at http://www.eugeniopetulla.com/contattami.html

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

/* SHORTCODE */
/*==========*/

function eventbrite_button_shortcode( $atts ){
    extract( shortcode_atts( array(
      'id' => '',
      'align' => 'none',
      'alt' => 'Buy Ticket via eventbrite',
      ), $atts ) );
 
      return ' 
      <a href="http://www.eventbrite.com/event/' . $id . '?ref=ebtn" target="_blank">
  <img border="0" src="http://www.eventbrite.com/custombutton?eid=' . $id . '" alt="' . $alt . '" class="align' . $align . '"/>
</a>';
}
function eventbrite_ticket_shortcode( $atts ){
    extract( shortcode_atts( array(
      'id' => '',
      'height' => '256',
      ), $atts ) );
 
      return ' 
      <div style="width:100%; text-align:left;" ><iframe src="http://www.eventbrite.com/tickets-external?eid=' . $id . '&ref=etckt&v=2" frameborder="0" height="' . $height . '" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe></div>';
}
function eventbrite_calendar_shortcode( $atts ){
    extract( shortcode_atts( array(
      'id' => '',
      'height' => '515',
      'align' => 'none',
      ), $atts ) );
 
      return ' 
      <div style="width:195px; text-align:center;" class="align' . $align . '"><iframe src="http://www.eventbrite.com/calendar-widget?eid=' . $id . '" frameborder="0" height="' . $height . '" width="195" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true"></iframe></div>';
}
function eventbrite_countdown_shortcode( $atts ){
    extract( shortcode_atts( array(
      'id' => '',
      'height' => '479',
      'align' => 'none',
      ), $atts ) );
 
      return ' 
      <div style="width:195px; text-align:center;" class="align' . $align . '"><iframe src="http://www.eventbrite.com/countdown-widget?eid=' . $id . '" frameborder="0" height="' . $height . '" width="195" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true"></iframe></div>';
}
add_shortcode('event-button', 'eventbrite_button_shortcode');
add_shortcode('event-ticket', 'eventbrite_ticket_shortcode');
add_shortcode('event-calendar', 'eventbrite_calendar_shortcode');
add_shortcode('event-countdown', 'eventbrite_countdown_shortcode');

/*=== WIDGET
 *==============================*/

/**
 * Eventbrite Calendar Widget
 *
 * @since 0.1
 */
class eventbrite_calendar extends WP_Widget {
        // Constructor
        function __construct() {
                parent::__construct(
                        'eventbrite_calendar', // Base ID
                        __( 'Eventbrite Calendar', 'eventbritecalendar' ), // Name
                        array( 'description' => __( 'Show an eventbrite event calendar', 'eventbritecalendar' ) ) // Args
                );
        }

        /**
         * Front-end display of widget
         *
         * @see WP_Widget::widget()
         *
         * @param array $args. Widget arguments.
         * @param array $instance. Saved values from database.
         */
        public function widget( $args, $instance ) {
                extract( $args );

                // Widget options
                $title = apply_filters( 'widget_title', $instance['title'] );
                $id = $instance['id'];
                $height = $instance['height'];

                echo $before_widget;
                if ( ! empty( $title ) )
                        echo $before_title . $title . $after_title;

                if ( empty( $height ) )
                	$height = '515';

                // ID
                if ( ! empty( $id ) )
                        echo '<div style="width:195px; text-align:center;" class="aligncenter"><iframe src="http://www.eventbrite.com/calendar-widget?eid=' . $id . '" frameborder="0" height="' . $height . '" width="195" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true"></iframe></div>';
                else
                	echo '<span><strong>Insert an event ID</strong></span>';
                
                echo $after_widget;
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance. Previously saved values from database.
         */
        public function form( $instance ) {

                $title = esc_attr($instance['title']);          // Widget Title
                $id = esc_attr($instance['id']);                // Event ID
                $height = esc_attr($instance['height']);        // Height
                ?>

                <p>
                        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'eventbritecalendar' ); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e( 'Event ID:', 'eventbritecalendar' ); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>">
                        <br>
                        <small><?php _e( 'The numeric part of the URL', 'eventbritecalendar' ); ?></small>
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'Widget Height:', 'eventbritecalendar' ); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>">
                        <br>
                        <small><?php _e( 'Leave blank for 515', 'eventbritecalendar' ); ?></small>
                </p>

                <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance. Values just sent to be saved.
         * @param array $old_instance. Previously saved values from database.
         */
        public function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = $new_instance['title'];
                $instance['id'] = $new_instance['id'];
                $instance['height'] = $new_instance['height'];

                return $instance;
        }
}

/**
 * Register widgets
 */
add_action( 'widgets_init', create_function('', 'return register_widget( "eventbrite_calendar" );') );

/**
 * Eventbrite Countdown Widget
 *
 * @since 0.1
 */
class eventbrite_countdown extends WP_Widget {
        // Constructor
        function __construct() {
                parent::__construct(
                        'eventbrite_countdown', // Base ID
                        __( 'Eventbrite Countdown', 'eventbritecountdown' ), // Name
                        array( 'description' => __( 'Show an eventbrite event countdown', 'eventbritecountdown' ) ) // Args
                );
        }

        /**
         * Front-end display of widget
         *
         * @see WP_Widget::widget()
         *
         * @param array $args. Widget arguments.
         * @param array $instance. Saved values from database.
         */
        public function widget( $args, $instance ) {
                extract( $args );

                // Widget options
                $title = apply_filters( 'widget_title', $instance['title'] );
                $id = $instance['id'];
                $height = $instance['height'];

                echo $before_widget;
                if ( ! empty( $title ) )
                        echo $before_title . $title . $after_title;

                if ( empty( $height ) )
                	$height = '479';

                // ID
                if ( ! empty( $id ) )
                        echo '<div style="width:195px; text-align:center;" class="aligncenter"><iframe src="http://www.eventbrite.com/countdown-widget?eid=' . $id . '" frameborder="0" height="' . $height . '" width="195" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true"></iframe></div>';
                else
                	echo '<span><strong>Insert an event ID</strong></span>';
                
                echo $after_widget;
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance. Previously saved values from database.
         */
        public function form( $instance ) {

                $title = esc_attr($instance['title']);          // Widget Title
                $id = esc_attr($instance['id']);                // Event ID
                $height = esc_attr($instance['height']);        // Height
                ?>

                <p>
                        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'eventbritecountdown' ); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e( 'Event ID:', 'eventbritecountdown' ); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>">
                        <br>
                        <small><?php _e( 'The numeric part of the URL', 'eventbritecountdown' ); ?></small>
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'Widget Height:', 'eventbritecountdown' ); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>">
                        <br>
                        <small><?php _e( 'Leave blank for 479', 'eventbritecountdown' ); ?></small>
                </p>

                <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance. Values just sent to be saved.
         * @param array $old_instance. Previously saved values from database.
         */
        public function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = $new_instance['title'];
                $instance['id'] = $new_instance['id'];
                $instance['height'] = $new_instance['height'];

                return $instance;
        }
}

/**
 * Register widgets
 */
add_action( 'widgets_init', create_function('', 'return register_widget( "eventbrite_countdown" );') );
?>
