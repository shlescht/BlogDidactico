
<?php require 'inc/header.php' ?>
<?php require 'inc/msg.php' ?>

<form action="" method="post" enctype="multipart/form-data">

    <p>
        <label for="title">Título:</label><br />
        <input type="text" name="title" id="title" required="required" />
    </p>

    <p>
        <label for="body">Descripcion:</label><br />
        <textarea name="body" id="body" rows="5" cols="35" required="required"></textarea>
    </p>

    <p>
      <label for="fileToUpload">
      <input type="file" name="fileToUpload" id="fileToUpload" />
    </p>

    <p><input type="submit" name="add_submit" value="Subir" /></p>
</form>

<?php require 'inc/footer.php' ?>
