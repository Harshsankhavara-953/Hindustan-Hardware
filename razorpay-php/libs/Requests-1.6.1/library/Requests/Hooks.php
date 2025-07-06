<?php
/**
 * Handles adding and dispatching events
 *
 * @package Requests
 * @subpackage Utilities
 */

/**
 * Handles adding and dispatching events
 *
 * @package Requests
 * @subpackage Utilities
 */
class Requests_Hooks implements Requests_Hooker {
    /**
     * Holds registered callbacks for hooks
     *
     * @var array
     */
    protected $hooks = array();

    /**
     * Constructor
     */
    public function __construct() {
        // pass
    }
    public function register($hook, $callback, $priority = 0) {
        if (!isset($this->hooks[$hook])) {
            $this->hooks[$hook] = array();
        }
        if (!isset($this->hooks[$hook][$priority])) {
            $this->hooks[$hook][$priority] = array();
        }

        $this->hooks[$hook][$priority][] = $callback;
    }
	/**
	 * Dispatch a message
	 *
	 * @param string $hook Hook name
	 * @param array $parameters Parameters to pass to callbacks
	 * @return boolean Successfulness
	 */
    public function dispatch($hook, $parameters = array()) {
        if (empty($this->hooks[$hook])) {
            return false;
        }

        foreach ($this->hooks[$hook] as $priority => $hooked) {
            foreach ($hooked as $callback) {
                call_user_func_array($callback, $parameters);
            }
        }

        return true;
    }
}