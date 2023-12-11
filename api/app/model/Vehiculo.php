<?php

// CLASE PADRE VEHICULO
// Clase Vehiculo: clase padre abstracta de la cual heredan los 2 tipos de vehiculos que pueden haber en el concesionario
abstract class Vehiculo {
    // ---------------- ATRIBUTOS ----------------
    protected $matricula;
    protected $tipo;
    protected $marca;
    protected $modelo;
    protected $anio;
    protected $km;
    protected $precio;
    protected $color;
    protected $combustible;

    // ---------------- METODOS ------------------
    // Constructor
    function __construct($matricula, $tipo,  $marca, $modelo, $anio, $color, $km, $precio, $combustible) {
        $this->matricula = $matricula;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anio = $anio;
        $this->color = $color;
        $this->km = $km;
        $this->precio = $precio;
        $this->combustible = $combustible;

        // Tipo: validación -> solo 'Coche' o 'Furgoneta'
        $tiposPermitidos = ["coche", "furgoneta"];
        
        if (in_array(strtolower($tipo), $tiposPermitidos)) {
            // El valor se encuentra en el array de opciones: se almacena
            $this->tipo = strtolower($tipo);
        
        } else {
            // El valor no es válido: Excepción
            throw new InvalidArgumentException("Error: el vehiculo solo puede ser Coche o Furgoneta");
        }
    }

    // Función toArray -> se implementa en las clases hijas
    // Se llamará cuando se quiera convertir un objeto hijo de Vehiculo en un array
    abstract public function toArray();

    // Función actualizar -> se implementa en las clases hijas
    // Se llamará cuando se quieran actualizar los valores de un vehículo 
    abstract public function actualizar($data);
}

?>