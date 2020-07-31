<?php
    $data = $this->request->getSession();
?>

<head>
 <link rel ="stylesheet" type ="text/css" href="/css/feed.css" >
</head>

<h1>Feed</h1>
<br>
<form method="post" action=""> 
    <div style="display: flex;"> 
        <span style="padding: 18px; padding-top: 5px; font-weight: bold;">Name: </span>
        <input name="name" type="text" value="<?php echo $data->read('User.name') ?>" size="45"/ readonly>
        <input type="submit" value="POST" style="margin-left: 5px;">
        <input type="submit" formaction="edit" value="Edit" style="margin-left: 5px;">   

        <input type='file' id="BtnBrowseHidden" name="media" hidden>
        <label for="BtnBrowseHidden" id="LblBrowse" style="margin-left: 5px;">                                 
            Media
        </label>
        <input type="submit" formaction="/user/logout" value="Logout" style="margin-left: 5px;">  
    </div>

    <div style="display: flex;"> 
        <span style="padding: 5px; font-weight: bold;">Message: </span>
        <textarea id="edit" name="message" rows="4" cols="50"></textarea>
        <textarea id="edit_id" name="edit_id" hidden="true"></textarea>
    </div>
</form>
<forn method="get" action="">
    <div style="background-color: rebeccapurple;width: 800px;height: 100px;overflow-x:auto;;margin-right: auto;margin-left: auto">
        <?php   $files = array_diff(scandir('img/stamp'), array('.', '..'));
        for( $i=2;$i<= count($files)+1;$i++){ ?>
           <a href="/chat/feed?stamp_name=<?= $files[$i]?>"><img src="<?= '/img/stamp/'.$files[$i] ?>"></a>
        <?php } ?>
    </div>
<form>
    <table>
        <tr>
            <th>Name</th>
            <th>Message</th>
            <th>Time</th>
        </tr>
    <?php foreach($messages as $message):?>
        <form method="post" action="">
        <tr>          
            <td><?php
                foreach($users as $user){
                    if($user->id == $message->user_id)
                        echo $user->name.':';
                }
            ?>
            <td><?php 
                if($message->stamp_name != NULL){ ?>
                    <img src="<?= '/img/stamp/'.$message->stamp_name ?>">
                <?php }else{
                if($message->message != NULL)
                    echo $message->message;
                if($message->image_file_name != NULL && strpos($message->image_file_name,'.mp4')){?>
                    <video width="320" height="240" controls>
                        <source src="<?= $message->image_file_name?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                 <?php } 
                if($message->image_file_name != NULL && strpos($message->image_file_name,'.jpg'))
                    echo $this->Html->image($message->image_file_name, array('alt' => 'CakePHP','width'=>'320px'));
                }
            ?></td>
            <td><?= $message->update_at->format("d/m/yy h:i:s")?>
            <td><input type="submit" formaction="delete/<?=$message->id?>" value="delete" style="margin-left: 5px;">
            <?php if($message->message != NULL){ ?>
            <button type="button" style="margin-left: 5px;" onclick="edit('<?=$message->message?>', '<?=$message->id?>')">Edit</button>     
            <script>
                function edit(mes, id){
                    document.getElementById("edit").innerHTML = mes;
                    document.getElementById("edit_id").innerHTML = id;
                }
            </script> <?php }?>
            </td>
        </tr>
        </form>
    <?php endforeach; ?>
    </table>