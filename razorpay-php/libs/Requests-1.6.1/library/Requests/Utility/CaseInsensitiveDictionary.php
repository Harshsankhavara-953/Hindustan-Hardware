<?php
/**
 * Case-insensitive dictionary, suitable for HTTP headers
 *
 * @package Requests
 * @subpackage Utilities
 */

/**
 * Case-insensitive dictionary, suitable for HTTP headers
 *
 * @package Requests
 * @subpackage Utilities
 */
class Requests_Utility_CaseInsensitiveDictionary implements ArrayAccess, IteratorAggregate {

	/**
	 * Actual item data
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Check if the given item exists
	 *
	 * @param string $key Item key
	 * @return boolean Does the item exist?
	 */
	public function offsetExists($key) :bool
	{
		$key = strtolower($key);
		return isset($this->data[$key]);
	}

	/**
	 * Get the value for the item
	 *
	 * @param string $key Item key
	 * @return string Item value
	 */
	public function offsetGet($key):String {
		$key = strtolower($key);
		if (!isset($this->data[$key]))
			return null;

		return $this->data[$key];
	}

	/**
	 * Set the given item
	 *
	 * @throws Requests_Exception On attempting to use dictionary as list (`invalidset`)
	 *
	 * @param string $key Item name
	 * @param string $value Item value
	 */
	public function offsetSet($key, $value): void {
        if ($key === null) {
            throw new Requests_Exception('Object is a dictionary, not a list', 'invalidset');
        }

        $key = strtolower($key);
        $this->data[$key] = $value;
    }

	/**
	 * Unset the given header
	 *
	 * @param string $key
	 */
    public function offsetUnset($key): void {
        unset($this->data[strtolower($key)]);
    }

	/**
	 * Get an iterator for the data
	 *
	 * @return ArrayIterator
	 */
	public function getIterator(): Traversable {
        return new ArrayIterator($this->data);
    }

	/**
	 * Get the headers as an array
	 *
	 * @return array Header data
	 */
	public function getAll() {
		return $this->data;
	}
}
