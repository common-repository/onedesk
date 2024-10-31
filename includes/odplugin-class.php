<?php
/**
 * Adds odplugin widget.
 */ 


class OD_Plugin_Widget extends WP_Widget {
	public $options;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$this->options = get_option( 'od_option_name' );
		parent::__construct(
			'odplugin_widget', // Base ID
			esc_html__( 'OneDesk Widget', 'od' ), // Name
			array( 'description' => esc_html__( 'Widget to access OneDesk', 'od_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget']; //whatever you want to display before widget (<div>, etc)
		

		echo '<script type="text/javascript" src="https://app.onedesk.com/odWidget/assets/js/od-com-widget.js" 
		org-name="'.$this->options['org_name'].'" url="https://app.onedesk.com/odWidget"
		origin="'.$this->options['origin'].'" x="'.$this->options['x_pos'].'" 
		y="'.$this->options['y_pos'].'" open-color="'.$this->options['open_color'].'" 
		close-color="'.$this->options['close_color'].'" ></script>';
        
        //Widget content output
		echo $args['after_widget'];//whatever you want to display before widget (</div>, etc)
	}

      
		
		

	
} // class OD_Plugin_Widget