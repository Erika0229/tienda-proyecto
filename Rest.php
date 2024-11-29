<?php
// Rest.php
// Rest.php

// Incluir el archivo de conexión y funciones de la API
require_once('conexionApi.php');

// Verificar el método de la solicitud HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        // Lógica para manejar solicitudes GET (obtener registros)
        $registros = obtenerRegistros();
        if ($registros) {
            // Convertir el resultado a JSON y devolverlo como respuesta
            echo json_encode($registros);
        } else {
            // Manejar caso de error o registros no encontrados
            http_response_code(404); // Not Found
            echo json_encode(array("mensaje" => "No se encontraron registros."));
        }
        break;



        case 'POST':
            // Lógica para manejar solicitudes GET (obtener registros)
            $registros = obtenerRegistros();
            if ($registros) {
                // Convertir el resultado a JSON y devolverlo como respuesta
                echo json_encode($registros);
            } else {
                // Manejar caso de error o registros no encontrados
                http_response_code(404); // Not Found
                echo json_encode(array("mensaje" => "No se encontraron registros."));
            }
            break;


            case 'PUT':
                // Lógica para manejar solicitudes GET (obtener registros)
                $registros = obtenerRegistros();
                if ($registros) {
                    // Convertir el resultado a JSON y devolverlo como respuesta
                    echo json_encode($registros);
                } else {
                    // Manejar caso de error o registros no encontrados
                    http_response_code(404); // Not Found
                    echo json_encode(array("mensaje" => "No se encontraron registros."));
                }
                break;


                case 'DELETE':
                    // Lógica para manejar solicitudes GET (obtener registros)
                    $registros = obtenerRegistros();
                    if ($registros) {
                        // Convertir el resultado a JSON y devolverlo como respuesta
                        echo json_encode($registros);
                    } else {
                        // Manejar caso de error o registros no encontrados
                        http_response_code(404); // Not Found
                        echo json_encode(array("mensaje" => "No se encontraron registros."));
                    }
                    break;
    // Agregar casos para POST, PUT, DELETE, etc., según tus necesidades
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array("mensaje" => "Método no permitido."));
        break;
        
}

?>
