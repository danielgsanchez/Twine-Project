<?php

require_once __DIR__ . "/../models/conn.php";

class UserModel
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Método para obtener el ID de un usuario por su correo electrónico
    function getId($email)
    {
        $sql = "SELECT * FROM twn_users WHERE email = '$email'";
        $result = $this->conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                return $row['id'];
            } else {
                return 'No existe ese email en la base de datos';
            }
        } else {
            return 'Error en la consulta';
        }

        $this->closeConnection();
    }

    // Método para obtener el perfil de un usuario por su ID
    function getProfile($id)
    {
        $sql = "SELECT * FROM twn_users WHERE id = '$id'";
        $result = $this->conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return 'No existe esa ID en al base de datos';
        }

        $this->closeConnection();
    }

    // Método para obtener la foto de un usuario por su ID
    function getPhoto($id)
    {
        $sql = "SELECT * FROM twn_user_photo WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }

        $stmt->close();
    }

    // Método para obtener el perfil completo (perfil + foto) de un usuario por su ID
    function getFullProfile($id)
    {
        $msg = "";
        $sql = "SELECT u.*, p.link 
        FROM twn_users u 
        LEFT JOIN twn_user_photo p ON u.id = p.user_id 
        WHERE u.id = '$id'";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $userInfo = array();

            while ($row = $result->fetch_assoc()) {
                $userInfo[] = $row;
            }

            return $userInfo;
        } else {
            $msg = 'No se ha encontrado esa ID en la base de datos';
            return $msg;
        }

        $this->closeConnection();
    }

    // Método para obtener el estado de suscripción 'gold' de un usuario por su correo electrónico
    function getGold($id)
    {
        $sql = "SELECT gold_sub FROM twn_users WHERE id = '$id'";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $goldSub = $row['gold_sub'];
            return $goldSub;
        } else {
            return 'No se encuentra el usuario';
        }

        $this->closeConnection();
    }

    // Método para iniciar sesión
    function userLogin($email, $password)
    {
        $password = md5($password);
        $sql = "SELECT * FROM twn_users WHERE email = ? AND password = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ss', $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if ($user['is_banned'] == 1) {
                    $_SESSION["email"] = $email;
                    $_SESSION["user_id"] = $this->getId($email);
                    header("Location: banned.php");
                } elseif ($user['email'] == 'admin@admin.es') {
                    $_SESSION["email"] = $email;
                    $_SESSION["user_id"] = $this->getId($email);
                    header("Location: admin_page.php");
                } else {
                    $_SESSION["email"] = $email;
                    $_SESSION["user_id"] = $this->getId($email);
                    header('Location: home.php');
                    exit();
                }
            } else {
                $error = "Credenciales incorrectas";
                return $error;
            }

            $stmt->close();
        } else {
            die('Error en la consulta: ' . $this->conn->error);
        }

        $this->closeConnection();
    }

    // Método para registrar un nuevo usuario
    function userSignup($nombre, $email, $pw, $pwConfirm)
    {
        $nombre = mysqli_real_escape_string($this->conn, $nombre);
        $email = mysqli_real_escape_string($this->conn, $email);
        $pw = mysqli_real_escape_string($this->conn, $pw);
        $pwConfirm = mysqli_real_escape_string($this->conn, $pwConfirm);
        $msg = "";

        if (strlen($pw) < 8 || !preg_match('/^(?=.*[A-Z])(?=.*\d)/', $pw)) {
            $msg = ['successful' => false, 'msg' => 'La contraseña debe tener al menos 8 caracteres y contener al menos una mayúscula y un número.'];
            return $msg;
        }
        if ($pw !== $pwConfirm) {
            $msg = ['successful' => false, 'msg' => 'Las contraseñas no coinciden.'];
            return $msg;
        }

        $emailExistsQuery = "SELECT * FROM twn_users WHERE email = ?";
        $stmt = $this->conn->prepare($emailExistsQuery);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $emailExistsResult = $stmt->get_result();

        if (mysqli_num_rows($emailExistsResult) > 0) {
            $msg = ['successful' => false, 'msg' => 'El email ya existe en la base de datos.'];
            return $msg;
        } else {
            $hashedPw = md5($pw);
            $insertQuery = "INSERT INTO twn_users (first_name, screen_name, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($insertQuery);
            $stmt->bind_param('ssss', $nombre, $nombre, $email, $hashedPw);
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Registro exitoso
                $msg = ['successful' => true, 'msg' => 'Registro exitoso'];
                return $msg;
            } else {
                $msg = ['successful' => false, 'msg' => "Error al registrar el usuario."];
                return $msg;
            }
        }

        $this->closeConnection();
    }

    public function getRejectedProfiles($userId)
    {
        // Consulta SQL para obtener la lista de IDs de perfiles rechazados o bloqueados por el usuario
        $query = "SELECT user2_id FROM twn_rejects WHERE user1_id = $userId 
                  UNION
                  SELECT user1_id FROM twn_rejects WHERE user2_id = $userId";

        // Ejecutar la consulta SQL y obtener el resultado
        $result = mysqli_query($this->conn, $query);

        // Verificar si se obtuvo un resultado
        if ($result && mysqli_num_rows($result) > 0) {
            // Almacenar los IDs de los perfiles rechazados o bloqueados en un array
            $rejectedProfiles = [];

            // Iterar sobre los resultados y añadir los IDs a la lista
            while ($row = mysqli_fetch_assoc($result)) {
                $rejectedProfiles[] = $row['user2_id'];
            }

            return $rejectedProfiles;
        } else {
            return [];
        }

        $this->closeConnection();
    }

    public function getAcceptedProfiles($userId)
    {
        // Consulta SQL para obtener la lista de IDs de perfiles aceptados por el usuario
        $query = "SELECT user2_id FROM twn_matches WHERE user1_id = $userId";

        // Ejecutar la consulta SQL y obtener el resultado
        $result = mysqli_query($this->conn, $query);

        // Verificar si se obtuvo un resultado
        if ($result && mysqli_num_rows($result) > 0) {
            // Almacenar los IDs de los perfiles aceptados en un array
            $acceptedProfiles = [];

            // Iterar sobre los resultados y añadir los IDs a la lista
            while ($row = mysqli_fetch_assoc($result)) {
                $acceptedProfiles[] = $row['user2_id'];
            }

            return $acceptedProfiles;
        } else {
            return [];
        }

        $this->closeConnection();
    }

    private function hasInterestedIn($userId)
    {
        $interestedInQuery = "SELECT gender_id FROM twn_interested_in WHERE user_id = ?";
        $stmtInterestedIn = $this->conn->prepare($interestedInQuery);
        $stmtInterestedIn->bind_param("i", $userId);
        $stmtInterestedIn->execute();
        $interestedInResult = $stmtInterestedIn->get_result();
        $stmtInterestedIn->close();

        if ($interestedInResult && $interestedInResult->num_rows > 0) {
            $interestedInRow = $interestedInResult->fetch_assoc();
            return $interestedInRow['gender_id'];
        }

        return "";
    }

    private function hasHobbies($userId)
    {
        $hobbiesQuery = "SELECT hobbies FROM twn_users WHERE id = ?";
        $stmtHobbies = $this->conn->prepare($hobbiesQuery);
        $stmtHobbies->bind_param("i", $userId);
        $stmtHobbies->execute();
        $hobbiesResult = $stmtHobbies->get_result();
        $stmtHobbies->close();

        if ($hobbiesResult && $hobbiesResult->num_rows > 0) {
            $hobbiesRow = $hobbiesResult->fetch_assoc();
            return $hobbiesRow['hobbies'];
        }

        return "";
    }

    public function getRandomProfile($userId, $attempt = 0)
    {
        // Obtener los perfiles rechazados o bloqueados por el usuario
        $rejectedProfiles = $this->getRejectedProfiles($userId);

        // Obtener los perfiles aceptados por el usuario
        $acceptedProfiles = $this->getAcceptedProfiles($userId);

        // Verificar si el usuario tiene un registro en la tabla twn_interested_in
        $interestedInGenderId = $this->hasInterestedIn($userId);

        // Verificar si el usuario tiene hobbies
        $userHobbies = $this->hasHobbies($userId);

        // Consultar perfiles aleatorios con filtros
        $randomProfile = $this->getRandomProfileWithFilters($userId, $interestedInGenderId, $userHobbies, $rejectedProfiles, $acceptedProfiles);

        // Si no se encontraron perfiles o todos los perfiles están rechazados/bloqueados, intentar de nuevo hasta 3 veces
        if ($randomProfile === null && $attempt < 3) {
            return $this->getRandomProfile($userId, $attempt + 1);
        }

        // Si no se encontraron perfiles o agotó los intentos, obtener perfiles aleatorios sin filtrar por hobbies
        if ($randomProfile === null) {
            $randomProfile = $this->getRandomProfileWithoutHobbies($userId, $interestedInGenderId);
        }

        return $randomProfile;
    }

    private function getRandomProfileWithFilters($userId, $interestedInGenderId, $userHobbies, $rejectedProfiles, $acceptedProfiles)
    {
        // Construir consulta SQL para obtener perfiles aleatorios con filtros
        $randomProfileQuery = "SELECT u.*, p.link, g.name AS gender_name
                               FROM twn_users u
                               JOIN twn_user_photo p ON u.id = p.user_id
                               JOIN twn_genders g ON u.gender_id = g.id
                               WHERE u.id != ?";

        $params = [$userId];
        $paramTypes = "i";

        // Agregar filtro de género si el usuario tiene registro en twn_interested_in
        if (!empty($interestedInGenderId)) {
            // Verificar si el usuario tiene interés en ambos géneros
            if ($interestedInGenderId == "B") {
                // Mostrar perfiles masculinos (gender_id = M) y femeninos (gender_id = F)
                $randomProfileQuery .= " AND (u.gender_id = 'M' OR u.gender_id = 'F')";
            } else {
                $randomProfileQuery .= " AND u.gender_id = ?";
                $params[] = $interestedInGenderId;
                $paramTypes .= "s";
            }
        }

        // Agregar filtro de hobbies si el usuario tiene hobbies
        if (!empty($userHobbies)) {
            $randomProfileQuery .= " AND (";
            $hobbiesArray = explode(",", $userHobbies);
            $numHobbies = count($hobbiesArray);

            for ($i = 0; $i < $numHobbies; $i++) {
                $cleanedHobby = mb_strtolower(trim($hobbiesArray[$i]));
                $cleanedHobby = str_replace(
                    ['á', 'é', 'í', 'ó', 'ú', 'ü'],
                    ['a', 'e', 'i', 'o', 'u', 'u'],
                    $cleanedHobby
                );

                $randomProfileQuery .= "LOWER(u.hobbies) LIKE ?";
                $params[] = "%" . $cleanedHobby . "%";
                $paramTypes .= "s";

                if ($i < $numHobbies - 1) {
                    $randomProfileQuery .= " OR ";
                }
            }

            $randomProfileQuery .= ")";
        }

        // Ordenar aleatoriamente
        $randomProfileQuery .= " ORDER BY RAND()";

        // Ejecutar la consulta SQL para obtener perfiles aleatorios con filtros
        $stmtRandomProfile = $this->conn->prepare($randomProfileQuery);
        $stmtRandomProfile->bind_param($paramTypes, ...$params);
        $stmtRandomProfile->execute();
        $randomProfileResult = $stmtRandomProfile->get_result();

        // Combinar listas de perfiles rechazados/bloqueados y aceptados
        $blockedAndAcceptedProfiles = array_merge($rejectedProfiles, $acceptedProfiles);

        // Obtener un perfil aleatorio que no esté en la lista de perfiles rechazados/bloqueados y aceptados
        while ($row = $randomProfileResult->fetch_assoc()) {
            if (!in_array($row['id'], $blockedAndAcceptedProfiles)) {
                return $row;
            }
        }

        // Si no se encontró ningún perfil, retornar null
        return null;
    }

    private function getRandomProfileWithoutHobbies($userId, $interestedInGenderId, $attempt = 0)
    {
        // Obtener los perfiles rechazados, bloqueados y aceptados por el usuario
        $rejectedProfiles = $this->getRejectedProfiles($userId);
        $acceptedProfiles = $this->getAcceptedProfiles($userId);

        // Combinar listas de perfiles rechazados/bloqueados y aceptados
        $blockedAndAcceptedProfiles = array_merge($rejectedProfiles, $acceptedProfiles);

        // Consulta SQL para obtener perfiles aleatorios sin coincidencia en hobbies
        $randomProfileQuery = "SELECT u.*, p.link, g.name AS gender_name
                               FROM twn_users u
                               JOIN twn_user_photo p ON u.id = p.user_id
                               JOIN twn_genders g ON u.gender_id = g.id
                               WHERE u.id != ?";

        // Agregar filtro de género si el usuario tiene registro en twn_interested_in
        if (!empty($interestedInGenderId)) {
            $randomProfileQuery .= " AND u.gender_id = ?";
        }

        // Ordenar aleatoriamente
        $randomProfileQuery .= " ORDER BY RAND()";

        // Ejecutar la consulta SQL para obtener perfiles aleatorios sin coincidencia en hobbies
        $stmtRandomProfile = $this->conn->prepare($randomProfileQuery);

        // Vincular los parámetros
        if (!empty($interestedInGenderId)) {
            $stmtRandomProfile->bind_param("is", $userId, $interestedInGenderId);
        } else {
            $stmtRandomProfile->bind_param("i", $userId);
        }

        // Ejecutar la consulta SQL para obtener perfiles aleatorios sin coincidencia en hobbies
        $stmtRandomProfile->execute();

        // Obtener el resultado
        $randomProfileResult = $stmtRandomProfile->get_result();

        // Obtener el número de perfiles encontrados
        $numProfiles = $randomProfileResult->num_rows;

        // Si no se encontraron perfiles o todos los perfiles están rechazados/bloqueados/aceptados, intentar de nuevo hasta 3 veces
        if ($numProfiles == 0 || $numProfiles == count($blockedAndAcceptedProfiles)) {
            if ($attempt < 3) {
                return $this->getRandomProfileWithoutHobbies($userId, $interestedInGenderId, $attempt + 1);
            } else {
                return null; // Si se intentó 3 veces y no se encontró perfil, retornar null
            }
        }

        // Obtener un perfil aleatorio que no esté en la lista de perfiles rechazados/bloqueados/aceptados
        $randomProfile = null;
        while ($row = $randomProfileResult->fetch_assoc()) {
            if (!in_array($row['id'], $blockedAndAcceptedProfiles)) {
                $randomProfile = $row;
                break;
            }
        }

        // Retornar el perfil aleatorio seleccionado
        return $randomProfile;
    }

    // Función para agregar o actualizar un registro de coincidencia en la base de datos
    function addMatch($userId, $profileId)
    {
        // Verificar si ya existe un registro de coincidencia entre los usuarios
        $query = "SELECT id FROM twn_matches WHERE (user1_id = $userId AND user2_id = $profileId)";
        $result = mysqli_query($this->conn, $query);

        // Si el resultado contiene filas, significa que ya existe un registro de coincidencia
        if ($result && mysqli_num_rows($result) > 0) {
            // Actualizar el registro existente en la base de datos
            $updateQuery = "UPDATE twn_matches SET timestamp = CURRENT_TIMESTAMP WHERE (user1_id = $userId AND user2_id = $profileId) OR (user1_id = $profileId AND user2_id = $userId)";
            mysqli_query($this->conn, $updateQuery);

            return;
        }

        // Si no existe un registro de coincidencia, realizar la inserción en la base de datos
        $insertQuery = "INSERT INTO twn_matches (user1_id, user2_id, timestamp) VALUES ($userId, $profileId, CURRENT_TIMESTAMP)";
        mysqli_query($this->conn, $insertQuery);

        $this->closeConnection();
    }


    // Función para agregar o actualizar un registro de rechazo en la base de datos
    function addReject($userId, $profileId)
    {
        // Verificar si ya existe un registro de rechazo entre los usuarios
        $query = "SELECT id FROM twn_rejects WHERE (user1_id = $userId AND user2_id = $profileId) OR (user1_id = $profileId AND user2_id = $userId)";
        $result = mysqli_query($this->conn, $query);

        // Si el resultado contiene filas, significa que ya existe un registro de rechazo
        if ($result && mysqli_num_rows($result) > 0) {
            // Actualizar el registro existente en la base de datos
            $updateQuery = "UPDATE twn_rejects SET timestamp = CURRENT_TIMESTAMP WHERE (user1_id = $userId AND user2_id = $profileId) OR (user1_id = $profileId AND user2_id = $userId)";
            mysqli_query($this->conn, $updateQuery);

            return;
        }

        // Si no existe un registro de rechazo, realizar la inserción en la base de datos
        $insertQuery = "INSERT INTO twn_rejects (user1_id, user2_id, timestamp) VALUES ($userId, $profileId, CURRENT_TIMESTAMP)";
        mysqli_query($this->conn, $insertQuery);

        $this->closeConnection();
    }

    function updateProfile($id, $nombre, $apellido, $nick, $genero, $descripcion, $img, $interested_in, $hobbies)
    {
        $msg = "";
        $rutaImagenAnterior = $this->getImagePath($id);
        // Verificar si la foto de perfil existe para el usuario
        $existingPhoto = $this->getPhoto($id);

        if (!$existingPhoto) {
            // La foto de perfil no existe, realizar una inserción en lugar de una actualización
            $sqlInsertPhoto = "INSERT INTO twn_user_photo (user_id, link) VALUES (?, ?)";
            $stmtInsertPhoto = $this->conn->prepare($sqlInsertPhoto);
            $stmtInsertPhoto->bind_param("is", $id, $img);
            $stmtInsertPhoto->execute();

            if ($stmtInsertPhoto->affected_rows > 0) {
                $msg .= "Inserción de foto de perfil exitosa. ";
            }

            $stmtInsertPhoto->close();
        }

        if (!empty($img) || empty($rutaImagenAnterior)) {
            // Preparar la consulta SQL para actualizar la ruta de la imagen en la tabla twn_user_photo
            $sqlUpdatePhoto = "UPDATE twn_user_photo SET link = ? WHERE user_id = ?";

            // Preparar la declaración para actualizar la ruta de la imagen
            $stmtUpdatePhoto = $this->conn->prepare($sqlUpdatePhoto);

            // Vincular los parámetros para actualizar la ruta de la imagen
            $stmtUpdatePhoto->bind_param("si", $img, $id);

            // Ejecutar la consulta para actualizar la ruta de la imagen
            $stmtUpdatePhoto->execute();

            // Verificar si se realizó alguna actualización en la imagen
            if ($stmtUpdatePhoto->affected_rows > 0) {
                $msg = "Actualización de imagen exitosa. ";
            }

            $stmtUpdatePhoto->close();
        }

        if (empty($descripcion)) {
            // Preparar la consulta SQL con marcadores de posición
            $sql = "UPDATE twn_users SET first_name = ?, last_name = ?, gender_id = ?, screen_name = ?, hobbies = ? WHERE id = ?";

            // Preparar la declaración
            $stmt = $this->conn->prepare($sql);

            // Vincular los parámetros
            $stmt->bind_param("sssssi", $nombre, $apellido, $genero, $nick, $hobbies, $id);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si la actualización fue exitosa
            if ($stmt->affected_rows > 0) {
                $msg .= "Actualización exitosa. ";
            }

            $stmt->close();
        } else {
            // Preparar la consulta SQL con marcadores de posición
            $sql = "UPDATE twn_users SET first_name = ?, last_name = ?, gender_id = ?, description = ?, screen_name = ?, hobbies = ? WHERE id = ?";

            // Preparar la declaración
            $stmt = $this->conn->prepare($sql);

            // Vincular los parámetros
            $stmt->bind_param("ssssssi", $nombre, $apellido, $genero, $descripcion, $nick, $hobbies, $id);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si la actualización fue exitosa
            if ($stmt->affected_rows > 0) {
                $msg .= "Actualización exitosa. ";
            }

            $stmt->close();
        }

        // Verificar si los intereses necesitan actualizarse
        $existingInterestedIn = $this->getInterestedIn($id);
        if ($existingInterestedIn && $existingInterestedIn['gender_id'] != $interested_in) {
            // Actualizar los intereses existentes
            $sqlUpdateInterestedIn = "UPDATE twn_interested_in SET gender_id = ? WHERE user_id = ?";
            $stmtUpdateInterestedIn = $this->conn->prepare($sqlUpdateInterestedIn);
            $stmtUpdateInterestedIn->bind_param("si", $interested_in, $id);
            $stmtUpdateInterestedIn->execute();

            if ($stmtUpdateInterestedIn->affected_rows > 0) {
                $msg .= "Actualización de intereses exitosa. ";
            }

            $stmtUpdateInterestedIn->close();
        } elseif (!$existingInterestedIn) {
            // Insertar nuevos intereses
            $sqlInsertInterestedIn = "INSERT INTO twn_interested_in (user_id, gender_id) VALUES (?, ?)";
            $stmtInsertInterestedIn = $this->conn->prepare($sqlInsertInterestedIn);
            $stmtInsertInterestedIn->bind_param("is", $id, $interested_in);
            $stmtInsertInterestedIn->execute();

            if ($stmtInsertInterestedIn->affected_rows > 0) {
                $msg .= "Inserción de intereses exitosa. ";
            }

            $stmtInsertInterestedIn->close();
        }

        // Verificar si no se realizó ninguna actualización
        if (empty($msg)) {
            $msg = "No se realizaron cambios en el perfil";
        }

        return $msg;
    }


    function getInterestedIn($userId)
    {
        $sql = "SELECT twn_interested_in.gender_id, twn_genders.name AS gender_name
            FROM twn_interested_in
            INNER JOIN twn_genders ON twn_interested_in.gender_id = twn_genders.id
            WHERE twn_interested_in.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result === false) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        $interested_in = $result->fetch_assoc();

        $stmt->close();

        return $interested_in;
    }


    function getImagePath($id)
    {
        // Preparar la consulta SQL para obtener la ruta de la imagen anterior
        $sql = "SELECT link FROM twn_user_photo WHERE user_id = ?";

        // Preparar la declaración
        $stmt = $this->conn->prepare($sql);

        // Vincular el parámetro
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Obtener la fila de resultado
        $row = $result->fetch_assoc();

        // Verificar si la columna 'link' existe en la fila
        if (isset($row['link']) && $row['link'] !== null) {
            $rutaImagenAnterior = $row['link'];
        } else {
            // Manejo de caso cuando no hay foto de perfil
            $rutaImagenAnterior = '';
        }

        // Cerrar la declaración y el resultado
        $stmt->close();
        $result->close();

        // Devolver la ruta de la imagen anterior
        return $rutaImagenAnterior;
    }

    function updatePassword($id, $newPassword)
    {
        $newPassword = md5($newPassword);
        $sql = "UPDATE twn_users SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $newPassword, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return 1;
        } else {
            return 0;
        }

        $this->closeConnection();
    }

    function updateEmail($id, $newEmail)
    {
        $sql = "UPDATE twn_users SET email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $newEmail, $id);
        $stmt->execute();

        // Comprobamos si la actualización fue exitosa
        if ($stmt->affected_rows > 0) {
            return 1;
        } else {
            return 0;
        }

        $this->closeConnection();
    }

    function getLikes($id)
    {
        $sub = $this->getGold($id);
        if ($sub == "1") {
            $sql = "SELECT user_id1 FROM twn_likes WHERE user_id2 = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $results_array = $result->fetch_all(MYSQLI_ASSOC);

            $likes_data = array(); // Array para almacenar los datos de likes

            foreach ($results_array as $row) {
                $liked_user_id = $row['user_id1'];

                // Consulta para obtener la imagen de perfil y el nombre del usuario
                $profile_sql = "SELECT u.first_name, u.last_name, u.gender_id, u.description, p.link FROM twn_users u JOIN twn_user_photo p ON u.id = p.user_id WHERE u.id = ?";
                $profile_stmt = $this->conn->prepare($profile_sql);
                $profile_stmt->bind_param("i", $liked_user_id);
                $profile_stmt->execute();
                $profile_result = $profile_stmt->get_result();
                $profile_data = $profile_result->fetch_assoc();

                // Agregar los datos al array de likes_data
                $likes_data[] = array(
                    'user_id' => $liked_user_id,
                    'profile_image' => $profile_data['link'],
                    'first_name' => $profile_data['first_name'],
                    'last_name' => $profile_data['last_name'],
                    'gender_id' => $profile_data['gender_id'],
                    'description' => $profile_data['description']
                );

                $profile_stmt->close();
            }

            return $likes_data;
        } else {
            $msg = "No estás suscrito";
            return $msg;
        }
    }

    public function checkBan()
    {
        if (empty($_SESSION["email"])) {
            // El usuario no ha iniciado sesión, realiza la redirección apropiada
            header("Location: index.php");
            exit;
        } else {
            $email = $_SESSION["email"];
            $sql = "SELECT * FROM twn_users WHERE email = ?";
            $stmt = $this->conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $user = $result->fetch_assoc();
                    if ($user['is_banned'] == 1) {
                        header("Location: banned.php");
                        exit;
                    }
                } else {
                    // No se encontró un usuario con el correo electrónico dado
                    // Maneja el caso apropiadamente, redirecciona o muestra un mensaje de error
                }
            } else {
                // Error en la consulta preparada
                // Maneja el caso apropiadamente, redirecciona o muestra un mensaje de error
            }
        }
    }

    function getMatches($userId)
    {
        // Realizar la consulta en la base de datos para obtener los matches recíprocos entre dos usuarios
        $sql = "SELECT DISTINCT u.id, u.first_name, u.last_name
        FROM twn_matches AS m
        INNER JOIN twn_users AS u ON (m.user1_id = u.id OR m.user2_id = u.id)
        WHERE ((m.user1_id = ? AND m.user2_id IN (SELECT user1_id FROM twn_matches WHERE user2_id = ?))
        OR (m.user2_id = ? AND m.user1_id IN (SELECT user2_id FROM twn_matches WHERE user1_id = ?)))
        AND u.id != ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiiii", $userId, $userId, $userId, $userId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Iterar sobre los resultados de la consulta y construir un array de nombres y chat IDs
        $matches = array();
        while ($row = $result->fetch_assoc()) {
            $match = array(
                'id' => $row['id'],
                'name' => $row['first_name'] . ' ' . $row['last_name']
            );
            $matches[] = $match;
        }

        // Devolver el array de nombres de los usuarios con match y sus respectivos chat IDs
        return $matches;
    }

    function getChatId($userId, $user2Id)
    {
        // Consulta SQL para buscar el ID del chat entre los dos usuarios
        $sql = "SELECT id FROM twn_chats WHERE (user1_id = ? AND user2_id = ?) OR (user1_id = ? AND user2_id = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $userId, $user2Id, $user2Id, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["id"];
        } else {
            return null; // No se encontró un chat entre los dos usuarios
        }
    }

    // Método para cerrar la conexión a la base de datos
    function closeConnection()
    {
        $this->conn->close();
    }
}
