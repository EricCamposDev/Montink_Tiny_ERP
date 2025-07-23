<?php

    namespace App\Core;

    class Notify
    {
        public static function add($notify): void
        {
            if( !isset($_SESSION['notify']) ){
                $_SESSION['notify'] = [];
            }

            $_SESSION['notify'][] = [
                'request' => $notify['request'],
                'statusCode' => $notify['statusCode'],
                'message' => $notify['message'],
                'metadata' => $notify['metadata']
            ];
        }

        public static function show(): void
        {            
            if( !empty($_SESSION['notify']) ){
                foreach($_SESSION['notify'] as $notify){

                    $label = "success";
                    $title = "Sucedido";

                    if( !$notify['request'] ){
                        $label = "warning";
                        $title = "Falha";
                    }
    
                    echo '<div class="alert alert-'.$label.' alert-dismissible fade show" role="alert">
                            <strong>'.$title.'</strong> '.$notify['message'].'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';


                }

                unset($_SESSION['notify']);
            }

        }
    }