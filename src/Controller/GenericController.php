<?php

namespace Controller;

use Interfaces\JiraInterface;
use Atlassian\OAuthWrapper;
use Controller\CustomerController;
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class GenericController implements JiraInterface
{
    /**
     * Create OAuth Object to use Api
     *
     * @param [String] $callback
     * @return $oauth array
     */
    public function Auth($callback){
        $oauth = new OAuthWrapper('https://pruebagtd.atlassian.net/');
        $oauth->setPrivateKey(__DIR__.'\..\..\certs\jira_privatekey.pem')
            ->setConsumerKey('OauthKey')
            ->setConsumerSecret('')
            ->setRequestTokenUrl('plugins/servlet/oauth/request-token')
            ->setAuthorizationUrl('plugins/servlet/oauth/authorize?oauth_token=%s')
            ->setAccessTokenUrl('plugins/servlet/oauth/access-token')
            ->setCallbackUrl($callback);

        return $oauth;
    }
    
    public function index(){}
    
    /**
     * get function implements AbstractProviders
     *
     * @param [Silex\Application] $app
     * @return array
     */
    public function get($app)
    {      
        if (empty($oauth)) {
            $priorities = null;
        } else {
            $priorities = $app['oauth']->getClient(
                $oauth['oauth_token'],
                $oauth['oauth_token_secret']
            )->get('rest/api/2/priority')->send()->json();
        }

        return $priorities;
    }

    public function post(){}

    public function put(){}

    public function delete(){}

    /**
        * Create issue function JiraInterface
        *
        * @return json
        */ 
    public function createIssue($data = []){

    }

    public function getOrganization($oauth){
        $request = $oauth->get('/rest/servicedeskapi/organization');
        return $response = $request->send();
    }
}