<?php

namespace Box\Controller;

use Box\Model\CollQuery;
use Box\Model\Map\CollTableMap;
use Box\Repository\CollectionRepository;

class CollectionsController extends LayoutController
{
    public function get()
    {
        $this->assertAdmin();

        $name        = $this->f('name');
        $type        = $this->f('type');
        $limit       = (int) $this->f('limit');
        $offset      = (int) $this->f('offset');
        $count       = $this->f('count', false);

        if (!$limit) {
            $limit = 0;
        }

        if (!$offset) {
            $offset = 0;
        }

        if (!in_array($type, CollTableMap::getValueSet(CollTableMap::COL_TYPE))) {
            $type = null;
        }

        /** @var CollectionRepository $repository */
        $repository = $this->s('repository.collection');

        $objs = CollQuery::create()
            ->orderByName();

        if ($name) {
            $objs = $objs->filterByName($name);
        }

        if ($type) {
            $objs = $objs->filterByType($type);
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
            'collections' => $repository->formatCollection($objs),
        ];

        if ($count) {
            $content['nb_results'] = (int) $nb_results;
        }

        $this->setContent($content);
    }
}
