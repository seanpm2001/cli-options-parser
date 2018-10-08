<?php

/*
  +------------------------------------------------------------------------+
  | Phalcon Cli option parser                                              |
  +------------------------------------------------------------------------+
  | Copyright (c) 2011-present Phalcon Team (https://www.phalconphp.com)   |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Authors: Sergii Svyrydenko <sergey.v.sviridenko@gmail.com>             |
  +------------------------------------------------------------------------+
*/

namespace Phalcon\Cop\Tests\Unit;

use Phalcon\Cop\Parser;
use PHPUnit\Framework\TestCase;

/**
 * Phalcon\Cop\Tests\Unit\ParserTest
 *
 * @package Phalcon\Cop\Tests\Unit
 */
class ParserTest extends TestCase
{
    /** @var Parser */
    protected $parser;

    /**
     * @before
     */
    protected function initParserObject()
    {
        $this->parser = new Parser();
    }

    /**
     * Tests Parser::parse
     *
     * @test
     * @issue  -
     * @author Sergii Svyrydenko <sergey.v.sviridenko@gmail.com>
     * @since  2018-03-29
     *
     * @dataProvider parseProvider
     */
    public function shouldParseCliCommand($params, $expect)
    {
        $this->assertEquals($expect, $this->parser->parse($params['command']));
    }

    /**
     * Tests Parser::parse with empty parameters
     *
     * @test
     * @issue  -
     * @author Nikolaos Dimopoulos <nikos@phalconphp.com>
     * @since  2018-10-08
     */
    public function shouldParseCliCommandWithNoParameters()
    {
        $oldParams = $_SERVER['argv'] ?? [];
        unset($_SERVER['argv']);

        $this->assertEquals([], $this->parser->parse());

        $_SERVER['argv'] = $oldParams;
    }

    /**
     * Tests Parser::parse with empty parameters but server parameters
     *
     * @test
     * @issue  -
     * @author Nikolaos Dimopoulos <nikos@phalconphp.com>
     * @since  2018-10-08
     */
    public function shouldParseCliCommandWithNoParametersAndServerParameters()
    {
        $oldParams = $_SERVER['argv'] ?? [];
        $_SERVER['argv'] = [
            '/usr/bin/phalcon',
            '--az',
            'value1',
        ];

        $this->assertEquals(['az' => 'value1'], $this->parser->parse());

        $_SERVER['argv'] = $oldParams;
    }

    /**
     * Tests Parser::getBoolean
     *
     * @test
     * @issue  -
     * @author Sergii Svyrydenko <sergey.v.sviridenko@gmail.com>
     * @since  2018-03-29
     *
     * @dataProvider booleanProvider
     */
    public function shouldTransformParamToBool($params, $expect)
    {
        $this->parser->parse($params['argv']);

        $this->assertEquals($expect, $this->parser->getBoolean($params['key'], $params['default']));
    }

    /**
     * Provider for test shouldParseCliCommand
     */
    public function parseProvider()
    {
        return include PATH_FIXTURES . 'command_parser_test/parse_parameters.php';
    }

    /**
     * Provider for test shouldTransformeParamToBool
     */
    public function booleanProvider()
    {
        return include PATH_FIXTURES . 'command_parser_test/boolean_parameters.php';
    }
}
