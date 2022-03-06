<?php

namespace Modules\Auth\Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
    /**
     * --------------------------------------------------------------------
     * Remember Me (Persistent Login)
     * --------------------------------------------------------------------
     *
     * If you want to enable / disable the remember me function set to
     * true / false
     *
     * Uses a timing-attack safe remember me token in the DB and cookie
     * Implemented using the proposed strategy
     *
     * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
     *
     * @var bool
     */
    public $rememberMe = true;

    /**
     * --------------------------------------------------------------------
     * Remember Me Expiry
     * --------------------------------------------------------------------
     *
     * The amount of days the login lasts for
     * default is 30 days
     *
     * @var int
     */
    public $rememberMeExpire = 30;

    /**
     * --------------------------------------------------------------------
     * Remember Me Renew
     * --------------------------------------------------------------------
     *
     * if set to true anytime the user visits the site and a cookie is found
     * a new expiry date is set using the $rememberMeExpire setting above. Technically
     * creating an infinate login session if the user is active on the site
     *
     * cookie will stille expire after set days if user does not visit the site forcing a login
     *
     * if set to false the user login cookie will expire and force a login within the expiry
     * time set above regardless of how active they are on the site.
     *
     * @var bool
     */
    public $rememberMeRenew = true;

    /**
     * --------------------------------------------------------------------
     * Key AES Hash
     * --------------------------------------------------------------------
     *
     * key use when we need to decrypt or crypt admin password in the Datadase

     *
     * @var string
     */
    public $keyAesHash = "123";


}

