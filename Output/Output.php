<?php

namespace Output;


use Jigoshop\Exception;

class Output
{
	public static function locateTemplate($template)
	{
		$file = CHRONOUS_HSC_DIRECTORY . '/ChronousOptions/template/' . $template . '.php';
		
		if(empty($file)){
			throw new Exception(sprintf(__('File '.$template.' does not exists' , '')));
		}
		return $file;
	}
	
	public static function output($template, array $environment)
	{
		$file = self::locateTemplate($template);
		extract($environment);
		/** @noinspection PhpIncludeInspection */
		require($file);
	}
	
	/**
	 * @param $template
	 * @param array $environment
	 * @return string
	 */
	public static function get($template, array $environment)
	{
		ob_start();
		
		self::output($template, $environment);
	
		return ob_get_clean();
	}
}