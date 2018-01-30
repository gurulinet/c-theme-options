<?php


namespace Frontend;


use Jigoshop\Frontend\Pages;
use SettingsSection\SettingsSection;

class Message
{
	protected $options;
	protected $output;
	
	public function __construct()
	{
		$this->initMessage();
	}
	
	
	protected function initMessage()
	{
		if(get_option('jigoshop_chronous_ccm_enable') == 'on'){
			add_action('jigoshop\template\checkout\before', array($this, 'message'));
		}
	}
	
	
	public function message()
	{
		$this->output = get_option('jigoshop_chronous_ccm_text');
		$this->output = str_replace('\\', '', $this->output);
		if(Pages::isCheckout()){
			echo '<div class="custom_message"><p>' . wp_kses($this->output, SettingsSection::allowedHtmlOutput()) . '</p></div>';
		}
	}
}

new Message();