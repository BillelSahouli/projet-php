<div class="sidebar">
    <h4>Derniers Article</h4>
    
    <?php
    $select = $bdd->prepare("SELECT * FROM plats ORDER BY id DESC LIMIT 0,2");
    $select->execute(); 
                
    while ($s=$select->fetch(PDO::FETCH_OBJ)) 
    {
        $lenght=35;

        $description=$s->description;
    
        $new_description=substr($description,0,$lenght)."...";

        $description_finale=wordwrap($new_description,55,'<br/>', false);

        ?>
        <div style="text-align:center;">
        <img height="80" width="100" src="Admin/imgs/<?php echo $s->title; ?>.jpg"/>
        <h2 style ="color:white;"><?php echo $s->title; ?></h2>
        <h5 style ="color:white;"><?php echo $description_finale; ?></h5>
        <h4 style ="color:white;"><?php echo $s->price; ?> Euros</h4></div>
        <br/><br/>

        <?php
    }
    ?>
    <br/><br/><br/>
</div>
