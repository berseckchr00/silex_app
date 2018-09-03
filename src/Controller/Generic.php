<?php

namespace Controller;

use Interfaces\JiraInterface;

class Generic implements JiraInterface
{
    /**
     * @param $callback
     * @return Atlassian\OAuthWrapper|mixed
     */
    public function Auth($callback)
    {
        $oauth = new Atlassian\OAuthWrapper('https://pruebagtd.atlassian.net/');
        $oauth->setPrivateKey(__DIR__.'\..\..\certs\jira_privatekey.pem')
            ->setConsumerKey('OauthKey')
            ->setConsumerSecret('')
            ->setRequestTokenUrl('plugins/servlet/oauth/request-token')
            ->setAuthorizationUrl('plugins/servlet/oauth/authorize?oauth_token=%s')
            ->setAccessTokenUrl('plugins/servlet/oauth/access-token')
            ->setCallbackUrl($callback);
        return $oauth;
    }

    public function createIssue($data)
    {
        // TODO: Implement createIssue() method.
    }

}