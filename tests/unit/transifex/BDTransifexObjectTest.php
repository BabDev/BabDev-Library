<?php
/**
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

require_once __DIR__ . '/stubs/BDTransifexObjectMock.php';

/**
 * Test class for BDTransifex.
 *
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexObjectTest extends PHPUnit_Framework_TestCase
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
	 * @var    BDTransifexObjectMock  Object being tested
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

		$this->object = new BDTransifexObjectMock($this->options, $this->client);
	}

	/**
	 * Tests the fetchUrl method with basic authentication data
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testFetchUrlBasicAuth()
	{
		$this->options->set('api.url', 'http://www.transifex.com/api/2');

		$this->options->set('api.username', 'MyTestUser');
		$this->options->set('api.password', 'MyTestPass');

		$this->assertThat(
			$this->object->fetchUrl('/formats'),
			$this->equalTo('http://www.transifex.com/api/2/formats')
		);
	}
}
