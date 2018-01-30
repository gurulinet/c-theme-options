<?php

namespace RegisterSettings;


use SettingsSection\SettingsSection;

class RegisterSettings
{
	private static $instance;
	
	public static function settings()
	{
		if (null == self::$instance) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	/**
	 * @param $settings
	 */
	public static function register($settings)
	{
		switch ($settings) {
			case 'settings' :
				self::settings()->add();
				break;
			default :
				add_settings_error('error', 'ChronousErrorHscMessage', 'Could not save the request!', 'error');
				settings_errors('error');
				break;
		}
	}
	
	public function add()
	{
		// Jigoshop Chronous Header Shopping Cart -> jchsc
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_hsc_enable'
		);
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_hsc_icon_display'
		);
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_hsc_display_empty'
		);
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_hsc_select_menu'
		);
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_hsc_text'
		);
		
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_hsc_icon'
		);
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_ccm_enable'
		);
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_ccm_text'
		);
		register_setting(
			SettingsSection::SETTINGS_OPTION,
			'jigoshop_chronous_dc_enable'
		);
	}
}