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
            $data = $this->tUsers->find()->select(['name','id'])->where(['email' => $login->email, 'password'=>$login->password])->toArray();
            if(0 !== count($data)){
                $session->write([
                    'User.id' => $data[0] ->id,
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

    public function logout(){
        $data = $this->request->getSession();
        $data->destroy();
        $this->redirect(['controller'=>'User',
                            'action'=>'login']);
    }

    public function regist(){
        $this->loadModel('tUsers');
        $new_account = $this->tUsers->newEmptyEntity();

        if($this->request->is('post')){
            $new_account->email = $this->request->getData('email'); 
            $new_account->password = $this->request->getData('password'); 
            $new_account->name = $this->request->getData('name'); 

            $check_exist_account = $this->tUsers->find()->select('email')->where(['email' => $new_account->email])->toArray();
        
            if(count($check_exist_account)===0){
                if($this->tUsers->save($new_account)){
                    $this->Flash->success(__('Regist successfull'));
                    return $this->redirect(['action'=>'login']);
                } else {
                    $this->Flash->error(__('Regist fail. Try again'));
                    return $this->redirect(['action' => 'regist']);
                }
            } else{
                $this->Flash->error(__('Email exist'));
                return $this->redirect(['action' => 'regist']);
            }
        }
    }
}