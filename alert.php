<!--IF ERROR-->

        <?php if (count($errors) > 0) : ?>
            <div class="msg">
             
                    <?php foreach ($errors as $error) : ?>
                   <div class="msg-container w3-round w3-card-4 w3-red">
                    <span class="closebtn" onclick="this.parentElement.style.display = 'none';">&times;</span>
                        <?php echo $error; ?>
                    
                    </div>
                <br>
                    <?php endforeach ?>
                
            </div>

        <?php endif ?>

        <!--IF SUCCESS-->

        <?php if (count($success) > 0) : ?>


            <div class="msg">

                <?php foreach ($success as $succes) : ?>

                    <div class="msg-container w3-card-4 w3-green">
                        <span class="closebtn" onclick="this.parentElement.style.display = 'none';">&times;</span>
                        <?php echo $succes; ?>
                    </div>
                <?php endforeach ?>
            </div>

        
<?php endif ?>

