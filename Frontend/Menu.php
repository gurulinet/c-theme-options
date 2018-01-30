<?php

namespace Menu;

use Jigoshop\Helper\Product;
use Output\Output;

class Menu
{
	private $options;
	
	/**
	 * Menu constructor.
	 */
	public function __construct()
	{
		$this->options = get_option('chronousHscOptions');
		if (!empty($this->options)) {
			$this->options = json_decode(json_encode((object)$this->options), false);
		}
		
		add_action('init', [$this, 'initMenu'], 999);
	}
	
	public function initMenu()
	{
		$menu = $this->options->selectMenu;
		
		if (!empty($menu)) {
			add_filter('wp_nav_menu_' . $menu . '_items', [$this, 'getMenu'], 10, 2);
		}
	}
	
	/**
	 * @return array
	 */
	private function displayHscContent()
	{
		return [
			'cartUrl' => get_permalink(\Jigoshop\Integration::getOptions()->getPageId('cart')),
			'cartContent' => count(\Jigoshop\Integration::getCart()->getItems()),
			'cartTotal' => Product::formatPrice(\Jigoshop\Integration::getCartService()->getCurrent()->getProductSubtotal()),
			'total' => Product::formatPrice(\Jigoshop\Integration::getCartService()->getCurrent()->getTotal()),
		];
	}
	
	/**
	 * @param $items
	 * @return string
	 */
	public function getMenu($items)
	{
		$liItems = $this->renderHscMenu();
		
		
		$menu = '';
		if (null !== $liItems) {
			$menu .= $items . $liItems;
		} else {
			$menu .= $items;
		}
		
		return $menu;
	}
	
	/**
	 * @return null|string
	 */
	public function renderHscMenu()
	{
		$hsc = $this->displayHscContent();
		$item = null;
		$productSubtotal = 0;
		$total = 0;
		$text = '';
		$cartUrl = '';
		$enable = false;
		$showEmpty = false;
		$displayCartIcon = false;
		$result = $this->options;
		$value = false;
		$iconUrl = '';
		
		if (isset($result->imgUrl)) {
			$iconUrl = $result->imgUrl;
		}
		if (isset($hsc['cartUrl'])) {
			$cartUrl = $hsc['cartUrl'];
		}
		if ($result->enable == 'on') {
			$enable = true;
		}
		if ($result->displayCartEvenEmpty == 'on') {
			$showEmpty = true;
		}
		if ($result->displayCartIcon == 'on') {
			$displayCartIcon = true;
		}
		
		if (isset($hsc['cartContent'])) {
			$itemsTotal = $hsc['cartContent'];
		} else {
			$itemsTotal = 0;
		}
		if (isset($hsc['cartTotal'])) {
			if ($hsc['cartTotal'] == 'Free') {
				$productSubtotal = Product::formatPrice($productSubtotal);
			} else {
				$productSubtotal = $hsc['cartTotal'];
			}
		} else {
			$productSubtotal = Product::formatPrice($productSubtotal);
		}
		if (isset($hsc['total'])) {
			$total = $hsc['total'];
		} else {
			$total = Product::formatPrice($total);
		}
		
		if (!empty($result->textOnCart)) {
			$text = $result->textOnCart;
		}
		
		$item = Output::get('items', [
			'enable' => $enable,
			'showEmpty' => $showEmpty,
			'displayCartIcon' => $displayCartIcon,
			'cartUrl' => $cartUrl,
			'itemsTotal' => $itemsTotal,
			'productSubtotal' => $productSubtotal,
			'text' => $text,
			'iconUrl' => $iconUrl,
			'value' => $value,
			'result' => $result,
			'total' => $total,
		]);
		
		return $item;
	}
}

new Menu();