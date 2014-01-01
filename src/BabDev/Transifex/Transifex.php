<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex;

use BabDev\Http\HttpFactory;

use Joomla\Registry\Registry;

/**
 * Base class for interacting with the Transifex API.
 *
 * @property-read  Formats             $formats             Transifex API object for interacting with the Format API.
 * @property-read  LanguageInfo        $languageinfo        Transifex API object for interacting with the Language Info API.
 * @property-read  Languages           $languages           Transifex API object for interacting with the Language API.
 * @property-read  Projects            $projects            Transifex API object for interacting with the Project API.
 * @property-read  Releases            $releases            Transifex API object for interacting with the Release API.
 * @property-read  Resources           $resources           Transifex API object for interacting with the Resource API.
 * @property-read  Statistics          $statistics          Transifex API object for interacting with the Statistics API.
 * @property-read  Translations        $translations        Transifex API object for interacting with the Translations API.
 * @property-read  Translationstrings  $translationstrings  Transifex API object for interacting with the Translation Strings API.
 *
 * @since  1.0
 */
class Transifex
{
	/**
	 * Options for the Transifex object.
	 *
	 * @var    Registry
	 * @since  1.0
	 */
	protected $options;

	/**
	 * The HTTP client object to use in sending HTTP requests.
	 *
	 * @var    Http
	 * @since  1.0
	 */
	protected $client;

	/**
	 * Transifex API object for interacting with the Format API.
	 *
	 * @var    Formats
	 * @since  1.0
	 */
	protected $formats;

	/**
	 * Transifex API object for interacting with the Language Info API.
	 *
	 * @var    LanguageInfo
	 * @since  1.0
	 */
	protected $languageinfo;

	/**
	 * Transifex API object for interacting with the Language API.
	 *
	 * @var    Languages
	 * @since  1.0
	 */
	protected $languages;

	/**
	 * Transifex API object for interacting with the Project API.
	 *
	 * @var    Projects
	 * @since  1.0
	 */
	protected $projects;

	/**
	 * Transifex API object for interacting with the Release API.
	 *
	 * @var    Releases
	 * @since  1.0
	 */
	protected $releases;

	/**
	 * Transifex API object for interacting with the Resource API.
	 *
	 * @var    Resources
	 * @since  1.0
	 */
	protected $resources;

	/**
	 * Transifex API object for interacting with the Statistics API.
	 *
	 * @var    Statistics
	 * @since  1.0
	 */
	protected $statistics;

	/**
	 * Transifex API object for interacting with the Translations API.
	 *
	 * @var    Translations
	 * @since  1.0
	 */
	protected $translations;

	/**
	 * Transifex API object for interacting with the Translation Strings API.
	 *
	 * @var    Translationstrings
	 * @since  1.0
	 */
	protected $translationstrings;

	/**
	 * Constructor.
	 *
	 * @param   Registry  $options  Transifex options object.
	 * @param   Http      $client   The HTTP client object.
	 *
	 * @since   1.0
	 */
	public function __construct(Registry $options = null, Http $client = null)
	{
		$this->options = isset($options) ? $options : new Registry;

		// Set the authentication type if not already set.
		$this->options->def('api.authentication', 'HTTP');

		// Set the transport object for the HTTP object
		$transport = HttpFactory::getAvailableDriver($this->options, array('curl'));

		$this->client = isset($client) ? $client : new Http($this->options, $transport);

		// Setup the default API url if not already set.
		$this->options->def('api.url', 'https://www.transifex.com/api/2');
	}

	/**
	 * Magic method to lazily create API objects
	 *
	 * @param   string  $name  Name of property to retrieve.
	 *
	 * @return  TransifexObject  Transifex API object.
	 *
	 * @since   1.0
	 * @throws  \InvalidArgumentException
	 */
	public function __get($name)
	{
		$class = __NAMESPACE__ . '\\' . ucfirst(strtolower($name));

		if (class_exists($class))
		{
			if (isset($this->$name) == false)
			{
				$this->$name = new $class($this->options, $this->client);
			}

			return $this->$name;
		}

		throw new \InvalidArgumentException(sprintf('Argument %s produced an invalid class name: %s', $name, $class));
	}

	/**
	 * Get an option from the Transifex instance.
	 *
	 * @param   string  $key  The name of the option to get.
	 *
	 * @return  mixed  The option value.
	 *
	 * @since   1.0
	 */
	public function getOption($key)
	{
		return $this->options->get($key);
	}

	/**
	 * Set an option for the Transifex instance.
	 *
	 * @param   string  $key    The name of the option to set.
	 * @param   mixed   $value  The option value to set.
	 *
	 * @return  Transifex  This object for method chaining.
	 *
	 * @since   1.0
	 */
	public function setOption($key, $value)
	{
		$this->options->set($key, $value);

		return $this;
	}
}
