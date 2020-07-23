<?php
namespace App\Model\Table;

 use Cake\ORM\Table;

class tFeedsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('t_feed');
    }
}