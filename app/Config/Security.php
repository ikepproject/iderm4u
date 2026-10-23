<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Security extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * CSRF Protection Method
     * --------------------------------------------------------------------------
     *
     * Protection Method for Cross Site Request Forgery protection.
     *
     * @var string 'cookie' or 'session'
     */
    public $csrfProtection = 'cookie';

    /**
     * --------------------------------------------------------------------------
     * CSRF Token Randomization
     * --------------------------------------------------------------------------
     *
     * Randomize the CSRF Token for added security.
     *
     * @var bool
     */
    public $tokenRandomize = false;

    /**
     * --------------------------------------------------------------------------
     * CSRF Token Name
     * --------------------------------------------------------------------------
     *
     * Token name for Cross Site Request Forgery protection.
     *
     * @var string
     */
    public $tokenName = 'csrf_test_name';

    /**
     * --------------------------------------------------------------------------
     * CSRF Header Name
     * --------------------------------------------------------------------------
     *
     * Header name for Cross Site Request Forgery protection.
     *
     * @var string
     */
    public $headerName = 'X-CSRF-TOKEN';

    /**
     * --------------------------------------------------------------------------
     * CSRF Cookie Name
     * --------------------------------------------------------------------------
     *
     * Cookie name for Cross Site Request Forgery protection.
     *
     * @var string
     */
    public $cookieName = 'csrf_cookie_name';

    /**
     * --------------------------------------------------------------------------
     * CSRF Expires
     * --------------------------------------------------------------------------
     *
     * Expiration time for Cross Site Request Forgery protection cookie.
     *
     * Defaults to two hours (in seconds).
     *
     * @var int
     */
    public $expires = 7200;

    /**
     * --------------------------------------------------------------------------
     * CSRF Regenerate
     * --------------------------------------------------------------------------
     *
     * Regenerate CSRF Token on every submission.
     *
     * @var bool
     */
    public $regenerate = true;

    /**
     * ------------------------------------------------------------------
     * CSRF Protection Exceptions
     * ------------------------------------------------------------------
     *
     * CSRF is enabled globally in Config\Filters::$globals. These endpoints
     * cannot possibly carry a browser CSRF token and MUST stay excluded,
     * otherwise every payment notification and every mobile login fails:
     *
     *  - transaction/hook    Midtrans server-to-server payment notification.
     *                         Posted by Midtrans infrastructure: no browser,
     *                         no session, no token.
     *  - transaction/finish  Payment redirect callback carrying result_data.
     *  - api/app/auth/login  Native mobile app login. A native HTTP client has
     *                         no cookie jar to read the token from.
     *
     * Keep this list in sync if new webhook or native-app routes are added.
     *
     * @var list<string>
     */
    public $except = [
        'transaction/hook',
        'transaction/finish',
        'api/app/auth/login',
    ];

    /**
     * --------------------------------------------------------------------------
     * CSRF Redirect
     * --------------------------------------------------------------------------
     *
     * Redirect to previous page with error on failure.
     *
     * @var bool
     */
    public $redirect = true;

    /**
     * --------------------------------------------------------------------------
     * CSRF SameSite
     * --------------------------------------------------------------------------
     *
     * Setting for CSRF SameSite cookie token.
     *
     * Allowed values are: None - Lax - Strict - ''.
     *
     * Defaults to `Lax` as recommended in this link:
     *
     * @see https://portswigger.net/web-security/csrf/samesite-cookies
     *
     * @var string
     *
     * @deprecated `Config\Cookie` $samesite property is used.
     */
    public $samesite = 'Lax';
}
