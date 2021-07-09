<?php

namespace Box\Controller;

use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\FastRouteRouterControllerHelpers;

class MockController extends PlainController
{
    use FastRouteRouterControllerHelpers;

    public function post()
    {
        $body = $this->f('data');
        $body = json_encode($body);

        $this->getResponse()->setContent(md5($body));

        $this->getExternalResponse()->setStatusCode(201);
    }
}
