<?php

namespace App\Controller;

class UserController extends AppController{
    public function login(){
        $this->loadModel('tUsers');
        $login = $this->tUsers->newEmptyEntity();
        $session = $this->request->getSession();

        if($this->request->is('post')){
            $login->email = $this->request->getData('email');  
            $login->password = $this->request->getData('password');   

            if($this->tUsers->find()->where(['email' => $login->email, 'login'=>$login->password]))
                $session->write([
                    'User.email' => $login->email,
                    'User.password' => $login ->password
                ]);
        }
    }

    public function regist(){

    }
}