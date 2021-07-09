<?php

namespace Box\Controller;

use Box\Model\ClientQuery;
use Box\Repository\ClientRepository;

class ClientsController extends LayoutController
{
    public function get()
    {
        $this->assertAdmin();

        $name        = $this->f('name');
        $is_admin    = $this->f('is_admin');
        $limit       = (int) $this->f('limit');
        $offset      = (int) $this->f('offset');
        $count       = $this->f('count', false);

        if (!$limit) {
            $limit = 0;
        }

        if (!$offset) {
            $offset = 0;
        }

        /** @var ClientRepository $repository */
        $repository = $this->s('repository.client');

        $objs = ClientQuery::create()
            ->orderByName();

        if ($name) {
            $objs = $objs->filterByName($name);
        }

        if (is_bool($is_admin)) {
            $objs = $objs->filterByIsAdmin($is_admin);
        }

        if ($count) {
            $nb_results_query = clone $objs;
            $nb_results       = $nb_results_query->count();
        }

        if ($limit) {
            $objs = $objs->limit($limit);
        }

        if ($offset) {
            $objs = $objs->offset($offset);
        }

        $objs = $objs->find();

        $content = [
            'clients' => $repository->formatCollection($objs),
        ];

        if ($count) {
            $content['nb_results'] = (int) $nb_results;
        }

        $this->setContent($content);
    }
}
