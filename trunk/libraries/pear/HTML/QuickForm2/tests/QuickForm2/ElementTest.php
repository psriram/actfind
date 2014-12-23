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
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    CVS: $Id: ElementTest.php,v 1.12 2007/06/30 20:36:01 avb Exp $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Element class
 */
require_once 'HTML/QuickForm2/Element.php';

/**
 * PHPUnit2 Test Case
 */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/**
 * A non-abstract subclass of Element 
 *
 * Element class is still abstract, we should "implement" the remaining methods.
 * Note the default implementation of setValue() / getValue(), needed to test
 * setting the value from Data Source
 */
class HTML_QuickForm2_ElementImpl extends HTML_QuickForm2_Element
{
    protected $value;

    public function getType() { return 'concrete'; }
    public function __toString() { return ''; }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}

/**
 * Unit test for HTML_QuickForm2_Element class, 
 */
class HTML_QuickForm2_ElementTest extends PHPUnit_Framework_TestCase
{
    protected $post;
    protected $request;

    public function setUp()
    {
        $this->post = $_POST;
        $this->request = $_REQUEST;

        $_REQUEST = array(
            '_qf__form1' => ''
        );

        $_POST = array(
            'foo' => 'a value',
            'fooReborn' => 'another value'
        );
    }

    public function tearDown()
    {
        $_POST = $this->post;
        $_REQUEST = $this->request;
    }

    public function testCanSetName()
    {
        $obj = new HTML_QuickForm2_ElementImpl();
        $this->assertNotNull($obj->getName(), 'Elements should always have \'name\' attribute');

        $obj = new HTML_QuickForm2_ElementImpl('foo');
        $this->assertEquals('foo', $obj->getName());

        $this->assertSame($obj, $obj->setName('bar'));
        $this->assertEquals('bar', $obj->getName());

        $obj->setAttribute('name', 'baz');
        $this->assertEquals('baz', $obj->getName());
    }


    public function testCanSetId()
    {
        $obj = new HTML_QuickForm2_ElementImpl(null, array('id' => 'manual'));
        $this->assertEquals('manual', $obj->getId());

        $this->assertSame($obj, $obj->setId('another'));
        $this->assertEquals('another', $obj->getId());

        $obj->setAttribute('id', 'yet-another');
        $this->assertEquals('yet-another', $obj->getId());
    }


    public function testCanNotRemoveNameOrId()
    {
        $obj = new HTML_QuickForm2_ElementImpl('somename', array(), array('id' => 'someid'));
        try {
            $obj->removeAttribute('name');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegExp('/Required attribute(.*)can not be removed/', $e->getMessage());
            try {
                $obj->removeAttribute('id');
            } catch (HTML_QuickForm2_InvalidArgumentException $e) {
                $this->assertRegExp('/Required attribute(.*)can not be removed/', $e->getMessage());
                return;
            }
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }


    public function testUniqueIdsGenerated()
    {
        $names = array(
            '', 'value', 'array[]', 'array[8]', 'array[60000]', 'array[20]',
            'array[name][]', 'bigger[name][5]', 'bigger[name][]', 'bigger[name][6]'
        );
        $usedIds = array();
        foreach ($names as $name) {
            $el = new HTML_QuickForm2_ElementImpl($name);
            $this->assertNotEquals('', $el->getId(), 'Should have an auto-generated \'id\' attribute');
            $this->assertNotContains($el->getId(), $usedIds);
            $usedIds[] = $el->getId();
            // Duplicate name...
            $el2 = new HTML_QuickForm2_ElementImpl($name);
            $this->assertNotContains($el2->getId(), $usedIds);
            $usedIds[] = $el2->getId();
        }
    }


    public function testManualIdsNotReused()
    {
        $usedIds = array(
            'foo-0', 'foo-2', 'foo-bar-0', 'foo-bar-2', 'foo-baz-0-0'
        );
        $names = array(
            'foo', 'foo[bar]', 'foo[baz][]'
        );
        foreach ($usedIds as $id) {
            $elManual = new HTML_QuickForm2_ElementImpl('foo', array('id' => $id));
        }
        foreach ($names as $name) {
            $el = new HTML_QuickForm2_ElementImpl($name);
            $this->assertNotContains($el->getId(), $usedIds);
            $usedIds[] = $el->getId();
            // Duplicate name...
            $el2 = new HTML_QuickForm2_ElementImpl($name);
            $this->assertNotContains($el2->getId(), $usedIds);
            $usedIds[] = $el2->getId();
        }
    }

    public function testSetValueFromSubmitDatasource()
    {
        $form = new HTML_QuickForm2('form1');
        $elFoo = $form->appendChild(new HTML_QuickForm2_ElementImpl('foo'));
        $elBar = $form->appendChild(new HTML_QuickForm2_ElementImpl('bar'));

        $this->assertEquals('a value', $elFoo->getValue());
        $this->assertNull($elBar->getValue());
    }

    public function testDataSourcePriority()
    {
        $form = new HTML_QuickForm2('form1');
        $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'foo' => 'new value',
            'bar' => 'default value'
        )));
        $elFoo = $form->appendChild(new HTML_QuickForm2_ElementImpl('foo'));
        $elBar = $form->appendChild(new HTML_QuickForm2_ElementImpl('bar'));

        $this->assertEquals('a value', $elFoo->getValue());
        $this->assertEquals('default value', $elBar->getValue());
    }

    public function testUpdateValueFromNewDataSource()
    {
        $form = new HTML_QuickForm2('form2');
        $el = $form->appendChild(new HTML_QuickForm2_ElementImpl('foo'));
        $this->assertNull($el->getValue());

        $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'foo' => 'updated value'
        )));
        $this->assertEquals('updated value', $el->getValue());
    }

    public function testUpdateValueOnNameChange()
    {
        $form = new HTML_QuickForm2('form1');
        $elFoo = $form->appendChild(new HTML_QuickForm2_ElementImpl('foo'));
        $elFoo->setName('fooReborn');
        $this->assertEquals('another value', $elFoo->getValue());
    }
}
?>
