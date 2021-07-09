<?php

namespace Box\Controller;

use Box\Model\AccessQuery;
use Box\Model\Client;
use Box\Model\ClientQuery;
use Box\Model\CollQuery;
use Box\Model\Map\AccessTableMap;
use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\Router\Http\FastRouteRouterControllerHelpers;
use Perfumer\Framework\View\StatusViewControllerHelpers;

class LayoutController extends ViewController
{
    use FastRouteRouterControllerHelpers;
    use StatusViewControllerHelpers;

    /**
     * @var Client
     */
    private $client;

    protected function getClient()
    {
        if (!$this->client instanceof Client) {
            $secret = $this->getExternalRequest()->headers->get('Api-Secret');

            if (!$secret) {
                return null;
            }

            $this->client = ClientQuery::create()
                ->filterBySecret($secret)
                ->findOne();
        }

        return $this->client;
    }

    protected function getAccess($name)
    {
        $client = $this->getClient();

        if (!$client || $client->isDisabled()) {
            $this->forward('error', 'accessDenied');
        }

        $collection = CollQuery::create()
            ->filterByName($name)
            ->findOne();

        if (!$collection) {
            $this->forward('error', 'pageNotFound', ["Collection \"$name\" was not found"]);
        }

        return AccessQuery::create()
            ->filterByClient($client)
            ->filterByCollection($collection)
            ->findOne();
    }

    protected function assertAdmin()
    {
        $test = $this->getContainer()->getParam('box/test');
        $admin_secret = $this->getContainer()->getParam('box/admin_secret');
        $secret = $this->getExternalRequest()->headers->get('Api-Secret');

        if ($test === true && $admin_secret === $secret) {
            return;
        }

        $client = $this->getClient();

        if (!$client || !$client->isAdmin() || $client->isDisabled()) {
            $this->forward('error', 'accessDenied');
        }
    }

    protected function assertReadAccess($name)
    {
        $client = $this->getClient();

        if ($client && $client->isAdmin() && !$client->isDisabled()) {
            return;
        }

        $access = $this->getAccess($name);

        if (!$access) {
            $this->forward('error', 'accessDenied');
        }
    }

    protected function assertWriteAccess($name)
    {
        $client = $this->getClient();

        if ($client && $client->isAdmin() && !$client->isDisabled()) {
            return;
        }

        $access = $this->getAccess($name);

        if (!$access || $access->getLevel() !== AccessTableMap::COL_LEVEL_WRITE) {
            $this->forward('error', 'accessDenied');
        }
    }

    protected function validateNotEmpty($var, $name)
    {
        if (!$var) {
            $this->forward('error', 'badRequest', ["\"$name\" parameter must be set"]);
        }
    }

    protected function validateRegex($var, $name, $regex)
    {
        if (!preg_match($regex, $var)) {
            $this->forward('error', 'badRequest', ["\"$name\" parameter is invalid, only letters, digits and underscore signs are allowed"]);
        }
    }
}
