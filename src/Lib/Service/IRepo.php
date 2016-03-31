<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service;

use Praxigento\Core\Lib\Service\Repo\Request;
use Praxigento\Core\Lib\Service\Repo\Response;

interface IRepo {
    /**
     * @param Request\AddEntity $request
     *
     * @return Response\AddEntity
     */
    public function addEntity(Request\AddEntity $request);

    /**
     * @param Request\UpdateEntity $request
     *
     * @return Response\UpdateEntity
     */
    public function updateEntity(Request\UpdateEntity $request);

    /**
     * @param Request\ReplaceEntity $request
     *
     * @return Response\ReplaceEntity
     */
    public function replaceEntity(Request\ReplaceEntity $request);

    /**
     * Select entity by primary key (PK).
     *
     * @param Request\GetEntityByPk $request
     *
     * @return Response\GetEntityByPk
     */
    public function getEntityByPk(Request\GetEntityByPk $request);

    /**
     * Get one type entities (from one table).
     *
     * @param Request\GetEntities $request
     *
     * @return Response\GetEntities
     */
    public function getEntities(Request\GetEntities $request);
}