<?php

namespace App\Controller;

class ChatController extends AppController
{
    public function feed(){
    // Check login session
        $this->loadModel('tUsers');
        $session = $this->request->getSession();
        $email = $session->read('User.email');
        $check_exist_email = $this->tUsers->find()->select('name')->where(['email' => $email])->toArray();
    // If session not exist -> logout
        if(count($check_exist_email) ===0) $this->redirect(['controller'=>'User',
                                                            'action'=>'login']);
    // Show feed page
        else{
            $this->loadModel('tFeeds');
            $new_message = $this->tFeeds->newEmptyEntity();
            if ($this->request->is('post')){
                $new_message->user_id = $session->read('User.id');
                $new_message->message = $this->request->getData('message');
                $new_message->create_at = Date("Y/m/d H:i:s");
                $new_message->update_at = $new_message->create_at;
                if($this->request->getData('photo'))
                    $new_message->image_file_name = '/img/upload/' . $this->request->getData('photo');
             if($this->tFeeds->save($new_message)){
                $this->Flash->success(__('Your message has been saved'));
                return $this->redirect(['action' => 'feed']);
            }
             $this->Flash->error(__('Unable to save your message.'));
            }
            $messages = $this->Paginator->paginate($this->tFeeds->find()->order(['update_at' => 'DESC']));
            $users = $this->Paginator->paginate($this->tUsers->find());
            $this->set(compact('messages','users'));
        }
    }

    public function edit(){
        $this->loadModel('tFeeds');

        $id = $this->request->getData('edit_id');
        $mes = $this->request->getData('message');

        $query = $this->tFeeds->query();
        $query->update()
            ->set(['message' => $mes,'update_at'=>Date("Y/m/d H:i:s")] )
            ->where(['id' => $id])
            ->execute();
        return $this->redirect(['action' => 'feed']);
    }
    
    public function delete($id){
        $this->loadModel('tFeeds');
        $message = $this->tFeeds->findById($id)->firstOrFail();
        if ($this->tFeeds->delete($message)) {
            $this->Flash->success(__('message has been deleted.'));
            return $this->redirect(['action' => 'feed']);
        }
    }
}