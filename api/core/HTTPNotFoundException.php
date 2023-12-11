<?php 

// Clase HTTPNotFoundException: clase que maneja la excepción de usar una URL que no existe de forma personalizada 
class HTTPNotFoundException extends Exception {
    // Constructor
    public function __construct($message = 'Ruta no encontrada', $code = 404, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
?>