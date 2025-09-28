<?php
class Sessiones
{
    public static function acceso($rol)
    {
        if(Sessiones::getClave('autenticado'))
        {
            if( Sessiones::getNivel(Sessiones::getClave('rol')) >= Sessiones::getNivel($rol)){
                return true;
            } 
           else
            header("Location:".BASE_URL.'error/error/505');
        }
        else
        header("Location:".BASE_URL.'error/error/504');

            
    }

    public static function getVista($rol)
    {
        if(Sessiones::getClave('autenticado'))
        {
            if( Sessiones::getNivel(Sessiones::getClave('rol')) >= Sessiones::getNivel($rol)){
                return true;
            } 
            else
            return false;
        }
        else
        return false;
    }

    public static function accesoVista($rol){
        if(Sessiones::getClave('rol')==$rol)
        return true;
        else
        return false;
    }

    public static function getNivel($nivel)
    {
        $rol['administrador']=3;
        $rol['doctor']=2;
        $rol['protagonista']=1;
        if(isset($rol[$nivel]))  
            return $rol[$nivel]; 
        else
            return 0;     
    }

    public static function setClave($clave,$valor)
    {
        $_SESSION[$clave]=$valor;
    }

    public static function iniciar()
    {
        session_start();
    }

    public static function getClave($clave)
    {
        if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
        else
            return false;
    }

    public static function salir()
    {
        session_destroy();
    }
}