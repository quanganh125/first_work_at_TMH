<?php
    $data = $this->get
?>
<h1>Feed</h1>
<br>
<form method="post" action=""> 
    <div style="display: flex;"> 
        <span style="padding: 18px; padding-top: 5px; font-weight: bold;">Name: </span>
        <input name="name" type="text" size="45"/>
        <input type="submit" value="POST" style="margin-left: 5px;">
        <input type="submit" value="Edit" style="margin-left: 5px;">        
        <input type="submit" value="Logout" style="margin-left: 5px;">  
    </div>

    <div style="display: flex;"> 
        <span style="padding: 5px; font-weight: bold;">Message: </span>
        <textarea name="message" rows="4" cols="50"></textarea>
    </div>
</form>
    <table>
        <tr>
            <th>Name</th>
            <th>Message</th>
            <th>Time</th>
        </tr>
    <?php foreach($messages as $message):?>

        <tr>
            <td><?= $message->name .":"?>
            <td><?= $message->message?>
            <td><?= $message->create_at->format("d/m/yy h:i:s")?>
            <td><input type="submit" value="delete" style="margin-left: 5px;"></td>
            <td><input type="submit" value="edit" style="margin-left: 5px;"></td>
        </tr>
    <?php endforeach; ?>
    </table>



