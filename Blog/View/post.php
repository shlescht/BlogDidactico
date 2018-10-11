<?php require 'inc/header.php' ?>
<?php if (empty($this->oPost)): ?>
    <p class="error">¡No pudimos encontrar el post! :(</p>
<?php else: ?>
    <article>
        <time datetime="<?=$this->oPost->createdDate?>" pubdate="pubdate"></time>
        <h1><?=htmlspecialchars($this->oPost->title)?></h1>
        <?php if($this->oPost->file_type == "pdf"): ?>
        <iframe src="<?php echo URL_FILE . $this->oPost->file_name ?>"
         style="width:600px; height:500px;" frameborder="0">
        </iframe>
        <?php elseif ($this->oPost->file_type == "ppt" || $this->oPost->file_type == "pptx"):  ?>
          <p>ppt</p>
        <?php elseif ($this->oPost->file_type == "mp3" || $this->oPost->file_type == "ogg"): ?>
          <audio controls>
           <source src="<?php echo URL_FILE . $this->oPost->file_name ?>" type="audio/ogg">
           <source src="<?php echo URL_FILE . $this->oPost->file_name ?>" type="audio/mpeg">
             <p>Su navegador no soporta la reproducci&oacute;n de audio en HTML5 :( desc&aacute;rguelo dando click <a href="<?php echo URL_FILE . $this->oPost->file_name ?>">aqu&iacute;.</a></p>
          </audio>
        <?php elseif ($this->oPost->file_type == "none"):  ?>
            <p><?=nl2br(htmlspecialchars($this->oPost->body))?></p>
        <?php elseif($this->oPost->file_type == "mp4" || $this->oPost->file_type == "ogg" || $this->oPost->file_type == "webm"): ?>
          <video width="320" height="240" controls>
           <source src="<?php echo URL_FILE . $this->oPost->file_name ?>" type="video/mp4">
           <source src="<?php echo URL_FILE . $this->oPost->file_name ?>" type="video/ogg">
             <p>Su navegador no soporta la reproducci&oacute;n de video en HTML5 :( desc&aacute;rgalo dando click <a href="<?php echo URL_FILE . $this->oPost->file_name ?>">aqu&iacute;.</a></p>
          </video>
        <?php elseif ($this->oPost->file_type == "jpeg" || $this->oPost->file_type == "jpg" || $this->oPost->file_type == "gif" || $this->oPost->file_type == "png"): ?>
          <img src="<?php echo URL_FILE . $this->oPost->file_name ?>" alt="">
        <?php else: ?>
          <p>EL archivo no puede ser reconocido por nuestro sitio :( desc&aacute;rguelo para ejecutarlo.</p>
          <p>De click <a href="<?php echo URL_FILE . $this->oPost->file_name ?>">aqu&iacute;.</a></p>
        <?php endif ?>
        <br>
        <p class="center left small italic">Creado <?=$this->oPost->createdDate?></p>
        <br>
        <?php
            $oPost = $this->oPost;
            require 'inc/control_buttons.php';
        ?>
    </article>
<?php endif ?>
<?php require 'inc/footer.php' ?>
