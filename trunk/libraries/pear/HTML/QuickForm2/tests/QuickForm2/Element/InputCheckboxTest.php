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
 * @version    CVS: $Id: InputCheckboxTest.php,v 1.4 2007/04/16 19:24:26 avb Exp $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Class for <input type="checkbox" /> elements
 */
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';

/**
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/**
 * PHPUnit2 Test Case
 */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Unit test for HTML_QuickForm2_Element_InputCheckbox class
 */
class HTML_QuickForm2_Element_InputCheckboxTest extends PHPUnit_Framework_TestCase
{
    protected $post;
    protected $get;

    public function setUp()
    {
        $this->post = $_POST;
        $this->get  = $_GET;

        $_POST = array(
            'box1' => '1'
        );
        $_GET = array();
    }

    public function tearDown()
    {
        $_POST = $this->post;
        $_GET  = $this->get;
    }

    public function testDefaultValueAttributeIs1()
    {
        $box = new HTML_QuickForm2_Element_InputCheckbox();
        $this->assertEquals('1', $box->getAttribute('value'));
    }

    public function testCheckboxUncheckedOnSubmit()
    {
        $formPost = new HTML_QuickForm2('boxed', 'post', null, false);
        $box1 = $formPost->appendChild(new HTML_QuickForm2_Element_InputCheckbox('box1'));
        $box2 = $formPost->appendChild(new HTML_QuickForm2_Element_InputCheckbox('box2'));
        $this->assertEquals('1', $box1->getValue());
        $this->assertNull($box2->getValue());

        $formPost->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'box2' => '1'
        )));
        $this->assertEquals('1', $box1->getValue());
        $this->assertNull($box2->getValue());

        $formGet = new HTML_QuickForm2('boxed2', 'get', null, false);
        $box3 = $formGet->appendChild(new HTML_QuickForm2_Element_InputCheckbox('box3'));
        $this->assertNull($box3->getValue());

        $formGet->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'box3' => '1'
        )));
        $this->assertEquals('1', $box3->getValue());
    }
}
?>
