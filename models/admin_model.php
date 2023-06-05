<?php

require_once __DIR__ . "/../models/conn.php";

class AdminModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getRegisteredUsers(): int
    {
        $sql = "SELECT COUNT(email) AS registered_users FROM twn_users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['registered_users'];
        } else {
            return 0; // Si ocurre un error o no se obtiene ningún resultado, retorna 0
        }
    }

    public function getGoldUsers(): int
    {
        $sql = "SELECT COUNT(email) AS gold_users FROM twn_users WHERE gold_sub = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['gold_users'];
        } else {
            return 0; // Si ocurre un error o no se obtiene ningún resultado, retorna 0
        }
    }

    public function getUserTickets(): array
    {
        $sql = "SELECT r.id, r.user1_id, u1.first_name AS user1_first_name, u1.last_name AS user1_last_name, u1.email AS user1_email, r.user2_id, u2.first_name AS user2_first_name, u2.last_name AS user2_last_name, u2.email AS user2_email, r.reason
        FROM twn_reports r
        JOIN twn_users u1 ON r.user1_id = u1.id
        JOIN twn_users u2 ON r.user2_id = u2.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $tickets = array();
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }

        return $tickets;
    }

    public function getUsersWithPhotos()
    {
        if ($this->conn) {
            $query = "SELECT u.*, p.link AS photo_link FROM twn_users u LEFT JOIN twn_user_photo p ON u.id = p.user_id";
            $result = $this->conn->query($query);

            if ($result && $result->num_rows > 0) {
                $users = [];
                while ($row = $result->fetch_assoc()) {
                    $user = [
                        'id' => $row['id'],
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'gold_sub' => $row['gold_sub'],
                        'email' => $row['email'],
                        'is_banned' => $row['is_banned'],
                        'photo_link' => $row['photo_link']
                        // Aquí puedes agregar más campos si los necesitas
                    ];
                    $users[] = $user;
                }
                return $users;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function banUser($userId)
    {
        if ($this->conn) {
            // Actualizar el estado del usuario y establecerlo como baneado
            $query = "UPDATE twn_users SET is_banned = 1 WHERE id = $userId";
            $result = $this->conn->query($query);

            if ($result) {
                // La consulta se ejecutó correctamente
                return true;
            } else {
                // Hubo un error en la ejecución de la consulta
                return false;
            }
        } else {
            // No hay una conexión válida a la base de datos
            return false;
        }
    }

    public function unbanUser($userId)
    {
        if ($this->conn) {
            // Actualizar el estado del usuario y establecerlo como baneado
            $query = "UPDATE twn_users SET is_banned = 0 WHERE id = $userId";
            $result = $this->conn->query($query);

            if ($result) {
                // La consulta se ejecutó correctamente
                return true;
            } else {
                // Hubo un error en la ejecución de la consulta
                return false;
            }
        } else {
            // No hay una conexión válida a la base de datos
            return false;
        }
    }

    public function closeConnection(): void
    {
        $this->conn->close();
    }
}
