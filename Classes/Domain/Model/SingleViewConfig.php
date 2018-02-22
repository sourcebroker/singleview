<?php

namespace SourceBroker\Singleview\Domain\Model;

/**
 * Class SingleViewConfig
 * @package SourceBroker\Singleview\Domain\Model
 */
class SingleViewConfig
{
    /**
     * @var int
     */
    private $listPid;

    /**
     * @var int
     */
    private $singlePid;

    /**
     * @var callable|boolean
     */
    private $condition = false;

    /**
     * @var string[]
     */
    private $fields = [];

    /**
     * @var callable|string
     */
    private $hashBase = '';

    /**
     * @return int
     */
    public function getListPid()
    {
        return $this->listPid;
    }

    /**
     * @param int $listPid
     */
    public function setListPid($listPid)
    {
        $this->listPid = $listPid;
    }

    /**
     * @return int
     */
    public function getSinglePid()
    {
        return $this->singlePid;
    }

    /**
     * @param int $singlePid
     */
    public function setSinglePid($singlePid)
    {
        $this->singlePid = $singlePid;
    }

    /**
     * @return bool|callable
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param bool|callable $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return string[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string[] $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return boolean
     */
    public function isConditionMatch()
    {
        return is_callable($this->condition) ? call_user_func($this->condition) : !!$this->condition;
    }

    /**
     * @return string
     */
    public function getHashBase()
    {
        return is_callable($this->hashBase) ? (string)call_user_func($this->hashBase) : $this->hashBase;
    }

    /**
     * @param callable|string $hashBase
     */
    public function setHashBase($hashBase)
    {
        $this->hashBase = $hashBase;
    }
}
