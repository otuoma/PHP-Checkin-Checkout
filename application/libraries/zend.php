<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

	/**
04	 * Zend Framework Loader
05	 *
06	 * Put the 'Zend' folder (unpacked from the Zend Framework package, under 'Library')
07	 * in CI installation's 'application/libraries' folder
08	 * You can put it elsewhere but remember to alter the script accordingly
09	 *
10	 * Usage:
11	 *   1) $this->load->library('zend', 'Zend/Package/Name');
12	 *   or
13	 *   2) $this->load->library('zend');
14	 *      then $this->zend->load('Zend/Package/Name');
15	 *
16	 * * the second usage is useful for autoloading the Zend Framework library
17	 * * Zend/Package/Name does not need the '.php' at the end
18	 */
	class CI_Zend
	{
	    /**
	     * Constructor
	     *
	     * @param   string $class class name
	     */
	    function __construct($class = NULL)
	    {
	        // include path for Zend Framework
	        // alter it accordingly if you have put the 'Zend' folder elsewhere
	         ini_set('include_path',
	         ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'libraries');
	 
	        if ($class)
	        {
	            require_once (string) $class . EXT;
	            log_message('debug', "Zend Class $class Loaded");
	        }
	        else
	        {
	            log_message('debug', "Zend Class Initialized");
	        }
	    }
	 
	    /**
	     * Zend Class Loader
	     *
	     * @param   string $class class name
	     */
	    function load($class)
	    {
	        require_once (string) $class . EXT;
	        log_message('debug', "Zend Class $class Loaded");
	    }
	}
	 
	?>