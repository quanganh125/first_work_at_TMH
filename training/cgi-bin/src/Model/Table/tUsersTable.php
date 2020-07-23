<?php
namespace App\Model\Table;

 use Cake\ORM\Table;

class tUsersTable extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('t_user');
    }
}