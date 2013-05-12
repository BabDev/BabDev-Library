<?php
/**
 * @package     BabDev.UnitTest
 * @subpackage  Version
 *
 * @copyright   Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for BDVersion.
 *
 * @package     BabDev.UnitTest
 * @subpackage  Version
 * @since       1.0
 */
class BDVersionTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Compatibility test cases
	 *
	 * @return  array
	 *
	 * @since   1.0
	 */
	public function casesCompatibility()
	{
		return array(
			'Version 0.3' => array(
				'0.3',
				false,
				'Should not be compatible with 0.3',
			),
			'Empty' => array(
				'',
				false,
				'Should not be compatible with empty string',
			),
			'Null' => array(
				null,
				false,
				'Should not be compatible with null',
			),
			'Self' => array(
				BDVersion::MAJOR . '.' . BDVersion::MINOR . '.' . BDVersion::MAINTENANCE,
				true,
				'Should be compatible with itself',
			),
			'Version 12.1.0' => array(
				'12.1.0',
				false,
				'Should not be compatible with a future version',
			)
		);

	}

	/**
	 * Tests the isCompatible method.
	 *
	 * @param   string   $input    Version to check
	 * @param   boolean  $expect   Expected result of version check
	 * @param   string   $message  Test failure message
	 *
	 * @return  void
	 *
	 * @dataProvider  casesCompatibility
	 * @since         1.0
	 */
	public function testIsCompatible($input, $expect, $message)
	{
		$this->assertThat(
			$expect,
			$this->equalTo(BDVersion::isCompatible($input)),
			$message
		);
	}
}
