<?php

namespace app\repositories;

abstract class BaseLegacyRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    protected abstract function getModelInstance();

}