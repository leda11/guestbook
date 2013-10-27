    <h1>Handy min Gästbok</h1>
    <p><i>Kopplat till databas. SQL och html separerat.</i></p>

    <form action="<?=$formAction?>" method='post'> 
      <p>
        <label>Kommentarer: <br/>
        <textarea name='newEntry' id='textInput'></textarea></label>
      </p>
      <p>
        <input type='submit' name='doAdd' value='Add message' />
        <input type='submit' name='doClear' value='Clear all messages' />
        <input type='submit' name='doCreate' value='Create database table' />
      </p>
    </form>

    <h2>Gästbokens meddelande</h2>

    <?php foreach($entries as $val):?>
    <div id='comment'>
      <p>At: <?=$val['created']?></p>
      <p><?=htmlent($val['entry'])?></p>
    </div>
    <?php endforeach;?>
    

