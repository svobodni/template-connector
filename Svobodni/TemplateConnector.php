<?php

namespace Svobodni;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class TemplateConnector
{

	const DEFAULT_TEMPLATE = 'http://web.svobodni.cz/external';

	/** @var string */
	private $template;

	/** @var string */
	private $cacheDir;

	/** @var string|NULL */
	private $_data;

	/** @var array */
	private $parameters = array();

	/** @var string */
	private $templateHelpersClass = 'Svobodni\TemplateHelpers';


	/**
	 * @param $templateHelpersClass
	 * @throws \Exception
	 */
	public function setTemplateHelpersClass($templateHelpersClass)
	{
		if (!class_exists($templateHelpersClass)) {
			throw new \Exception("Class '$templateHelpersClass' does not exist");
		}

		if (!is_a($templateHelpersClass, 'Svobodni\TemplateHelpers', TRUE)) {
			throw new \Exception("Class '$templateHelpersClass' must extends from Svobodni\\TemplateHelpers");
		}

		$this->templateHelpersClass = $templateHelpersClass;
	}


	/**
	 * @return string
	 */
	public function getTemplateHelpersClass()
	{
		return $this->templateHelpersClass;
	}


	/**
	 * @param $cacheDir
	 * @return $this
	 * @throws
	 */
	public function setCacheDir($cacheDir)
	{
		if (!is_dir($cacheDir)) {
			throw new \Exception("Path '$cacheDir' is not directory");
		}

		if (!is_writable($cacheDir)) {
			throw new \Exception("Directory '$cacheDir' is not writable");
		}

		$this->cacheDir = $cacheDir;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getCacheDir()
	{
		return $this->cacheDir;
	}


	/**
	 * @param $template
	 * @return $this
	 */
	public function setTemplate($template)
	{
		$this->template = $template;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getTemplate()
	{
		return $this->template ? : static::DEFAULT_TEMPLATE;
	}


	/**
	 * @param $key
	 * @param $value
	 * @return $this
	 */
	public function setParameter($key, $value)
	{
		$this->parameters[$key] = $value;
		return $this;
	}


	/**
	 * @param $parameters
	 * @return $this
	 */
	public function setParameters($parameters)
	{
		foreach ($parameters as $key => $value) {
			$this->setParameter($key, $value);
		}

		return $this;
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		$class = $this->templateHelpersClass;

		$data = $this->getData();
		$data = $class::replaceBlocks($data, $this->parameters);

		$data = str_replace('src="/', 'src="http://web.svobodni.cz/', $data);
		$data = str_replace('href="/', 'href="http://web.svobodni.cz/', $data);

		return $class::replaceBlock($data);
	}


	public function render()
	{
		echo $this->__toString();
	}


	/**
	 * @return string
	 */
	private function getData()
	{
		if ($this->_data) {
			return $this->_data;
		}

		if ($this->cacheDir && file_exists($this->getTemplateFileName())){
			return $this->_data = file_get_contents($this->getTemplateFileName());
		}

		$this->_data = $this->downloadTemplate();

		if ($this->cacheDir) {
			file_put_contents($this->getTemplateFileName(), $this->_data);
		}

		return $this->_data;
	}


	/**
	 * @return string
	 */
	public function downloadTemplate()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getTemplate());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}


	/**
	 * @return string
	 */
	private function getTemplateFileName()
	{
		return $this->cacheDir . '/_template.index.html';
	}

}
