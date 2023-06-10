<?php

require_once __DIR__ . "/../models/conn.php";

class PaymentClass
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Función para limpiar y sanitizar los datos de entrada
    function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Método para validar un pago utilizando PayPal
    function validatePaypal($email, $user)
    {
        $emailRegex = '/^\S+@\S+\.\S+$/';
        $email = $this->sanitizeInput($email);

        if (preg_match($emailRegex, $email)) {
            if ($this->conn) {
                // Consulta para verificar si el correo electrónico existe y tiene una suscripción de oro
                $stmt = $this->conn->prepare("SELECT gold_sub FROM twn_users WHERE email = ?");

                if ($stmt) {
                    $stmt->bind_param("s", $user);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $goldSub = $row['gold_sub'];

                        if ($goldSub == 0) {
                            // Actualizar el campo 'gold_sub' a 1 para el usuario correspondiente
                            $stmt = $this->conn->prepare("UPDATE twn_users SET gold_sub = 1 WHERE email = ?");

                            if ($stmt) {
                                $stmt->bind_param("s", $user);
                                $stmt->execute();
                                $error = "¡Actualizado con éxito!";
                                return json_encode(["success" => true, "message" => $error]);
                            } else {
                                $error = "Error al realizar el pago.";
                                return json_encode(["success" => false, "message" => $error]);
                            }
                        }
                    } else {
                        $error = "Ese email no se ha encontrado en la base de datos de Twine.";
                        return json_encode(["success" => false, "message" => $error]);
                    }

                    $stmt->close();
                } else {
                    $error = "Error executing SELECT statement.";
                    return json_encode(["success" => false, "message" => $error]);
                }

                $this->conn->close();
            } else {
                $error = "Fallo en la conexión con la base de datos.";
                return json_encode(["success" => false, "message" => $error]);
            }
        } elseif (empty($email)) {
            $error = "El campo email no puede estar vacío.";
            return json_encode(["success" => false, "message" => $error]);
        } else {
            $error = "Error al validar el email. Pruebe de nuevo.";
            return json_encode(["success" => false, "message" => $error]);
        }
        $this->closeConnection();
    }

    // Método para validar un pago utilizando una tarjeta de crédito
    function validateCard($number, $name, $expire, $cvc, $user)
    {
        $cardNumberRegex = '/^\d{16}$/';
        $nameRegex = '/^[a-zA-Z ]+$/';
        $expiryDateRegex = '/^(0[1-9]|1[0-2])\/\d{2}$/';
        $cvcRegex = '/^\d{3}$/';

        $number = $this->sanitizeInput($number);
        $name = $this->sanitizeInput($name);
        $expire = $this->sanitizeInput($expire);
        $cvc = $this->sanitizeInput($cvc);

        // Validar el formato y la validez de los campos de la tarjeta de crédito
        if (empty($number) || !preg_match($cardNumberRegex, $number)) {
            $error = "Número de tarjeta inválido.";
            return json_encode(["success" => false, "message" => $error]);
        }

        if (empty($name) || !preg_match($nameRegex, $name)) {
            $error = "Nombre del titular inválido.";
            return json_encode(["success" => false, "message" => $error]);
        }

        if (empty($expire) || !preg_match($expiryDateRegex, $expire)) {
            $error = "Fecha de expiración inválida.";
            return json_encode(["success" => false, "message" => $error]);
        }

        if (empty($cvc) || !preg_match($cvcRegex, $cvc)) {
            $error = "CVC/CVV inválido.";
            return json_encode(["success" => false, "message" => $error]);
        }

        if ($this->conn) {
            // Consulta para verificar si el correo electrónico existe y tiene una suscripción de oro
            $stmt = $this->conn->prepare("SELECT gold_sub FROM twn_users WHERE email = ?");

            if ($stmt) {
                $stmt->bind_param("s", $user);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $goldSub = $row['gold_sub'];

                    if ($goldSub == 0) {
                        // Actualizar el campo 'gold_sub' a 1 para el usuario correspondiente
                        $stmt = $this->conn->prepare("UPDATE twn_users SET gold_sub = 1 WHERE email = ?");

                        if ($stmt) {
                            $stmt->bind_param("s", $user);
                            $stmt->execute();
                            $error = "¡Actualizado con éxito!";
                            return json_encode(["success" => true, "message" => $error]);
                        } else {
                            $error = "Error al realizar el pago.";
                            return json_encode(["success" => false, "message" => $error]);
                        }
                    } else {
                        $error = "Ya tienes una suscripción a Twine Gold.";
                        return json_encode(["success" => false, "message" => $error]);
                    }
                } else {
                    $error = "Ese email no se ha encontrado en la base de datos de Twine.";
                    return json_encode(["success" => false, "message" => $error]);
                }

                $stmt->close();
            } else {
                $error = "Error al comunicarse con la base de datos.";
                return json_encode(["success" => false, "message" => $error]);
            }

            $this->conn->close();
        } else {
            $error = "Fallo en la conexión con la base de datos.";
            return json_encode(["success" => false, "message" => $error]);
        }

        return json_encode(["success" => true, "message" => "Validación correcta."]);
        $this->closeConnection();
    }

    // Método para cerrar la conexión a la base de datos
    function closeConnection()
    {
        $this->conn->close();
    }
}
