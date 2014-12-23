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
 * @version    CVS: $Id: NodeTest.php,v 1.7 2007/07/05 18:27:16 avb Exp $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Element class
 */
require_once 'HTML/QuickForm2/Node.php';

/**
 * PHPUnit2 Test Case
 */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Base class for HTML_QuickForm2 rules
 */
require_once 'HTML/QuickForm2/Rule.php';

/**
 * A non-abstract subclass of Node
 *
 * We can't instantiate the class directly and thus need to "implement" its
 * abstract methods. And also make validate() public to be able to test.
 */
class HTML_QuickForm2_NodeImpl extends HTML_QuickForm2_Node
{
    public function getType() { return 'concrete'; }
    public function getValue() { return ''; }
    public function setValue($value) { return ''; }
    public function __toString() { return ''; }

    public function getName() { return ''; }
    public function setName($name) { }
    public function getId() { return ''; }
    public function setId($id = null) { }

    protected function updateValue() { }

    public function validate() { return parent::validate(); }
}

/**
 * Unit test for HTML_QuickForm2_Node class, 
 */
class HTML_QuickForm2_NodeTest extends PHPUnit_Framework_TestCase
{
    public function testCanSetLabel()
    {
        $obj = new HTML_QuickForm2_NodeImpl();
        $this->assertNull($obj->getLabel());

        $obj2 = new HTML_QuickForm2_NodeImpl(null, null, array('label' => 'a label'));
        $this->assertEquals('a label', $obj2->getLabel());

        $this->assertSame($obj2, $obj2->setLabel('another label'));
        $this->assertEquals('another label', $obj2->getLabel());
    }

    public function testCanFreezeAndUnfreeze()
    {
        $obj = new HTML_QuickForm2_NodeImpl();
        $this->assertFalse($obj->toggleFrozen(), 'Elements should NOT be frozen by default');

        $oldFrozen = $obj->toggleFrozen(true);
        $this->assertFalse($oldFrozen, 'toggleFrozen() should return previous frozen status');
        $this->assertTrue($obj->toggleFrozen());
        
        $this->assertTrue($obj->toggleFrozen(false), 'toggleFrozen() should return previous frozen status');
        $this->assertFalse($obj->toggleFrozen());
    }

    public function testCanSetPersistentFreeze()
    {
        $obj = new HTML_QuickForm2_NodeImpl();
        $this->assertFalse($obj->persistentFreeze(), 'Frozen element\'s data should NOT persist by default');

        $oldPersistent = $obj->persistentFreeze(true);
        $this->assertFalse($oldPersistent, 'persistentFreeze() should return previous persistence status');
        $this->assertTrue($obj->persistentFreeze());
        
        $this->assertTrue($obj->persistentFreeze(false), 'persistentFreeze() should return previous persistence status');
        $this->assertFalse($obj->persistentFreeze());
    }

    public function testCanSetAndGetError()
    {
        $obj = new HTML_QuickForm2_NodeImpl();
        $this->assertEquals('', $obj->getError(), 'Elements shouldn\'t have a error message by default');

        $this->assertSame($obj, $obj->setError('An error message'));
        $this->assertEquals('An error message', $obj->getError());
    }

    public function testValidate()
    {
        $valid = new HTML_QuickForm2_NodeImpl();
        $ruleTrue = $this->getMock(
            'HTML_QuickForm2_Rule', array('checkValue'),
            array($valid, 'A message')
        );
        $ruleTrue->expects($this->once())->method('checkValue')
                 ->will($this->returnValue(true));
        $valid->addRule($ruleTrue);
        $this->assertTrue($valid->validate());
        $this->assertEquals('', $valid->getError());

        $invalid = new HTML_QuickForm2_NodeImpl();
        $ruleFalse = $this->getMock(
            'HTML_QuickForm2_Rule', array('checkValue'),
            array($invalid, 'An error message')
        );
        $ruleFalse->expects($this->once())->method('checkValue')
                  ->will($this->returnValue(false));
        $invalid->addRule($ruleFalse);
        $this->assertFalse($invalid->validate());
        $this->assertEquals('An error message', $invalid->getError());
    }

    public function testValidateUntilErrorMessage()
    {
        $preError = new HTML_QuickForm2_NodeImpl();
        $preError->setError('some message');
        $ruleIrrelevant = $this->getMock(
            'HTML_QuickForm2_Rule', array('validate', 'checkValue'),
            array($preError)
        );
        $ruleIrrelevant->expects($this->never())->method('validate');
        $preError->addRule($ruleIrrelevant);
        $this->assertFalse($preError->validate());

        $manyRules = new HTML_QuickForm2_NodeImpl();
        $ruleTrue = $this->getMock(
            'HTML_QuickForm2_Rule', array('checkValue'),
            array($manyRules, 'irrelevant message')
        );
        $ruleTrue->expects($this->once())->method('checkValue')
                 ->will($this->returnValue(true));
        $ruleFalseNoMessage = $this->getMock(
            'HTML_QuickForm2_Rule', array('checkValue'),
            array($manyRules, '')
        );
        $ruleFalseNoMessage->expects($this->once())->method('checkValue')
                           ->will($this->returnValue(false));
        $ruleFalseWithMessage = $this->getMock(
            'HTML_QuickForm2_Rule', array('checkValue'),
            array($manyRules, 'some error')
        );
        $ruleFalseWithMessage->expects($this->once())->method('checkValue')
                           ->will($this->returnValue(false));
        $ruleStillIrrelevant = $this->getMock(
            'HTML_QuickForm2_Rule', array('checkValue'),
            array($manyRules, '...')
        );
        $ruleStillIrrelevant->expects($this->never())->method('checkValue');
        $manyRules->addRule($ruleTrue);
        $manyRules->addRule($ruleFalseNoMessage);
        $manyRules->addRule($ruleFalseWithMessage);
        $manyRules->addRule($ruleStillIrrelevant);
        $this->assertFalse($manyRules->validate());
        $this->assertEquals('some error', $manyRules->getError());
    }

    public function testElementIsNotRequiredByDefault()
    {
        $node = new HTML_QuickForm2_NodeImpl();
        $this->assertFalse($node->isRequired());
    }
}
?>
