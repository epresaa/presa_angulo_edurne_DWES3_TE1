<?php 

// ---------------- LIBRERIA DE CODIGOS HTTP ----------------
// Clase Codes: usada como librerá de códigos HTTP
class Codes {
    // ---------------- ATRIBUTOS ----------------
    public static $codes = [
        // EXITO (2xx)
        200 => "OK",
        201 => "CREATED",
        200 => "OK",
        201 => "CREATED",
        202 => "ACCEPTED",
        204 => "NO CONTENT",
        // ERROR de petición (4xx)
        400 => "BAD REQUEST",
        401 => "UNAUTHORIZED",
        403 => "FORBIDDEN",
        404 => "NOT FOUND",
        // ERROR de servidor (5xx)
        500 => "INTERNAL SERVER ERROR"
    ];

    // ---------------- METODOS ------------------
    // Función estática que da respuestas HTTP
    public static function generarCodigo($buscado) {
        if (array_key_exists($buscado, self::$codes)) {
            $response = [
                'code' => $buscado,
                'message' => self::$codes[$buscado]
            ];
        } else {
            $response = [
                'code' => $buscado,
                'message' => 'Error desconocido'
            ];
        }
        $jsonCode = json_encode($response);
        
        // Mostrar mensaje 
        $stringNum = (string)$response["code"];
        if($stringNum[0] == 2) {
            print_r($response["code"] . ": " . $response["message"]);
        } else {
            print_r("Error " . $response["code"] . ": " . $response["message"]);
        }     
        
        // Devuelve el JSON con code y message
        return $jsonCode;
    }
}

?>
