<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BackupController extends Controller
{

    /**
     * @return void
     */
    public function backup_tables(){
        $this->crearRespaldo_BD_Principal();
        $this->crearRespaldo_Log();
        $this->crearZip();

    }
    /**
     * Funcion para respaldar base de datos principal en un fichero .sql
     * @return void
     */
    public function crearRespaldo_BD_Principal(){

        $datos_base_datos_principal='';
        
        $tables = array();
        $result = DB::select('SHOW TABLES');
        //obtener todos los nombres de las tablas
        foreach($result as $row)
        {
            $tables[] = $row->Tables_in_roles;
        }
        
        //recorrer todas las tablas
        foreach($tables as $table)
        {
            $result = DB::select('SELECT * FROM '.$table);
            $num_fields = count($result);
            
            $row2 = DB::select('SHOW CREATE TABLE '.$table);
            //se hace create de la tabla
            $create = $row2[0];
            $datos_base_datos_principal.= "\n\n".$create->{'Create Table'}.";\n\n";
            
                //aqui recorro los datos de la tabla
                foreach($result as $row)
                {
                    $datos_base_datos_principal.= 'INSERT INTO '.$table.' VALUES(';
                    $j = 0;
                    foreach($row as $row1)
                    {
                        $row1 = addslashes($row1);
                        $row1 = preg_replace("/\n/","\\n",$row1);
                        if (isset($row1)) { $datos_base_datos_principal.= '"'.$row1.'"' ; } else { $datos_base_datos_principal.= '""'; }
                        if ($j<($num_fields-1)) { $datos_base_datos_principal.= ','; }
                        $j+=1;
                    }
                    $datos_base_datos_principal.= ");\n";
                }
            
            $datos_base_datos_principal.="\n\n\n";
        }
        $fecha=date("Y-m-d");

        $handle = fopen('../public/backup/db-backup-'.$fecha.'.sql','w+');
        fwrite($handle,$datos_base_datos_principal);
        fclose($handle);
    }

    /**
     * Funcion para respaldar base de datos LOG en un fichero .sql
     * @return void
     */
    public function crearRespaldo_Log(){


        $datos_base_datos_log='';
        

        $tables = array();
        $result = DB::connection('log')->select('SHOW TABLES');
        
        //obtener los nombres de las tablas 
        foreach($result as $row)
        {
            $tables[] = $row->Tables_in_log_roles;
        }

        foreach($tables as $table)
        {
            $result = DB::connection('log')->select('SELECT * FROM '.$table);
            $num_fields = count($result);


            $row2 = DB::connection('log')->select('SHOW CREATE TABLE '.$table);
            $create = $row2[0];
            $datos_base_datos_log.= "\n\n".$create->{'Create Table'}.";\n\n";
            
           
                foreach($result as $row)
                {
                    $datos_base_datos_log.= 'INSERT INTO '.$table.' VALUES(';
                    $j = 0;
                    foreach($row as $row1)
                    {
                        $row1 = addslashes($row1);
                        $row1 = preg_replace("/\n/","\\n",$row1);
                        if (isset($row1)) { $datos_base_datos_log.= '"'.$row1.'"' ; } else { $datos_base_datos_log.= '""'; }
                        if ($j<($num_fields-1)) { $datos_base_datos_log.= ','; }
                        $j+=1;
                    }
                    $datos_base_datos_log.= ");\n";
                }
            
            $datos_base_datos_log.="\n\n\n";
        }
        $fecha=date("Y-m-d");

        $handle = fopen('../public/backup/log-backup-'.$fecha.'.sql','w+');
        fwrite($handle,$datos_base_datos_log);
        fclose($handle);
    }

    /**
     * Funcion para crear zip con los ficheros de ambas bases de datos
     * 
     * @return void
     */
    public function crearZip(){

        $zip_file = 'backup.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $path = storage_path('../public/backup/');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            if (!$file->isDir()) {
                $filePath  = $file->getRealPath();
                $nombre = basename($filePath);
                $relativePath = 'backup/' . $nombre;
                //agrego el archivo
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
        
        header("Content-disposition: attachment; filename=".$zip_file);

        header("Content-type: MIME");

    
        readfile("../public/".$zip_file);
        
        $fecha=date("Y-m-d");
        
        //Borrar archivos de la carpeta Public
        unlink("../public/backup/db-backup-".$fecha.".sql");
        unlink("../public/backup/log-backup-".$fecha.".sql");
        unlink("../public/".$zip_file); 
    }
}
