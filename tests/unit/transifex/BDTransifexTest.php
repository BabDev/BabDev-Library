<?php
/**
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 *
 * @copyright   Copyright (C) 2012 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for BDTransifex.
 * Generated by PHPUnit on 2012-05-05 at 03:09:29.
 *
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var    JRegistry  Options for the Transifex object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    BDTransifexHttp  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    BDTransifex  Object being tested
	 * @since  1.0
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		$this->options = new JRegistry;
		$this->client = $this->getMock('BDTransifexHttp', array('get', 'post', 'delete', 'put'));

		$this->object = new BDTransifex($this->options, $this->client);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function tearDown()
	{
	}

	/**
	 * Tests the magic __get method - Non-existing object
	 *
	 * @return  void
	 *
	 * @covers  BDTransifex::__get
	 * @since   1.0
	 */
	public function test__GetFake()
	{
		$this->assertThat(
			$this->object->fake,
			$this->isNull()
		);
	}

	/**
	 * Tests the magic __get method - Formats object
	 *
	 * @return  void
	 *
	 * @covers  BDTransifex::__get
	 * @since   1.0
	 */
	public function test__GetFormats()
	{
		$this->assertThat(
			$this->object->formats,
			$this->isInstanceOf('BDTransifexFormats')
		);
	}

	/**
	 * Tests the magic __get method - Statistics object
	 *
	 * @return  void
	 *
	 * @covers  BDTransifex::__get
	 * @since   1.0
	 */
	public function test__GetStatistics()
	{
		$this->assertThat(
			$this->object->statistics,
			$this->isInstanceOf('BDTransifexStatistics')
		);
	}

	/**
	 * Tests the setOption method
	 *
	 * @return  void
	 *
	 * @covers  BDTransifex::setOption
	 * @since   1.0
	 */
	public function testSetOption()
	{
		$this->object->setOption('api.url', 'https://example.com/settest');

		$this->assertThat(
			$this->options->get('api.url'),
			$this->equalTo('https://example.com/settest')
		);
	}

	/**
	 * Tests the getOption method
	 *
	 * @return  void
	 *
	 * @covers  BDTransifex::getOption
	 * @since   1.0
	 */
	public function testGetOption()
	{
		$this->options->set('api.url', 'https://example.com/gettest');

		$this->assertThat(
			$this->object->getOption('api.url', 'https://example.com/gettest'),
			$this->equalTo('https://example.com/gettest')
		);
	}
}
