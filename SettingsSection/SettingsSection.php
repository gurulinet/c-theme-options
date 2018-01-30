<?php

namespace SettingsSection;


class SettingsSection
{
	const SETTINGS_OPTION = 'chronous-settings-section';
	private static $instance;
	
	public static $htmlOut = array();
	protected $message;
	
	public $settings = array(
		'wpautop' => false,
		'media_buttons' => false,
		'textarea_name' => 'jigoshop_chronous_ccm_text',
		'textarea_rows' => 20,
		'tabindex' => null,
		'editor_css' => '',
		'editor_class' => 'jigoshop_chronous_ccm_text',
		'teeny' => 0,
		'dfw' => 0,
		'tinymce' => 1,
		'quicktags' => 1,
		'drag_drop_upload' => false
	);
	protected static $allowedHtml = [
		'a' => [
			'id' => [],
			'href' => [],
			'title' => [],
			'style' => [],
			'class' => [],
		],
		'b' => [
			'id' => [],
			'class' => [],
		],
		'br' => [],
		'em' => [
			'id' => [],
			'class' => []
		],
		'blockquote' => [
			'id' => [],
			'class' => [],
		],
		'i' => [
			'id' => [],
			'class' => [],
		],
		'ins' => [],
		'img' => [
			'title' => [],
			'src' => [],
			'class' => [],
			'id' => [],
		],
		'ol' => [
			'class' => [],
			'id' => [],
		],
		'ul' => [
			'class' => [],
			'id' => [],
		],
		'li' => [
			'class' => [],
			'id' => [],
		],
		'strong' => [
			'id' => [],
			'class' => [],
		],
	];
	
	public static function allowedHtmlOutput()
	{
		return array_merge(self::$htmlOut, self::$allowedHtml);
	}
	
	/**
	 * @return SettingsSection
	 */
	public static function section()
	{
		if(null == self::$instance){
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	/**
	 * @param $section
	 */
	public static function addSettings($section)
	{
		switch($section)
		{
			case 'section' :
				self::section()->add();
			break;
			default :
				add_settings_error('error', 'ChronousErrorHscMessage', 'Could not save the request!', 'error');
				settings_errors('error');
			break;
		}
		
	}
	
	public function add()
	{
		if (false == get_option(self::SETTINGS_OPTION)) {
			add_option(self::SETTINGS_OPTION);
		}
		add_settings_section(
			'jchsc_settings',
			'Header Shopping Cart Settings',
			[$this,'jchscSettingsTitle'],
			self::SETTINGS_OPTION
		);
		
		add_settings_field(
			'enable-hsc',
			'Enable Header Shopping Cart',
			[$this,'hscMainSettings'],
			self::SETTINGS_OPTION,
			'jchsc_settings',
			[
				'value' => 'jigoshop_chronous_hsc_enable'
			]
		);
		
		add_settings_field(
			'display-hsc-cart-icon',
			'Display Cart Icon',
			[$this,'hscMainSettings'],
			self::SETTINGS_OPTION,
			'jchsc_settings',
			[
				'value' => 'jigoshop_chronous_hsc_icon_display'
			]
		);
		
		add_settings_field(
			'display-cart-even-empty',
			'Display Cart even if it\'s empty',
			[$this,'hscMainSettings'],
			self::SETTINGS_OPTION,
			'jchsc_settings',
			[
				'value' => 'jigoshop_chronous_hsc_display_empty'
			]
		);
		
		add_settings_field(
			'select-menu',
			'Select Menu',
			[$this,'hscMainSettings'],
			self::SETTINGS_OPTION ,
			'jchsc_settings',
			[
				'value' => 'jigoshop_chronous_hsc_select_menu'
			]
		);
		
		add_settings_field(
			'text-on-cart',
			'Text On Cart',
			[$this,'hscMainSettings'],
			self::SETTINGS_OPTION,
			'jchsc_settings',
			[
				'value' => 'jigoshop_chronous_hsc_text'
			]
		);
		
		add_settings_field(
			'choose-icon',
			'Choose Cart Icon',
			[$this,'hscMainSettings'],
			self::SETTINGS_OPTION,
			'jchsc_settings',
			[
				'iconOptions' => 'jigoshop_chronous_hsc_icon',
				'id' => 'cart-icon',
				'options' => [
					'0' => '0',
					'1' => '1',
					'2' => '2',
					'3' => '3',
				]
			]
		);
		
		// Custom Checkout
		add_settings_section(
			'ccm_settings',
			'Custom Checkout Message',
			[$this,'ccmSettingsTitle'],
			self::SETTINGS_OPTION
		);
		
		add_settings_field(
			'enable-ccm',
			'Enable',
			[$this,'ccmMainSettings'],
			self::SETTINGS_OPTION,
			'ccm_settings',
			[
				'value' => 'jigoshop_chronous_ccm_enable'
			]
		);
		add_settings_field(
			'ccm-text',
			'Custom Message On Checkout',
			[$this,'ccmMainSettings'],
			self::SETTINGS_OPTION,
			'ccm_settings',
			[
				'value' => 'jigoshop_chronous_ccm_text'
			]
		);
		
		// Disable checkout button
		add_settings_section(
			'dc_settings',
			'Checkout Button',
			[$this,'dcSettingsTitle'],
			self::SETTINGS_OPTION
		);
		add_settings_field(
			'dc-enable',
			'Enable/Disable Checkout Button',
			[$this,'dcMainSettings'],
			self::SETTINGS_OPTION,
			'dc_settings',
			[
				'value' => 'jigoshop_chronous_dc_enable'
			]
		);
	}
	
	public function jchscSettingsTitle()
	{
		echo '<p>' . esc_html('Header Shopping Cart') . '</p>';
	}
	
	public function ccmSettingsTitle()
	{
		echo '<p>' . esc_html('Custom Checkout Message') . '</p>';
	}
	public function dcSettingsTitle()
	{
		echo '<p>' . esc_html('Checkout Button') . '</p>';
	}
	
	/**
	 * @param $arg
	 */
	public function hscMainSettings($arg)
	{
		$html = '';
		if (!empty($arg['value'])) {
			switch ($arg['value']) {
				case 'jigoshop_chronous_hsc_enable' :
					$enable = get_option($arg['value']);
					if ($enable == 'on') {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					$html .= '<input type="checkbox" class="switch-medium" id="' . esc_attr($arg['value']) . '" name="' . esc_attr($arg['value']) . '" ' . $checked . ' />';
					break;
				case 'jigoshop_chronous_hsc_icon_display' :
					$cartIcon = get_option($arg['value']);
					if ($cartIcon == 'on') {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					$html .= '<input type="checkbox" class="switch-medium" id="' . esc_attr($arg['value']) . '" name="' . esc_attr($arg['value']) . '" ' . $checked . ' />';
					break;
				case 'jigoshop_chronous_hsc_display_empty' :
					$emptyCartDisplay = get_option($arg['value']);
					if ($emptyCartDisplay == 'on') {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					$html .= '<input type="checkbox" class="switch-medium" id="' . esc_attr($arg['value']) . '" name="' . esc_attr($arg['value']) . '" ' . $checked . ' />';
					break;
				case 'jigoshop_chronous_hsc_select_menu' :
					$menus = $this->selectMenu();
					$selected = get_option($arg['value']);
					$html .= '<select id="' . esc_attr($arg['value']) . '" name="' . esc_attr($arg['value']) . '">';
					if (!empty($menus)) {
						foreach ($menus as $key => $value) {
							$html .= '<option value="' . esc_attr($key) . '" ' . selected($selected, $key, false) . '>' . esc_attr($value) . '</option>';
						}
					}
					$html .= '</select>';
					break;
				case 'jigoshop_chronous_hsc_text' :
					$cartText = get_option($arg['value']);
					$html .= '<input type="text" class="" size="35" id="' . esc_attr($arg['value']) . '" name="' . esc_attr($arg['value']) . '" value="' . esc_attr($cartText) . '" />';
					break;
				default :
					echo '';
					break;
				
			}
		}
		if (!empty($arg['iconOptions'])) {
			$icons = $this->cartIcon($this->icons());
			$iconsInCart = $arg['iconOptions'];
			$option = get_option($iconsInCart);
			$id = $arg['id'];
			$current = '';
			
			if (isset($option[$id])) {
				$current = $option[$id];
			}
			$img = null;
			$checked = false;
			if (!empty($icons)) {
				foreach ($arg['options'] as $key => $numValue) {
					$html .= '<img src="' . CHRONOUS_HSC_URI . '/images/cartIcons/cartIcon' . $numValue . '.png' . '"  id="' . __('jchsc_') . $numValue . '" />';
					$html .= '<input type="radio" name="' . esc_attr($iconsInCart . "[{$id}]") . '" id="' . esc_attr($iconsInCart . "[{$id}]" . "[{$key}]") . '" value="' . esc_attr($key) . '" ' . checked($current, $key, false) . ' />';
				}
				add_option('chronousHscOptions');
				foreach ($icons as $compareNum => $icon) {
					if ($current == $compareNum) {
						$img = $icon;
						$checked = true;
					}
				}
				$cartIconArg = [];
				if(true == $checked){
					$cartIconArg['ID'] = $current;
					$cartIconArg['imgUrl'] = esc_url($img);
				}
				
				$commonArgs = [
					'enable' => get_option('jigoshop_chronous_hsc_enable'),
					'displayCartIcon' => get_option('jigoshop_chronous_hsc_icon_display'),
					'displayCartEvenEmpty' => get_option('jigoshop_chronous_hsc_display_empty'),
					'selectMenu' => get_option('jigoshop_chronous_hsc_select_menu'),
					'textOnCart' => get_option('jigoshop_chronous_hsc_text'),
				];
				
				$args = array_merge($cartIconArg, $commonArgs);
				
				update_option('chronousHscOptions', $args);
				
			}
		}
		
		echo $html;
	}
	
	/**
	 * @param $arg
	 */
	public function ccmMainSettings($arg)
	{
		$html = '';
		if (!empty($arg['value'])) {
			switch ($arg['value']) {
				case 'jigoshop_chronous_ccm_enable' :
					$enable = get_option($arg['value']);
					if ($enable == 'on') {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					$html .= '<input type="checkbox" class="switch-medium" id="' . esc_attr($arg['value']) . '" name="' . esc_attr($arg['value']) . '" ' . $checked . ' />';
					break;
				case 'jigoshop_chronous_ccm_text' :
					$this->message = empty(get_option('jigoshop_chronous_ccm_text')) ? '' : get_option('jigoshop_chronous_ccm_text');
					$this->message = str_replace('\\', '', $this->message);
					$html .= wp_editor(wp_kses($this->message, self::allowedHtmlOutput()), 'custom_checkout_box_message', $this->settings);
				break;
				default :
					$html .= '';
			}
		}
		
		echo $html;
	}
	
	/**
	 * @param $arg
	 */
	public function dcMainSettings($arg)
	{
		$html = '';
		if (!empty($arg['value'])) {
			switch ($arg['value']) {
				case 'jigoshop_chronous_dc_enable' :
					$enable = get_option($arg['value']);
					if ($enable == 'on') {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					$html .= '<input type="checkbox" class="switch-medium" id="' . esc_attr($arg['value']) . '" name="' . esc_attr($arg['value']) . '" ' . $checked . ' />';
					break;
				default :
					$html .= '';
			}
		}
		
		echo $html;
	}
	
	public function selectMenu()
	{
		$adminMenus = get_terms(
			'nav_menu',
			[
				'hide_empty' => false,
			]
		);
		
		$menus = [];
		if (!empty($adminMenus)) {
			foreach ($adminMenus as $navMenu) {
				$menus[$navMenu->slug] = $navMenu->name;
			}
		}
		
		return $menus;
	}
	
	public function cartIcon($cartIcons)
	{
		$icons = array();
		
		if (is_array($cartIcons)) {
			foreach ($cartIcons as $key => $icon) {
				$icons[] = CHRONOUS_HSC_URI . '/images/cartIcons/' . $icon . '.png';
			}
		}
		
		return $icons;
	}
	
	public function icons()
	{
		return [
			// Keys should be 0,1,2,3 but whatever, I like this
			'1' => 'cartIcon0',
			'2' => 'cartIcon1',
			'3' => 'cartIcon2',
			'4' => 'cartIcon3',
		];
	}
}