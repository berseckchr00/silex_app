<?php
/**
 * Created by PhpStorm.
 * User: dgonzalezj
 * Date: 30-08-2018
 * Time: 16:42
 */

namespace Interfaces;
use Silex\Application;

/**
 * Interface Providers
 * @package Interfaces
 */
interface AbstractProviders
{
    public function index();

    public function get($app);

    public function post();

    public function put();

    public function delete();
}