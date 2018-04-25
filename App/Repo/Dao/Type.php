<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Dao;

use Praxigento\Core\App\Repo\Data\Entity\Type\Base as ETypeBase;

/**
 * Base implementation for types codifiers repository.
 */
abstract class Type
    extends \Praxigento\Core\App\Repo\Dao
{
    /** @var array "id-by-code" map */
    private $cached;

    /**
     * @param string $code
     * @return int|null
     */
    public function getIdByCode($code)
    {
        $result = null;
        if (is_null($this->cached)) $this->load();
        if (isset($this->cached[$code])) {
            $result = $this->cached[$code];
        }
        return $result;
    }

    /**
     * Load data and compose "id-by-code" cache.
     */
    private function load()
    {
        $this->cached = [];
        $entities = $this->daoGeneric->getEntities($this->entityName);
        foreach ($entities as $one) {
            $id = $one[ETypeBase::A_ID];
            $code = $one[ETypeBase::A_CODE];
            $this->cached[$code] = $id;
        }
    }
}