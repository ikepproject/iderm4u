<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Setup how the exception handler works.
 */
class Exceptions extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * LOG EXCEPTIONS?
     * --------------------------------------------------------------------------
     * If true, then exceptions will be logged
     * through Services::Log.
     *
     * Default: true
     *
     * @var bool
     */
    public $log = true;

    /**
     * --------------------------------------------------------------------------
     * DO NOT LOG STATUS CODES
     * --------------------------------------------------------------------------
     * Any status codes here will NOT be logged if logging is turned on.
     * By default, only 404 (Page Not Found) exceptions are ignored.
     *
     * @var array
     */
    public $ignoreCodes = [404];

    /**
     * --------------------------------------------------------------------------
     * Error Views Path
     * --------------------------------------------------------------------------
     * This is the path to the directory that contains the 'cli' and 'html'
     * directories that hold the views used to generate errors.
     *
     * Default: APPPATH.'Views/errors'
     *
     * @var string
     */
    public $errorViewPath = APPPATH . 'Views/errors';

    /**
     * --------------------------------------------------------------------------
     * HIDE FROM DEBUG TRACE
     * --------------------------------------------------------------------------
     * Any data that you would like to hide from the debug trace.
     * In order to specify 2 levels, use "/" to separate.
     * ex. ['server', 'setup/password', 'secret_token']
     *
     * @var array
     */
    public $sensitiveDataInTrace = [];

    /**
     * ------------------------------------------------------------------
     * LOG DEPRECATIONS
     * ------------------------------------------------------------------
     *
     * If true, deprecation notices are logged instead of being thrown as
     * exceptions.
     *
     * This matters on PHP 8.4. CodeIgniter registers its error handler
     * unconditionally (not just in debug mode) and THROWS an
     * ErrorException on every E_DEPRECATED it sees, unless this is true.
     * PHP 8.4 raises a deprecation for every implicitly-nullable
     * parameter type, and CodeIgniter's own system/ directory still
     * contains ~450 of them. With this false, every request dies on the
     * first deprecation raised while loading a framework class.
     *
     * @var bool
     */
    public $logDeprecations = true;

    /**
     * ------------------------------------------------------------------
     * Deprecation Log Level
     * ------------------------------------------------------------------
     *
     * The log level used when writing deprecation notices to the log.
     *
     * @var string
     */
    public $deprecationLogLevel = 'warning';
}
