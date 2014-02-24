<?php

namespace Svobodni;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class TemplateHelpers
{

	/**
	 * @param string $data
	 * @param string|null $value
	 * @param string|null $block
	 * @return string
	 */
	public static function replaceBlock($data, $value = NULL, $block = NULL)
	{
		return preg_replace('/<%[\s]*' . ($block ? : '[a-zA-Z0-9]+') . '.begin[\s]*%>((.|\n|\s)*)<%[\s]*' . ($block ? : '[a-zA-Z0-9]+') . '.end[\s]*%>/iU', $value !== NULL ? (string)$value : '$1', $data);
	}


	/**
	 * @param string $data
	 * @param array $values
	 * @return string
	 */
	public static function replaceBlocks($data, array $values)
	{
		foreach ($values as $block => $value) {
			$data = static::replaceBlock($data, $value, $block);
		}

		return $data;
	}

}
