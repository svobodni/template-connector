<?php

use Tester\TestCase;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class TemplateHelpersTest extends TestCase
{

	public function testReplaceBlock()
	{
		Assert::same('dog', \Svobodni\TemplateHelpers::replaceBlock('<% a.begin %>cat<% a.end %>', 'dog' ,'a'));
		Assert::same('cat', \Svobodni\TemplateHelpers::replaceBlock('<% a.begin %>cat<% a.end %>', NULL ,'a'));
		Assert::same('', \Svobodni\TemplateHelpers::replaceBlock('<% a.begin %>cat<% a.end %>', '' ,'a'));
		Assert::same('dog', \Svobodni\TemplateHelpers::replaceBlock('<% a.begin %>cat<% a.end %>', 'dog'));
		Assert::same('dog dog', \Svobodni\TemplateHelpers::replaceBlock('<% a.begin %>cat<% a.end %> <% b.begin %>fly<% b.end %>', 'dog'));
		Assert::same('cat fly', \Svobodni\TemplateHelpers::replaceBlock('<% a.begin %>cat<% a.end %> <% b.begin %>fly<% b.end %>'));
	}

}

$testCase = new TemplateHelpersTest;
$testCase->run();
