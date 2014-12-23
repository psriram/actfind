<?php
/**
 * Unit tests for HTML_QuickForm2 package
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2006, 2007, Alexey Borzov <avb@php.net>,
 *                           Bertrand Mansion <golgote@mamasam.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *    * Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *    * Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the
 *      documentation and/or other materials provided with the distribution.
 *    * The names of the authors may not be used to endorse or promote products
 *      derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     Alexey Borzov <avb@php.net>
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    CVS: $Id: FactoryTest.php,v 1.10 2007/07/04 14:58:17 avb Exp $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Factory class
 */
require_once 'HTML/QuickForm2/Factory.php';

/**
 * PHPUnit2 Test Case
 */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Element class
 */
require_once 'HTML/QuickForm2/Node.php';

/**
 * Unit test for HTML_QuickForm2_Factory class
 */
class HTML_QuickForm2_FactoryTest extends PHPUnit_Framework_TestCase
{
    public function testNotRegisteredElement()
    {
        $this->assertFalse(HTML_QuickForm2_Factory::isElementRegistered('foo_' . mt_rand()));
    }

    public function testElementTypeCaseInsensitive()
    {
        HTML_QuickForm2_Factory::registerElement('fOo', 'Classname');
        $this->assertTrue(HTML_QuickForm2_Factory::isElementRegistered('foo'));
        $this->assertTrue(HTML_QuickForm2_Factory::isElementRegistered('FOO'));
    }

    public function testCreateNotRegisteredElement()
    {
        try {
            $el = HTML_QuickForm2_Factory::createElement('foo2');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/Element type(.*)is not known/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

    public function testCreateElementNonExistingClass()
    {
        HTML_QuickForm2_Factory::registerElement('foo3', 'NonexistentClass');
        try {
            $el = HTML_QuickForm2_Factory::createElement('foo3');
        } catch (HTML_QuickForm2_NotFoundException $e) {
            $this->assertRegexp('/Class(.*)does not exist and no file to load/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
    }

    public function testCreateElementNonExistingFile()
    {
        HTML_QuickForm2_Factory::registerElement('foo4', 'NonexistentClass', 'NonexistentFile.php');
        try {
            $el = HTML_QuickForm2_Factory::createElement('foo4');
        } catch (HTML_QuickForm2_NotFoundException $e) {
            $this->assertRegexp('/File(.*)was not found/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
    }

    public function testCreateElementInvalidFile()
    {
        HTML_QuickForm2_Factory::registerElement('foo5', 'NonexistentClass', dirname(__FILE__) . '/_files/InvalidFile.php');
        try {
            $el = HTML_QuickForm2_Factory::createElement('foo5');
        } catch (HTML_QuickForm2_NotFoundException $e) {
            $this->assertRegexp('/Class(.*)was not found within file(.*)/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
    }

    public function testCreateElementValid()
    {
        HTML_QuickForm2_Factory::registerElement('fakeelement', 'FakeElement', dirname(__FILE__) . '/_files/FakeElement.php');
        $el = HTML_QuickForm2_Factory::createElement('fakeelement',
                'fake', 'attributes', array('options' => '', 'label' => 'fake label'));
        $this->assertType('FakeElement', $el);
        $this->assertEquals('fake', $el->name);
        $this->assertEquals(array('options' => '', 'label' => 'fake label'), $el->data);
        $this->assertEquals('attributes', $el->attributes);
    }

    public function testNotRegisteredRule()
    {
        $this->assertFalse(HTML_QuickForm2_Factory::isRuleRegistered('foo_' . mt_rand()));
    }

    public function testRuleNameCaseInsensitive()
    {
        HTML_QuickForm2_Factory::registerRule('fOo', 'RuleClassname');
        $this->assertTrue(HTML_QuickForm2_Factory::isRuleRegistered('FOO'));
        $this->assertTrue(HTML_QuickForm2_Factory::isRuleRegistered('foo'));
    }

    public function testGetRuleConfig()
    {
        HTML_QuickForm2_Factory::registerRule('foobar', 'FooBar', null, 'Some config');
        $this->assertEquals('Some config', HTML_QuickForm2_Factory::getRuleConfig('foobar'));

        try {
            $config = HTML_QuickForm2_Factory::getRuleConfig('foobar_' . mt_rand());
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/Rule(.*)is not known/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

    public function testCreateNotRegisteredRule()
    {
        $mockNode = $this->getMock(
            'HTML_QuickForm2_Node', array('updateValue', 'getId', 'getName',
            'getType', 'getValue', 'setId', 'setName', 'setValue', '__toString')
        );
        try {
            $rule = HTML_QuickForm2_Factory::createRule('foo2', $mockNode);
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/Rule(.*)is not known/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

    public function testCreateRuleNonExistingClass()
    {
        $mockNode = $this->getMock(
            'HTML_QuickForm2_Node', array('updateValue', 'getId', 'getName',
            'getType', 'getValue', 'setId', 'setName', 'setValue', '__toString')
        );
        HTML_QuickForm2_Factory::registerRule('foo3', 'NonexistentClass');
        try {
            $rule = HTML_QuickForm2_Factory::createRule('foo3', $mockNode);
        } catch (HTML_QuickForm2_NotFoundException $e) {
            $this->assertRegexp('/Class(.*)does not exist and no file to load/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
    }

    public function testCreateRuleNonExistingFile()
    {
        $mockNode = $this->getMock(
            'HTML_QuickForm2_Node', array('updateValue', 'getId', 'getName',
            'getType', 'getValue', 'setId', 'setName', 'setValue', '__toString')
        );
        HTML_QuickForm2_Factory::registerRule('foo4', 'NonexistentClass', 'NonexistentFile.php');
        try {
            $rule = HTML_QuickForm2_Factory::createRule('foo4', $mockNode);
        } catch (HTML_QuickForm2_NotFoundException $e) {
            $this->assertRegexp('/File(.*)was not found/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
    }

    public function testCreateRuleInvalidFile()
    {
        $mockNode = $this->getMock(
            'HTML_QuickForm2_Node', array('updateValue', 'getId', 'getName',
            'getType', 'getValue', 'setId', 'setName', 'setValue', '__toString')
        );
        HTML_QuickForm2_Factory::registerRule('foo5', 'NonexistentClass', dirname(__FILE__) . '/_files/InvalidFile.php');
        try {
            $rule = HTML_QuickForm2_Factory::createRule('foo5', $mockNode);
        } catch (HTML_QuickForm2_NotFoundException $e) {
            $this->assertRegexp('/Class(.*)was not found within file(.*)/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
    }

    public function testCreateRuleValid()
    {
        $mockNode = $this->getMock(
            'HTML_QuickForm2_Node', array('updateValue', 'getId', 'getName',
            'getType', 'getValue', 'setId', 'setName', 'setValue', '__toString')
        );
        HTML_QuickForm2_Factory::registerRule(
            'fakerule', 'FakeRule', dirname(__FILE__) . '/_files/FakeRule.php'
        );
        $rule = HTML_QuickForm2_Factory::createRule(
            'fakerule', $mockNode, 'An error message', 'Some options'
        );
        $this->assertType('FakeRule', $rule);
        $this->assertSame($mockNode, $rule->owner);
        $this->assertEquals('An error message', $rule->getMessage());
        $this->assertEquals('Some options', $rule->getOptions());
        $this->assertEquals('fakerule', $rule->registeredType);
    }
}
?>