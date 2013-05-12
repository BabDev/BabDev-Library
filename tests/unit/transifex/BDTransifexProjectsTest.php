<?php
/**
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for BDTransifexProjects.
 *
 * @package     BabDev.UnitTest
 * @subpackage  Transifex
 * @since       1.0
 */
class BDTransifexProjectsTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var    JRegistry  Options for the GitHub object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    BDTransifexHttp  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    BDTransifexProjects  Object under test.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  1.0
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  1.0
	 */
	protected $errorString = '{"message": "Generic Error"}';

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

		$this->object = new BDTransifexProjects($this->options, $this->client);
	}

	/**
	 * Tests the deleteProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testDeleteProject()
	{
		$returnData = new stdClass;
		$returnData->code = 204;
		$returnData->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla-platform')
			->will($this->returnValue($returnData));

		$this->assertThat(
			$this->object->deleteProject('joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the deleteProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  DomainException
	 * @since              1.0
	 */
	public function testDeleteProjectFailure()
	{
		$returnData = new stdClass;
		$returnData->code = 500;
		$returnData->body = $this->errorString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla-platform')
			->will($this->returnValue($returnData));

		$this->object->deleteProject('joomla-platform');
	}

	/**
	 * Tests the getProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetProject()
	{
		$returnData = new stdClass;
		$returnData->code = 200;
		$returnData->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/?details')
			->will($this->returnValue($returnData));

		$this->assertThat(
			$this->object->getProject('joomla-platform', true),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  DomainException
	 * @since              1.0
	 */
	public function testGetProjectFailure()
	{
		$returnData = new stdClass;
		$returnData->code = 500;
		$returnData->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/?details')
			->will($this->returnValue($returnData));

		$this->object->getProject('joomla-platform', true);
	}

	/**
	 * Tests the getProjects method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetProjects()
	{
		$returnData = new stdClass;
		$returnData->code = 200;
		$returnData->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/projects')
			->will($this->returnValue($returnData));

		$this->assertThat(
			$this->object->getProjects(),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getProjects method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  DomainException
	 * @since              1.0
	 */
	public function testGetProjectsFailure()
	{
		$returnData = new stdClass;
		$returnData->code = 500;
		$returnData->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/projects')
			->will($this->returnValue($returnData));

		$this->object->getProjects();
	}
}
