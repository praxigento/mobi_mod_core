<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Repo;


interface IEntity
{
    public function getById();

    public function getList();

    public function save();
}