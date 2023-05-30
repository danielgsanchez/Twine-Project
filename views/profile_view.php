<?php

?>

<div class="card mx-auto" style="width: 300px;">
  <form action="update_profile.php" method="post">
    <img class="profile-picture rounded-circle my-3" src="<?php echo $profileData['photo']; ?>" alt="<?php echo $profileData['photo_desc']?>">
    <div class="text-center mb-3">
      <button type="submit" class="btn btn-primary">Cambiar Foto</button>
    </div>
  </form>
  <form action="update_profile.php" method="post">
    <div class="form-group">
      <label for="first_name">Nombre:</label>
      <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $profileData['first_name']; ?>">
    </div>
    <div class="form-group">
      <label for="last_name">Apellido:</label>
      <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $profileData['last_name']; ?>">
    </div>
    <div class="form-group">
      <label for="gender_id">Género:</label>
      <select id="gender_id" name="gender_id" class="form-control">
        <option value="1" <?php if ($profileData['gender_id'] == 'M') echo 'selected'; ?>>Masculino</option>
        <option value="2" <?php if ($profileData['gender_id'] == 'F') echo 'selected'; ?>>Femenino</option>
      </select>
    </div>
    <div class="form-group">
      <label for="description">Descripción:</label>
      <textarea id="description" name="description" class="form-control"><?php echo $profileData['description']; ?></textarea>
    </div>
    <div class="form-group">
      <label for="screen_name">Nombre de usuario:</label>
      <input type="text" id="screen_name" name="screen_name" class="form-control" value="<?php echo $profileData['screen_name']; ?>">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
  </form>
</div>
