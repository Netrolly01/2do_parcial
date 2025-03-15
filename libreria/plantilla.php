<?php

class Plantilla
{
    static $instance = null;

    public static function aplicar()
    {
        if (self::$instance == null) {
            self::$instance = new Plantilla();
        }
    }

    public function __construct()
    {
        ?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Empresa XYZ</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                html, body {
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    font-family: Arial, sans-serif;
                    background-color:rgb(49, 49, 49);
                    color: #333;
                }

                .wrapper {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                }

                .header {
                    background-color: #2c3e50;
                    color: white;
                    padding: 15px;
                    text-align: center;
                    font-size: 24px;
                    font-weight: bold;
                }

                .sidebar {
                    width: 250px;
                    height: 100vh;
                    background-color: #34495e;
                    position: fixed;
                    left: 0;
                    top: 0;
                    padding-top: 20px;
                    text-align: center;
                }

                .sidebar a {
                    display: block;
                    color: white;
                    font-size: 1.4em;
                    text-decoration: none;
                    margin: 15px 0;
                    padding: 10px;
                    font-weight: bold;
                }

                .sidebar a:hover {
                    background-color: #1abc9c;
                }

                .main-content {
                    margin-left: 260px;
                    padding: 20px;
                    flex: 1;
                }

                .container {
                    width: 100%;
                    max-width: 900px;
                    margin: auto;
                    padding: 40px;
                    background-color: rgba(255, 255, 255, 0.9);
                    border-radius: 10px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                    border: 3px solid #34495e;
                }

                form {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                }

                label {
                    font-size: 1.2em;
                    font-weight: bold;
                    color: #34495e;
                }

                input {
                    padding: 10px;
                    font-size: 1em;
                    border: 2px solid #34495e;
                    border-radius: 5px;
                    width: 100%;
                }

                .boton {
                    background-color: #1abc9c;
                    color: white;
                    padding: 15px;
                    font-size: 1.3em;
                    border-radius: 10px;
                    cursor: pointer;
                    text-align: center;
                    border: none;
                }

                .boton:hover {
                    background-color: #16a085;
                    color: white;
                }
                
                .tabla {
                     width: 100%;
                     border-collapse: separate;
                     border-spacing: 0 10px;
                    }
                    
                .tabla th, .tabla td {
                        padding: 10px 15px;
                        text-align: left;
                        border-bottom: 1px solid #ddd;
                    }

                .btn-accion {
                        display: inline-block;
                        padding: 10px 15px;
                        border: none;
                        border-radius: 8px;
                        cursor: pointer;
                        margin-right: 8px;
                        font-size: 14px;
                        font-weight: bold;
                        text-decoration: none;
                        text-align: center;
                        transition: background-color 0.3s ease, transform 0.2s ease;
                     }

   
                     .btn-editar {
                        background-color: #4CAF50;
                        color: white;
                    }
   
                    .btn-editar:hover {
                        background-color: #388e3c;
                        transform: scale(1.05);
                    }
   
                    .btn-eliminar {
                        background-color: #f44336;
                        color: white;
                    }
   
                    .btn-eliminar:hover {
                        background-color: #d32f2f;
                        transform: scale(1.05);
                    }

   
                 .footer {
                    text-align: center;
                    font-size: 1.2em;
                    border-top: 3px solid #34495e;
                    padding: 10px;
                    background-color: #2c3e50;
                    color: white;
                    margin-top: auto;
                }
            </style>
        </head>

        <body>
            <div class="header">Empresa XYZ</div>
           <div class="sidebar">
                <a href="index.php">Inicio</a>
                <a href="registro.php">Registro</a>
                <a href="listadeVis.php">Lista de Visitantes</a>
            </div>
            
            <div class="wrapper">
                <div class="main-content">
                    <div class="container">
        <?php
    }

    public function __destruct()
    {
        ?>
                    </div>
                </div>
                
                <div class="footer">
                    <p>© 2025 Empresa XYZ - Netanel de Jesus 20231103.</p>
                </div>
            </div>
        </body>

        </html>
        <?php
    }
}
