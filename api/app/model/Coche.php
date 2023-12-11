<?php

require_once("Vehiculo.php");

// Clase Coche: clase que extiende Vehiculo e implementa sus métodos
class Coche extends Vehiculo {
    // ---------------- ATRIBUTOS ---------------- 
    private $categoria;

    // ---------------- METODOS ------------------ 
    // Constructor
    function __construct($matricula, $tipo, $marca, $modelo, $anio, $color, $km, $precio, $combustible, $categoria) {
        parent::__construct($matricula, $tipo,  $marca, $modelo, $anio, $color, $km, $precio, $combustible);
        
        // Categoria: validación -> solo 'sedan', 'SUV' o 'compacto'
        $catPermitidas = ["sedan", "suv", "compacto"];
        
        if (in_array(strtolower($categoria), $catPermitidas)) {
            // El valor se encuentra en el array de opciones: se almacena
            $this->categoria = strtolower($categoria);
        
        } else {
            // El valor no es válido: Excepción
            throw new InvalidArgumentException("Error: la categoría de coche debe ser compacto, sedan o SUV");
        }
    }

    // Función toArray: se llama para convertir un objeto Coche en array asociativo
    public function toArray() {
        return array(
            "matricula" => $this->matricula,
            "tipo" => $this->tipo,
            "marca" => $this->marca,
            "modelo" => $this->modelo,
            "anio" => $this->anio,
            "color" => $this->color,
            "km" => $this->km,
            "precio" => $this->precio,
            "combustible" => $this->combustible,
            "categoria" => $this->categoria,
        );
    }

    // Función actualizar: se llama para actualizar campos del objeto Coche 
    public function actualizar($data) {
        // Verifica y actualiza cada campo
        if (isset($data["matricula"])) {
            $this->matricula = $data["matricula"];
        }
        if (isset($data["tipo"])) {
            $this->tipo = $data["tipo"];
        }
        if (isset($data["marca"])) {
            $this->marca = $data["marca"];
        }
        if (isset($data["modelo"])) {
            $this->modelo = $data["modelo"];
        }
        if (isset($data["anio"])) {
            $this->anio = $data["anio"];
        }
        if (isset($data["color"])) {
            $this->color = $data["color"];
        }
        if (isset($data["km"])) {
            $this->km = $data["km"];
        }
        if (isset($data["precio"])) {
            $this->precio = $data["precio"];
        }
        if (isset($data["combustible"])) {
            $this->combustible = $data["combustible"];
        }
        if (isset($data["categoria"])) {
            $this->categoria = $data["categoria"];
        }
    }
}
?>