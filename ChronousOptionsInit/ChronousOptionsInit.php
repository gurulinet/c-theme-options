<?php

namespace ChronousOptionsInit;

use Form\Form;
use RegisterSettings\RegisterSettings;
use SettingsSection\SettingsSection;

if (!defined('CHRONOUS_HSC_URI')) {
	define('CHRONOUS_HSC_URI', get_template_directory_uri());
}
if (!defined('CHRONOUS_HSC_DIRECTORY')) {
	define('CHRONOUS_HSC_DIRECTORY', get_template_directory());
}

/**
 * @param Nerwy
 * @return Bardzo mi denerwuje ze do stalej nie moge przepisac directory w PHP 7 !!!!!!
 */
class ChronousOptionsInit
{
	public function __construct()
	{
		add_action('admin_menu', [$this,'chronousThemeHscOptions']);
		add_action('admin_init', [$this,'initJigoshopHscSettings']);
	}
	
	public function chronousThemeHscOptions()
	{
		add_menu_page('Hsc-Options',
			'Chronous Options', 'manage_options',
			'hsc-settings', [$this, 'chronousHscOptions'],
			CHRONOUS_HSC_URI . '/images/cart.png', 20
		);
	}
	
	public function chronousHscOptions()
	{
		Form::add('form')->form();
	}
	
	public function initJigoshopHscSettings()
	{
		SettingsSection::addSettings('section');
		RegisterSettings::register('settings');
	}
}

new ChronousOptionsInit();