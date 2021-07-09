<?php

namespace Box\Controller;

use Box\Model\AccessQuery;
use Box\Model\Map\AccessTableMap;
use Box\Repository\AccessRepository;
use Propel\Runtime\ActiveQuery\Criteria;

class AccessesController extends LayoutController
{
    public function get()
    {
        $this->assertAdmin();

        $client      = $this->f('client');
        $collection  = $this->f('collection');
        $level       = $this->f('level');
        $limit       = (int) $this->f('limit');
        $offset      = (int) $this->f('offset');
        $count       = $this->f('count', false);

        if (!$limit) {
            $limit = 0;
        }

        if (!$offset) {
            $offset = 0;
        }

        if (!in_array($level, AccessTableMap::getValueSet(AccessTableMap::COL_LEVEL))) {
            $level = null;
        }

        /** @var AccessRepository $repository */
        $repository = $this->s('repository.access');

        $objs = AccessQuery::create()
            ->joinWithCollection()
            ->joinWithClient()
            ->orderById(Criteria::DESC);

        if ($client) {
            $objs = $objs->filterByClientId((int) $client);
        }

        if ($collection) {
            $objs = $objs->filterByCollectionId((int) $collection);
        }

        if ($level) {
            $objs = $objs->filterByLevel($level);
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
            'accesses' => $repository->formatCollection($objs),
        ];

        if ($count) {
            $content['nb_results'] = (int) $nb_results;
        }

        $this->setContent($content);
    }
}
