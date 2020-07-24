<?php

namespace App\Controller;

use Cake\Http\Session;

class UserController extends AppController{
    public function login(){
        $this->loadModel('tUsers');
        $login = $this->tUsers->newEmptyEntity();
        $session = $this->request->getSession();

        if($this->request->is('post')){
            $login->email = $this->request->getData('email');  
            $login->password = $this->request->getData('password');   
            $data = $this->tUsers->find()->select('name')->where(['`e-mail`' => $login->email, 'password'=>$login->password])->toArray();
            
            if(0 !== count($data)){
                $session->write([
                    'User.name' => $data[0]->name,
                    'User.email' => $login->email,
                  ]);
                $this->Flash->success(__('Login successfull'));
                $this->redirect(['controller'=>'Chat',
                                'action'=>'feed']);
            } else{
                $this->Flash->error(__('Login fail !'));
                $this->redirect(['controller'=>'User',
                                'action'=>'login']);
            }
        }
    }

    public function regist(){

    }
}