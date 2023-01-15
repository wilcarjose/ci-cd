<?php

namespace Ampliffy\CiCd\Domain\Services;

use Ampliffy\CiCd\Domain\Entities\Repository;

class DependencyTreeService
{
    public static function getTreeByRepository(Repository $repository) : array
    {
        $dependencies = self::getDependencies($repository);

        return [];
    }

    public static function hasDependency(Repository $repository, string $composerName) : bool
    {
        $tree = self::getTreeByRepository($repository);
        
        return true;
    }

    public static function getDependencies($repository, $root = true)
    {
        // se verifica si composer.json fue modificado
            // generado
                // Se obtienen dependencias de almacenamiento
                // retorna las dependencias, // puede ser [] 

            // no generado

        $dependencies = self::makeDependencies($repository, $root);

       // if (empty($dependencies)) {
       //     return [];
        //}

        foreach ($dependencies as $lib) {
            $dependencies = self::getDependencies($lib, false);
        }

        return $dependencies;
    }

    public static function makeDependencies($repository, $root)
    {
        // genera las dependencias del composer.json
        // filtra las librerias que estén incluidas en la lista de directorios
        // guarda las dependencias, en caso de tener alguna, guarda $root
        
        // actializa lib (con status generado)
        // retorna las dependencias, // puede ser []

        return [];
    }

}