<?php

namespace ethercreative\apie\traits;

trait ParentColumn
{
    protected $_parentColumn;

    public function getParentColumn()
    {
        return $this->_parentColumn;
    }

    public function setParentRelation($value)
    {
        if (!$this->parentColumn)
            return;

        if ($this->hasProperty($this->parentColumn))
            return $this->{$this->parentColumn} = $value;

        if ($this->hasProperty('_values'))
            return $this->_values[$this->parentColumn] = $value;
    }
}
