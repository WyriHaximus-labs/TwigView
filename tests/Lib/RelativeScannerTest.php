<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Lib;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\TestSuite\TestCase;
use WyriHaximus\TwigView\Lib\RelativeScanner;

/**
 * Class RelativeScannerTest
 * @package WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig
 */
class RelativeScannerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Configure::write(
            'App',
            [
                'paths' => [
                    'templates' => [
                        PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS,
                    ],
                ]
            ]
        );
        Plugin::load(
            'TestTwigView',
            [
                'path' => PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS,
            ]
        );
        Plugin::load(
            'TestTwigViewEmpty',
            [
                'path' => PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigViewEmpty' . DS,
            ]
        );
    }

    public function tearDown()
    {
        Plugin::unload('TestTwigView');

        parent::tearDown();
    }

    public function testAll()
    {
        $this->assertSame([
            'APP' => [
                'layout.tpl',
            ],
            'TestTwigView' => [
                'Controller/Component/magic.tpl',
                'Controller/index.tpl',
                'Controller/view.tpl',
                'twig.tpl',
            ],
        ], RelativeScanner::all());
    }

    public function testPlugin()
    {
        $this->assertSame([
            'Controller/Component/magic.tpl',
            'Controller/index.tpl',
            'Controller/view.tpl',
            'twig.tpl',
        ], RelativeScanner::plugin('TestTwigView'));
    }
}
