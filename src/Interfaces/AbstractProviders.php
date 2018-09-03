<?php
/**
 * Created by PhpStorm.
 * User: dgonzalezj
 * Date: 30-08-2018
 * Time: 16:42
 */

namespace Interfaces;

use Atlassian\OAuthWrapper;

/**
 * Interface Providers
 * @package Interfaces
 */
interface AbstractProviders
{
    /**
     * OAuth Method to loggin Jira
     * @param OAuthWrapper $oauth
     * @return mixed
     *
     */
    public function Auth($callback);
}