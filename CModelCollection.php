<?php

class CModelCollection extends CCollection
{
    private $_type;

    protected function create($data)
    {
        return new static($this->_type, $data);
    }

    public function __construct($type = 'CModel', $models = null, $readOnly = false)
    {
        if ($type !== 'CModel' && !is_subclass_of($type, 'CModel')) {
            throw new CException('CModelCollection can only hold CModels');
        }

        $this->_type = $type;

        parent::__construct($models, $readOnly);
    }

    public function add($index, $item)
    {
        if ($item instanceof $this->_type) {
            parent::add($index, $item);
        } else {
            throw new CException(Yii::t('yii', 'CModelCollection<{type}> can only hold objects of {type} class.',
                array('{type}' => $this->_type)));
        }
    }
}