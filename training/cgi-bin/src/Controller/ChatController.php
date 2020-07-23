<?php

namespace App\Controller;

class ChatController extends AppController
{
    public function feed(){
        
        $this->loadModel('tFeeds');

        $new_message = $this->tFeeds->newEmptyEntity();
        if ($this->request->is('post')){
            $new_message->name =$this->request->getData('name');
            $new_message->message =$this->request->getData('message');
            $new_message->create_at = Date("Y/m/d H:i:s");
            // print_r($new_message);
        if($this->tFeeds->save($new_message)){
            $this->Flash->success(__('Your message has been saved'));
            return $this->redirect(['action' => 'feed']);
        }
        $this->Flash->error(__('Unable to save your message.'));
        }

        $messages = $this->Paginator->paginate($this->tFeeds->find()->order(['create_at' => 'DESC']));
        $this->set(compact('messages'));
  
    }
}