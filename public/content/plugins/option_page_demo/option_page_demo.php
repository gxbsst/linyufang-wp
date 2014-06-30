<?php
/*
Plugin Name: Option_page_demo
Version: 0.1-alpha
Description: PLUGIN DESCRIPTION HERE
Author: YOUR NAME HERE
Author URI: YOUR SITE HERE
Plugin URI: PLUGIN SITE HERE
Text Domain: option_page_demo
Domain Path: /languages
*/

/**
* 
*/
class OptionDemo
{
	public $options;
	function __construct()
	{	
		// delete_option( 'options_demo' ); // 不然会报错
		$this->options = get_option('options_demo');
		$this->register_settings_and_fields();
	}

	public function add_menu_page() {
		add_options_page( "网站设置", "网站设置", "administrator", __FILE__, array('OptionDemo', 'display_options_page'));
	}

	public function display_options_page ($value='')
	{
		?>
		<div class="wrap">
			<?php screen_icon( ); ?>
			<h2>网站建设</h2>
			<form action="options.php" method="post" enctype="multipart/form-data">
				<?php settings_fields( 'options_demo' ) ?>
				<?php do_settings_sections( __FILE__ ) ?>
				<p class="submit">
					<input type="submit" class="button-primary" type="submit" value="save change" />
				</p>
			</form>
		</div>
		<?php 
	}

	public function register_settings_and_fields()
	{
		register_setting( 'options_demo', 'options_demo', array($this,'options_demo_validate_settings'));
		// get_option('options_demo');
		// 这个定义section， 可能有几个section，分段
		add_settings_section( 'options_demo_section', '第1段', array($this, 'options_demo_section_cb'), __FILE__ );
		// add_settings_section( 'options_demo_section', '第2段', array($this, 'options_demo_section_cb'), __FILE__ );
		add_settings_field( 'jw_banner_heading', 'Banner Heading', array ($this, 'jw_banner_heading_setting'), __FILe__, 'options_demo_section' );
		add_settings_field( 'jw_logo', '标志logo', array ($this, 'jw_logo_setting'), __FILe__, 'options_demo_section' );
		add_settings_field( 'jw_color_schema', '颜色', array ($this, 'jw_color_schema_setting'), __FILe__, 'options_demo_section' );
	}

	public function jw_banner_heading_setting($value='')
	{
		echo "<input type='text' name='options_demo[jw_banner_heading_setting]' value={$this->options['jw_banner_heading_setting']}  >";
	}

	// upload loaog
	public function jw_logo_setting($value='')
	{
		echo '<input type="file" name="jw_logo_upload" />';
		if (isset($this->options['jw_logo'])) {
			echo "<img src={$this->options['jw_logo']} />";
		}
	}

	public function jw_color_schema_setting()
	{
		// var_dump($this->options);
		$items = array("red", "blue");

		echo "<select name=options_demo['jw_color_schema']>";
		foreach ($items as $item) {
			if ('blue' == $item) {
				$selected =  'selected';
			} else {
				$selected =  '';
			}
			
			echo "<option value='$item' $selected> $item </option>";
		}
		echo "</select>";

	}

	public function options_demo_section_cb($value='')
	{
		
	}

	public function options_demo_validate_settings($plugin_options)
	{
		if (!empty($_FILES["jw_logo_upload"]['tmp_name'])) {
			$override = array('test_form' => false);
			$file = wp_handle_upload( $_FILES['jw_logo_upload'], $override );
			$plugin_options['jw_logo'] = $file['url'];
		}else{
			$plugin_options['jw_logo'] = $this->options['jw_logo'];
		}
		return $plugin_options;
	}
}

add_action('admin_menu', function(){
	OptionDemo::add_menu_page();
});

add_action( 'admin_init', function(){
	new OptionDemo();
} );
 


