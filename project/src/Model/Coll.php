<?php

namespace Box\Model;

use Box\Model\Base\Coll as BaseColl;
use Box\Model\Map\CollTableMap;

/**
 * Skeleton subclass for representing a row from the '_collection' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Coll extends BaseColl
{
    public function isStorage(): bool
    {
        return $this->getType() === CollTableMap::COL_TYPE_STORAGE;
    }

    public function isSync(): bool
    {
        return $this->getType() === CollTableMap::COL_TYPE_SYNC;
    }

    public function isAsync(): bool
    {
        return $this->getType() === CollTableMap::COL_TYPE_ASYNC;
    }

    public function isProtected(): bool
    {
        return in_array($this->getName(), ['system']);
    }
}
