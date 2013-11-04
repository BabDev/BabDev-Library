<?php
/**
 * BabDev HTTP Package
 *
 * The BabDev HTTP package is a fork of the Joomla HTTP package as found in Joomla! CMS 3.1.1
 * and provides selected bug fixes and a single codebase for consistent use in CMS 2.5 and newer.
 *
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Http;

use Joomla\Registry\Registry;
use Joomla\Uri\Uri;

/**
 * HTTP client class.
 *
 * @since  1.0
 */
class Http
{
	/**
	 * Options for the HTTP client.
	 *
	 * @var    Registry
	 * @since  1.0
	 */
	protected $options;

	/**
	 * The HTTP transport object to use in sending HTTP requests.
	 *
	 * @var    TransportInterface
	 * @since  1.0
	 */
	protected $transport;

	/**
	 * Constructor.
	 *
	 * @param   Registry            $options    Client options object. If the registry contains any headers.* elements,
	 *                                          these will be added to the request headers.
	 * @param   TransportInterface  $transport  The HTTP transport object.
	 *
	 * @since   1.0
	 */
	public function __construct(Registry $options = null, TransportInterface $transport = null)
	{
		$this->options   = isset($options) ? $options : new Registry;
		$this->transport = isset($transport) ? $transport : HttpFactory::getAvailableDriver($this->options);
	}

	/**
	 * Get an option from the HTTP client.
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
	 * Set an option for the HTTP client.
	 *
	 * @param   string  $key    The name of the option to set.
	 * @param   mixed   $value  The option value to set.
	 *
	 * @return  Http  This object for method chaining.
	 *
	 * @since   1.0
	 */
	public function setOption($key, $value)
	{
		$this->options->set($key, $value);

		return $this;
	}

	/**
	 * Method to send the OPTIONS command to the server.
	 *
	 * @param   string   $url      Path to the resource.
	 * @param   array    $headers  An array of name-value pairs to include in the header of the request.
	 * @param   integer  $timeout  Read timeout in seconds.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 */
	public function options($url, array $headers = null, $timeout = null)
	{
		// Look for headers set in the options.
		$temp = (array) $this->options->get('headers');

		foreach ($temp as $key => $val)
		{
			if (!isset($headers[$key]))
			{
				$headers[$key] = $val;
			}
		}

		// Look for timeout set in the options.
		if ($timeout === null && $this->options->exists('timeout'))
		{
			$timeout = $this->options->get('timeout');
		}

		return $this->transport->request('OPTIONS', new Uri($url), null, $headers, $timeout, $this->options->get('userAgent', null));
	}

	/**
	 * Method to send the HEAD command to the server.
	 *
	 * @param   string   $url      Path to the resource.
	 * @param   array    $headers  An array of name-value pairs to include in the header of the request.
	 * @param   integer  $timeout  Read timeout in seconds.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 */
	public function head($url, array $headers = null, $timeout = null)
	{
		// Look for headers set in the options.
		$temp = (array) $this->options->get('headers');

		foreach ($temp as $key => $val)
		{
			if (!isset($headers[$key]))
			{
				$headers[$key] = $val;
			}
		}

		// Look for timeout set in the options.
		if ($timeout === null && $this->options->exists('timeout'))
		{
			$timeout = $this->options->get('timeout');
		}

		return $this->transport->request('HEAD', new Uri($url), null, $headers, $timeout, $this->options->get('userAgent', null));
	}

	/**
	 * Method to send the GET command to the server.
	 *
	 * @param   string   $url      Path to the resource.
	 * @param   array    $headers  An array of name-value pairs to include in the header of the request.
	 * @param   integer  $timeout  Read timeout in seconds.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 */
	public function get($url, array $headers = null, $timeout = null)
	{
		// Look for headers set in the options.
		$temp = (array) $this->options->get('headers');

		foreach ($temp as $key => $val)
		{
			if (!isset($headers[$key]))
			{
				$headers[$key] = $val;
			}
		}

		// Look for timeout set in the options.
		if ($timeout === null && $this->options->exists('timeout'))
		{
			$timeout = $this->options->get('timeout');
		}

		return $this->transport->request('GET', new Uri($url), null, $headers, $timeout, $this->options->get('userAgent', null));
	}

	/**
	 * Method to send the POST command to the server.
	 *
	 * @param   string   $url      Path to the resource.
	 * @param   mixed    $data     Either an associative array or a string to be sent with the request.
	 * @param   array    $headers  An array of name-value pairs to include in the header of the request
	 * @param   integer  $timeout  Read timeout in seconds.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 */
	public function post($url, $data, array $headers = null, $timeout = null)
	{
		// Look for headers set in the options.
		$temp = (array) $this->options->get('headers');

		foreach ($temp as $key => $val)
		{
			if (!isset($headers[$key]))
			{
				$headers[$key] = $val;
			}
		}

		// Look for timeout set in the options.
		if ($timeout === null && $this->options->exists('timeout'))
		{
			$timeout = $this->options->get('timeout');
		}

		return $this->transport->request('POST', new Uri($url), $data, $headers, $timeout, $this->options->get('userAgent', null));
	}

	/**
	 * Method to send the PUT command to the server.
	 *
	 * @param   string   $url      Path to the resource.
	 * @param   mixed    $data     Either an associative array or a string to be sent with the request.
	 * @param   array    $headers  An array of name-value pairs to include in the header of the request.
	 * @param   integer  $timeout  Read timeout in seconds.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 */
	public function put($url, $data, array $headers = null, $timeout = null)
	{
		// Look for headers set in the options.
		$temp = (array) $this->options->get('headers');

		foreach ($temp as $key => $val)
		{
			if (!isset($headers[$key]))
			{
				$headers[$key] = $val;
			}
		}

		// Look for timeout set in the options.
		if ($timeout === null && $this->options->exists('timeout'))
		{
			$timeout = $this->options->get('timeout');
		}

		return $this->transport->request('PUT', new Uri($url), $data, $headers, $timeout, $this->options->get('userAgent', null));
	}

	/**
	 * Method to send the DELETE command to the server.
	 *
	 * @param   string   $url      Path to the resource.
	 * @param   array    $headers  An array of name-value pairs to include in the header of the request.
	 * @param   integer  $timeout  Read timeout in seconds.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 */
	public function delete($url, array $headers = null, $timeout = null)
	{
		// Look for headers set in the options.
		$temp = (array) $this->options->get('headers');

		foreach ($temp as $key => $val)
		{
			if (!isset($headers[$key]))
			{
				$headers[$key] = $val;
			}
		}

		// Look for timeout set in the options.
		if ($timeout === null && $this->options->exists('timeout'))
		{
			$timeout = $this->options->get('timeout');
		}

		return $this->transport->request('DELETE', new Uri($url), null, $headers, $timeout, $this->options->get('userAgent', null));
	}

	/**
	 * Method to send the TRACE command to the server.
	 *
	 * @param   string   $url      Path to the resource.
	 * @param   array    $headers  An array of name-value pairs to include in the header of the request.
	 * @param   integer  $timeout  Read timeout in seconds.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 */
	public function trace($url, array $headers = null, $timeout = null)
	{
		// Look for headers set in the options.
		$temp = (array) $this->options->get('headers');

		foreach ($temp as $key => $val)
		{
			if (!isset($headers[$key]))
			{
				$headers[$key] = $val;
			}
		}

		// Look for timeout set in the options.
		if ($timeout === null && $this->options->exists('timeout'))
		{
			$timeout = $this->options->get('timeout');
		}

		return $this->transport->request('TRACE', new Uri($url), null, $headers, $timeout, $this->options->get('userAgent', null));
	}

	/**
	 * Method to send the PATCH command to the server.
	 *
	 * @param   string   $url      Path to the resource.
	 * @param   mixed    $data     Either an associative array or a string to be sent with the request.
	 * @param   array    $headers  An array of name-value pairs to include in the header of the request.
	 * @param   integer  $timeout  Read timeout in seconds.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 */
	public function patch($url, $data, array $headers = null, $timeout = null)
	{
		// Look for headers set in the options.
		$temp = (array) $this->options->get('headers');

		foreach ($temp as $key => $val)
		{
			if (!isset($headers[$key]))
			{
				$headers[$key] = $val;
			}
		}

		// Look for timeout set in the options.
		if ($timeout === null && $this->options->exists('timeout'))
		{
			$timeout = $this->options->get('timeout');
		}

		return $this->transport->request('PATCH', new Uri($url), $data, $headers, $timeout, $this->options->get('userAgent', null));
	}
}
