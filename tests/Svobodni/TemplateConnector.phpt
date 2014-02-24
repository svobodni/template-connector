<?php

use Tester\TestCase;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class TemplateConnectorTest extends TestCase
{

	/** @var \Svobodni\WebsiteConnector */
	private $connector;

	public function setUp()
	{
		$this->connector = new \Svobodni\TemplateConnector;
	}


	public function testSetCache()
	{
		$connector = $this->connector;

		Assert::exception(function() use ($connector) {
			$connector->setCacheDir(__DIR__ . '/foo');
		}, 'Exception', "Path '".__DIR__ . "/foo' is not directory");
		mkdir(__DIR__ . '/foo');
		chmod(__DIR__ . '/foo', 0000);
		Assert::exception(function() use ($connector) {
			$connector->setCacheDir(__DIR__ . '/foo');
		}, 'Exception', "Directory '".__DIR__ . "/foo' is not writable");
	}


	public function testDownload()
	{
		Assert::true(is_string($this->connector->downloadTemplate()));
	}


	public function testToString()
	{
		$this->connector->setTemplateHelpersClass('TemplateHelpers');
		$this->connector
			->setParameter('a', 'foo')
			->setParameter('b', 'bar');

		$this->connector->__toString();

		Assert::equal(array(
			array('foo', 'a'),
			array('bar', 'b'),
			array(NULL, NULL),
		), TemplateHelpers::$calls);
	}


	protected function tearDown()
	{
		@chmod(__DIR__ . '/foo', 0777);
		@rmdir(__DIR__ . '/foo');
	}

}


class TemplateHelpers extends \Svobodni\TemplateHelpers
{

	public static $calls = array();

	public static function replaceBlock($data, $value = NULL, $block = NULL)
	{
		self::$calls[] = array($value, $block);
	}

}

$testCase = new TemplateConnectorTest;
$testCase->run();
