<?php

namespace ethercreative\apie\traits;

use Yii;
use yii\helpers\Inflector;

trait Breadcrumbs
{
    public function getBreadcrumbs()
    {
        $breadcrumbs = [];

        $parent = explode('/', $this->id);

        if (count($parent) > 1)
        {
            $breadcrumbs[] = ['label' => Inflector::pluralize(Inflector::humanize($parent[0])), 'url' => [$parent[0] . '/index']];

            if ($parent_id = Yii::$app->request->get('parent_id'))
            {
                $breadcrumbs[] = ['label' => $parent_id, 'url' => [$parent[0] . '/update', 'id' => $parent_id]];
            }
        }

        switch ($this->action->id)
        {
            case 'index':
                $breadcrumbs[] = ['label' => Inflector::pluralize($this->name)];
                break;

            case 'update':
                $id = $this->actionParams['id'];
                $breadcrumbs[] = ['label' => Inflector::pluralize($this->name), 'url' => ['index']];
                $breadcrumbs[] = ['label' => $id, 'url' => ['view', 'id' => $id]];
                $breadcrumbs[] = ['label' => Inflector::humanize($this->action->id)];
                break;

            case 'view':
                $id = $this->actionParams['id'];
                $breadcrumbs[] = ['label' => Inflector::pluralize($this->name), 'url' => ['index']];
                $breadcrumbs[] = ['label' => $id];
                $breadcrumbs[] = ['label' => Inflector::humanize($this->action->id)];
                break;
            
            default:
                $breadcrumbs[] = ['label' => Inflector::pluralize($this->name), 'url' => ['index']];
                $breadcrumbs[] = ['label' => Inflector::humanize($this->action->id)];
                break;
        }

        if (empty($breadcrumbs[0]['label']))
            $breadcrumbs = [];

        return $breadcrumbs;
    }
}
