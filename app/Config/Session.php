<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\BaseHandler;
use CodeIgniter\Session\Handlers\FileHandler;

/**
 * Session Configuration
 *
 * CodeIgniter 4.4 moved the session settings out of Config\App into this
 * file, and 4.5 dropped the fallback that read them from Config\App. On
 * 4.4+ a missing Config\Session is fatal: Services::session() reads
 * `$config->driver` with no fallback, so this file must exist.
 *
 * The values below are copied verbatim from the session properties that
 * used to live in Config\App, so session behaviour is unchanged.
 */
class Session extends BaseConfig
{
    /**
     * ------------------------------------------------------------------
     * Session Driver
     * ------------------------------------------------------------------
     *
     * The session storage driver to use:
     * - `CodeIgniter\Session\Handlers\FileHandler`
     * - `CodeIgniter\Session\Handlers\DatabaseHandler`
     * - `CodeIgniter\Session\Handlers\MemcachedHandler`
     * - `CodeIgniter\Session\Handlers\RedisHandler`
     *
     * @var string
     */
    public string $driver = FileHandler::class;

    /**
     * ------------------------------------------------------------------
     * Session Cookie Name
     * ------------------------------------------------------------------
     *
     * The session cookie name, must contain only [0-9a-z_-] characters
     *
     * @var string
     */
    public string $cookieName = 'ci_session';

    /**
     * ------------------------------------------------------------------
     * Session Expiration
     * ------------------------------------------------------------------
     *
     * The number of SECONDS you want the session to last.
     * Setting to 0 (zero) means expire when the browser is closed.
     *
     * @var int
     */
    public int $expiration = 7200;

    /**
     * ------------------------------------------------------------------
     * Session Save Path
     * ------------------------------------------------------------------
     *
     * The location to save sessions to and is driver dependent.
     * For the 'files' driver, it's a path to a writable directory.
     * WARNING: Only absolute paths are supported!
     *
     * @var string
     */
    public string $savePath = WRITEPATH . 'session';

    /**
     * ------------------------------------------------------------------
     * Session Match IP
     * ------------------------------------------------------------------
     *
     * Whether to match the user's IP address when reading the session data.
     *
     * @var bool
     */
    public bool $matchIP = false;

    /**
     * ------------------------------------------------------------------
     * Session Time to Update
     * ------------------------------------------------------------------
     *
     * This is the number of seconds between the session being written to
     * the session handler and the session data being updated.
     *
     * @var int
     */
    public int $timeToUpdate = 300;

    /**
     * ------------------------------------------------------------------
     * Session Regenerate Destroy
     * ------------------------------------------------------------------
     *
     * Whether to destroy the session on regeneration.
     *
     * @var bool
     */
    public bool $regenerateDestroy = false;

    /**
     * ------------------------------------------------------------------
     * Database Group
     * ------------------------------------------------------------------
     *
     * If you are using a database handler, this is the DB group config name.
     *
     * @var string|null
     */
    public ?string $DBGroup = null;
}
