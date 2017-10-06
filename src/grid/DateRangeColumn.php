<?php

namespace ethercreative\apie\grid;

use yii\helpers\Html;

class DateRangeColumn extends \yii\grid\DataColumn
{
    public $from, $to;

    protected function renderFilterCellContent()
    {
        if (is_string($this->filter))
            return $this->filter;

        $model = $this->grid->filterModel;

        return Html::activeInput('date', $model, $this->from, $this->filterInputOptions) . Html::activeInput('date', $model, $this->to, $this->filterInputOptions);
    }
}
