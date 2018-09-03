<?php

/**
 * Interface JiraInterface connect and use Api Jira
 */
namespace Interfaces;

interface JiraInterface extends AbstractProviders
{
    public function createIssue($data);
}