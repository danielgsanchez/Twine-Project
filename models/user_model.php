<?php

require_once __DIR__ . "/../models/conn.php";

class UserModel
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
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
    }

    // Método para obtener la foto de un usuario por su ID
    function getPhoto($id)
    {
        $sql = "SELECT * FROM twn_user_photo WHERE user_id = '$id'";
        $result = $this->conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return 'No existe esa ID en al base de datos';
        }
    }

    // Método para obtener el perfil completo (perfil + foto) de un usuario por su ID
    function getFullProfile($id)
    {
        $sql = "SELECT * FROM twn_users JOIN twn_user_photo ON twn_users.id = twn_user_photo.user_id WHERE twn_users.id = '$id'";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $userInfo = array();

            while ($row = $result->fetch_assoc()) {
                $userInfo[] = $row;
            }

            return $userInfo;
        } else {
            return 'No se ha encontrado esa ID en la base de datos';
        }
    }

    // Método para obtener el estado de suscripción 'gold' de un usuario por su correo electrónico
    function getGold($email)
    {
        $sql = "SELECT gold_sub FROM twn_users WHERE email = '$email'";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $goldSub = $row['gold_sub'];
            return $goldSub;
        } else {
            return 'No se encuentra el usuario';
        }
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
                $_SESSION["email"] = $email;
                header('Location: home.php');
                exit();
            } else {
                $error = "Credenciales incorrectas";
                return $error;
            }

            $stmt->close();
        } else {
            die('Error en la consulta: ' . $this->conn->error);
        }
    }

    // Método para registrar un nuevo usuario
    function userSignup($nombre, $email, $pw, $pwConfirm)
    {
        $nombre = mysqli_real_escape_string($this->conn, $nombre);
        $email = mysqli_real_escape_string($this->conn, $email);
        $pw = mysqli_real_escape_string($this->conn, $pw);
        $pwConfirm = mysqli_real_escape_string($this->conn, $pwConfirm);

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
            $insertQuery = "INSERT INTO twn_users (first_name, first_name, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($insertQuery);
            $stmt->bind_param('ssss', $nombre, $nombre, $email, $hashedPw);
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Registro exitoso
                $msg = ['success' => true, 'msg' => 'Registro exitoso'];
                return $msg;
            } else {
                $msg = ['successful' => false, 'msg' => "Error al registrar el usuario."];
                return $msg;
            }
        }
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
    }

    public function getRandomProfile($userId)
    {
        // Obtener los perfiles rechazados o bloqueados por el usuario
        $rejectedProfiles = $this->getRejectedProfiles($userId);

        // Consulta SQL para seleccionar un perfil aleatorio que no haya sido rechazado o bloqueado
        $query = "SELECT u.id, u.first_name, u.gender_id, u.description, p.link
        FROM twn_users u
        INNER JOIN twn_user_photo p ON u.id = p.user_id
        WHERE u.id NOT IN (SELECT user2_id FROM twn_rejects WHERE user1_id = $userId) AND u.id != $userId
        ORDER BY RAND()
        LIMIT 1";

        // Ejecutar la consulta SQL y obtener el resultado
        $result = mysqli_query($this->conn, $query);

        // Verificar si se obtuvo un resultado
        if ($result && mysqli_num_rows($result) > 0) {
            // Obtener el perfil aleatorio
            $row = mysqli_fetch_assoc($result);

            // Verificar si el perfil está en la lista de perfiles rechazados o bloqueados
            $profileId = $row['id'];
            if (in_array($profileId, $rejectedProfiles)) {
                // Si el perfil está rechazado o bloqueado, llamar recursivamente a la función para obtener otro perfil aleatorio
                return $this->getRandomProfile($userId);
            } else {
                // Devolver el perfil aleatorio
                return [
                    'id' => $row['id'],
                    'first_name' => $row['first_name'],
                    'gender_id' => $row['gender_id'],
                    'description' => $row['description'],
                    'link' => $row['link']
                ];
            }
        } else {
            return null;
        }
    }

    // Función para agregar o actualizar un registro de coincidencia en la base de datos
    function addMatch($userId, $profileId)
    {
        // Verificar si ya existe un registro de coincidencia entre los usuarios
        $query = "SELECT id FROM twn_matches WHERE (user1_id = $userId AND user2_id = $profileId) OR (user1_id = $profileId AND user2_id = $userId)";
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
    }

    function updateProfile()
    {
        //
    }

    // Método para cerrar la conexión a la base de datos
    function closeConnection()
    {
        $this->conn->close();
    }
}
