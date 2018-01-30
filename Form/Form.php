<?php

namespace Form;


use SettingsSection\SettingsSection;

class Form
{
	const PLUGIN_NAME = 'Jigoshop Header Shopping Cart';
	const PLUGIN = 'jigoshop-header-shopping-cart/bootstrap.php';
	
	private function __construct()
	{
		add_action('init', [$this,'checkIfHscIsInstall']);
	}
	
	private function __clone()
	{
	}
	
	/**
	 *
	 */
	function checkIfHscIsInstall()
	{
		if(is_plugin_active(self::PLUGIN)){
			echo '<div class="error"><p>' . __('It seems you have active the plugin '
					. self::PLUGIN_NAME . '. Please <a href="' . esc_url($this->deactivatePlugin(self::PLUGIN, 'deactivate')) . '">disable</a> it before using this option', '') .'</p></div>';
			
			exit();
		}
	}
	
	/**
	 * @thanks https://nazmulahsan.me/generate-activation-deactivation-link-wordpress-plugin/
	 */
	private function deactivatePlugin($plugin, $action = 'activate') {
		if (strpos( $plugin, '/')){
			$plugin = str_replace( '\/', '%2F', $plugin);
		}
		$url = sprintf(admin_url('plugins.php?action=' . $action . '&plugin=%s&plugin_status=all&paged=1&s'), $plugin);
		$_REQUEST['plugin'] = $plugin;
		$url = wp_nonce_url($url, $action . '-plugin_' . $plugin);
		
		return $url;
	}
	
	/**
	 * @param $form
	 * @return Form|string
	 */
	public static function add($form)
	{
		switch ($form) {
			case 'form' :
				if (!is_admin()) {
					wp_die('Ops. It seems you are not allowed to be here');
				}
				return new self();
				break;
			default :
				return 'Settings form has not be found';
			break;
		}
	}
	
	public function form()
	{
		if(!current_user_can('manage_options')){
			wp_die('Sorry you are not allowed to edit this page');
		}
		if(!is_admin()){
			wp_die('Ops. You are not in appropriate page sparky!');
		}
		
		if(isset($_GET['settings-updated'])){
			add_settings_error('jigoshopChronousHscMessage', 'ChronousHscMessage', 'Settings have been saved', 'updated');
		}
		$this->checkIfHscIsInstall();
		
		settings_errors('jigoshopChronousHscMessage');
		
		echo '<div class="wrap">';
		echo '<h1>'. esc_html('Chronous Options') . '</h1>';
		echo '<form action="options.php" method="post">';
		wp_nonce_field(
			'update-options'
		);
		
		do_settings_sections(SettingsSection::SETTINGS_OPTION);
		settings_fields(SettingsSection::SETTINGS_OPTION);
		
		submit_button('Save Changes');
		
		echo '</form>';
		echo '</div>';
	}
}