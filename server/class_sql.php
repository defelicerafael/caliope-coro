<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

require 'config/config.php';

class Sql
{
    
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $connection;
    public $select;
    public $columns;
    public $hoy;
    public $meses;
    public $mal;
    public $id;
    public $youtube;
    
    
    function getMal(){
        return $this->mal;
    }
    
    function connect(){
        $actual_link = $_SERVER['HTTP_HOST'];
        if($actual_link=='localhost'){
            // CASA  
            $this->servername = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->dbname = "caliope_tigre";
        }else{
        //ONLINE  
        
            $this->servername = DB_HOST;
            $this->username = DB_USER;
            $this->password = DB_PASS;
            $this->dbname = DB_NAME;
        }
     // Create connection
     $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
     $this->connection->query("SET NAMES 'utf8'");
     $this->connection->query("SET sql_safe_updates=1, sql_select_limit=1000, max_join_size=1000000");

    // Check connection
    if ($this->connection->connect_error) {
     die("Connection failed: " . $this->connection->connect_error);
        }

    }
    
    public function endKey( $array ){
        end( $array );
        return key( $array );
    }
    
    public function showColumnNames($tabla){
        $this->connect();
        $sql = "SHOW COLUMNS FROM $tabla";
      //  echo $sql;
        $result = $this->connection->query($sql);
        while($row = $result->fetch_assoc()) {
                    $this->columns[] = $row["Field"];
                }
        return $this->columns;        
    }
   
    public function selectTablaNew($tabla,$filtro,$filtro_por,$orden,$limit){
        $this->connect();
            if($filtro==="no"){
                $sql = "Select * FROM $tabla";
            }else{
                $sql = "SELECT * FROM $tabla WHERE ";
                    foreach($filtro as $dato=>$filtrar){
                        if ($dato === $this->endKey($filtro)) {
                            $sql .= "$dato = '$filtrar'";
                        }else{
                            $sql .= "$dato = '$filtrar' AND ";
                        }
                    }
                }
        $sql .= " ORDER BY $filtro_por $orden ";
        $sql .= " LIMIT $limit"; 
        //echo $sql;    
        $result = $this->connection->query($sql);
        $columnas = $this->showColumnNames($tabla);
        //$rows = $result->num_rows;
            
            while($row = $result->fetch_assoc()) {
                for($i=0;$i<count($columnas);$i++){
                    $dato = $columnas[$i];
                    $array[$dato] = $row[$dato];
                  
                }
                $this->select[] = $array;
            }
            
      return $this->select;  
    }
    
    
    
    
     public function jsonConverter($array){
         $json = json_encode($array);
         echo $json;
         
     }

   
    
   public function edit($tabla,$item,$dato,$where,$id){
        $this->connect();
        
        $sql = "UPDATE $tabla
                SET $item='$dato'
                WHERE $where = '$id'";
        //echo $sql;
        $result = $this->connection->query($sql);
        
            if ($result === TRUE) {
                
                $this->connection->close();  
            } else {
                $this->mal++;
                $this->connection->close();  
            }
                
        }
        
        
        
    public function insert_array($tabla,$array,$display_error){
            $this->connect();
            $todos = ""; 
            $values = "";
            $sql = "INSERT INTO $tabla (id,";
        foreach($array as $dato=>$filtrar){
                        if ($dato === $this->endKey($array)) {
                            $todos .= "$dato";
                            $values .= "'$filtrar'";
                        }else{
                            $sql .= "$dato,";
                            $values .= "'$filtrar',";
                        }
                }
        $sql .= $todos;
        $sql .=") VALUES ('null',";
        $sql .= $values;
        $sql .=")";
        //echo $sql;
        $result = $this->connection->query($sql);
            if ($result === TRUE) {
                $last_id = $this->connection->insert_id;
                $error_message = '0';
                $error_array = array('error' => $error_message,'last_id' => $last_id);
                $error_json = json_encode($error_array);
                if($display_error == 'si'){
                    echo $error_json;
                }
                $this->connection->close();  
            } else {
                $error_message = $sql . "<br>" . $this->connection->error;
                $error_array = array('error' => $error_message);
                $error_json = json_encode($error_array);
                if($display_error == 'si'){
                    echo $error_json;
                }
                $this->connection->close();  
            }
    }

    public function insert_array_sin_cero($tabla,$array){
        $this->connect();
        $todos = ""; 
        $values = "";
        $sql = "INSERT INTO $tabla (id,";
        foreach($array as $dato=>$filtrar){
                    if ($dato === $this->endKey($array)) {
                        $todos .= "$dato";
                        $values .= "'$filtrar'";
                    }else{
                        $sql .= "$dato,";
                        $values .= "'$filtrar',";
                    }
            }
        $sql .= $todos;
        $sql .=") VALUES ('null',";
        $sql .= $values;
        $sql .=")";
        //echo $sql;
         $result = $this->connection->query($sql);
        if ($result === TRUE) {
        //echo "0";
            $this->connection->close();  
        } else {
        //echo "Error: " . $sql . "<br>" . $this->connection->error;
            $this->connection->close();  
        }
    }
        
    public function getlastId($tabla){
        $this->connect();
        $sql = "SELECT id FROM $tabla ORDER BY id DESC LIMIT 1";
        $result = $this->connection->query($sql);
            if ($result->num_rows > 0) {
            // output data of each row
                while($row = $result->fetch_assoc()) {
                    $this->id = $row["id"];
                }
            } else {
        //        echo "0 results";
                $this->connection->close(); 
            }
            return $this->id;
             
    }
    
  
        function delete_foto($tabla,$foto_base,$nombre){
        $this->connect();
        $sql = "DELETE FROM $tabla WHERE $foto_base = '$nombre'";
               
        //echo $sql;
        $result = $this->connection->query($sql); 
        if ($result === TRUE) {
        //echo "Record DELETE successfully $tabla, $nombre";
        } else {
       // echo "Error DELETING record: " . $this->connection->error ."<br>";
        }
        
    }
    function delete($tabla, $item, $dato){
        $this->connect();
        //echo "dato: $dato";
        $sql = "DELETE FROM $tabla WHERE $item = '$dato'";
               
        //echo $sql;
        $result = $this->connection->query($sql); 
            if ($result === TRUE) {
                echo 0;
            } else {
                echo 1;
            }
        }
       
        
        function deleteDirectory($dir) {
            if(!$dh = @opendir($dir)) return;
            while (false !== ($current = readdir($dh))) {
                if($current != '.' && $current != '..') {
                    echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                    if (!@unlink($dir.'/'.$current)) 
                        $this->deleteDirectory($dir.'/'.$current);
                }       
            }
            closedir($dh);
            echo 'Se ha borrado el directorio '.$dir.'<br/>';
            @rmdir($dir);
    }
    
    function fechas30dias($fecha_actual){
        $this->connect();
        $hoy = date('Y/m/d');
        $mes = date("Y/m/d",strtotime($fecha_actual."+ 30 days")); 
        $sql = "SELECT * FROM fechas WHERE fecha BETWEEN '$hoy' AND '$mes' ORDER BY fecha ASC";
       // echo $sql;
        $result = $this->connection->query($sql);
        $columnas = $this->showColumnNames('fechas');
            while($row = $result->fetch_assoc()) {
                for($i=0;$i<count($columnas);$i++){
                    $dato = $columnas[$i];
                    $array[$dato] = $row[$dato];
                }
                $this->select[] = $array;
            }
            
      return $this->select; 
    } 

    function spotify(){
        $this->connect();
        $sql = "SELECT * FROM spotify WHERE mostrar = 'si' ORDER BY id ASC";
        $result = $this->connection->query($sql);
        $columnas = $this->showColumnNames('spotify');
            while($row = $result->fetch_assoc()) {
                for($i=0;$i<count($columnas);$i++){
                    $dato = $columnas[$i];
                    $array[$dato] = $row[$dato];
                }
                $this->select[] = $array;
            }
            
      return $this->select; 
    } 

    function youtube(){
        $this->connect();
        $sql = "SELECT * FROM youtube WHERE mostrar = 'si' ORDER BY id ASC";
        $result = $this->connection->query($sql);
        $columnas = $this->showColumnNames('youtube');
            while($row = $result->fetch_assoc()) {
                for($i=0;$i<count($columnas);$i++){
                    $dato = $columnas[$i];
                    $array[$dato] = $row[$dato];
                }
                $this->youtube[] = $array;
            }
            
      return $this->youtube; 
    } 
    public function excel ($tabla){
        $this->connect();
        $result = $this->connection->query("SHOW COLUMNS FROM $tabla");
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
        $sql = "SELECT * from $tabla ORDER By id LIMIT 9999";
        $result = $this->connection->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->connection->close();
        return $data;
    } 

    function getTableData($tableName,$id,$order,$by) {
        $this->connect();
        // Obtener las columnas de la tabla
        $result = $this->connection->query("SHOW COLUMNS FROM $tableName");
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
        // SI EL ID ES IGUAL A 0 TRAE
        if($id == 0){
            // Crear la consulta preparada
            $query = "SELECT " . implode(",", $columns) . " FROM $tableName order by $by $order LIMIT 9999";
            $stmt = $this->connection->prepare($query);
        }else{
            $query = "SELECT " . implode(",", $columns) . " FROM $tableName WHERE id = ? order by id DESC LIMIT 9999";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("i", $id);
        }
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado en un array
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->connection->close();
        return $data;
    }

    function getTableDataUnique($tableName,$columna) {
        $this->connect();
        // Obtener las columnas de la tabla
        $result = $this->connection->query("SHOW COLUMNS FROM $tableName");
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
        // SI EL ID ES IGUAL A 0 TRAE
        if($this->id == 0){
            // Crear la consulta preparada
            $query = "SELECT " . implode(",", $columns) . " FROM $tableName";
            $stmt = $this->connection->prepare($query);
        }else{
            $query = "SELECT " . implode(",", $columns) . " FROM $tableName WHERE id = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("i", $this->id);
        }
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado en un array
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->connection->close();
        return $data;
    }

    function getTableDataFiltro($tableName,$id,$filtro) {
        $this->connect();
        // Obtener las columnas de la tabla
        $result = $this->connection->query("SHOW COLUMNS FROM $tableName");
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
        // SI EL ID ES IGUAL A 0 TRAE
        if($id == 0){
            // Crear la consulta preparada
            $query = "SELECT " . implode(",", $columns) . " FROM $tableName";
            $stmt = $this->connection->prepare($query);
        }else{
            $query = "SELECT " . implode(",", $columns) . " FROM $tableName WHERE id = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("i", $id);
        }
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado en un array
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->connection->close();
        return $data;
    }
    function getTableDataBusqueda($tableName, $columnsAndWords) {
        $this->connect();
        
        // Obtener las columnas de la tabla
        $result = $this->connection->query("SHOW COLUMNS FROM $tableName");
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
    
        // Crear la cláusula WHERE
        $whereClause = "";
        $values = array();
        $types = "";
        $i = 0;
        foreach ($columnsAndWords as $column => $word) {
            if($i > 0){
                $whereClause .= " AND ";
            }
            $whereClause .= "$column = ?";
            $values[] = $word;
            $types .= "s";  // Asumiendo que todos los parámetros son strings
            $i++;
        }
        if($whereClause != ""){
            $whereClause = " WHERE " . $whereClause;
        }
        
        // Crear la consulta preparada
        $query = "SELECT " . implode(",", $columns) . " FROM $tableName" . $whereClause;
        //echo $query;  // Verificar la consulta
        
        $stmt = $this->connection->prepare($query);
        
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->connection->error);
        }
    
        // Vincular los parámetros de la consulta
        if (!empty($values)) {
            $stmt->bind_param($types, ...$values);  // Usar el operador splat (...) en lugar de call_user_func_array
        }
    
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado en un array
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        $stmt->close();  // Cerrar la sentencia preparada
        $this->connection->close();
        
        return $data;
    }
    
    function getTableDataBusquedaOrderBy($tableName, $columnsAndWords,$order,$by) {
        $this->connect();
        // Obtener las columnas de la tabla
        $result = $this->connection->query("SHOW COLUMNS FROM $tableName");
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
    
        // Crear la cláusula WHERE
        $whereClause = "";
        $values = array();
        $types = "";
        $i = 0;
        foreach ($columnsAndWords as $column => $word) {
            if($i > 0){
                $whereClause .= " AND ";
            }
            $whereClause .= "$column = ?";
            $values[] = $word;
            $types .= "s";
            $i++;
        }
        if($whereClause != ""){
            $whereClause = " WHERE " . $whereClause;
        }
        // Crear la consulta preparada
        $query = "SELECT " . implode(",", $columns) . " FROM $tableName" . $whereClause;
        $query .=' order by '.$order.' '.$by;
        //echo $query;

        $stmt = $this->connection->prepare($query);
    
        // Vincular los parámetros de la consulta
        array_unshift($values, $types);
        call_user_func_array(array($stmt, 'bind_param'), $this->refValues($values));
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado en un array
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->connection->close();
        return $data;
    }

    function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }
    public function doyLaConsulta($consulta){
        $this->connect();
        $sql = $consulta; 
        //echo $sql;
        $result = $this->connection->query($sql);
        $rows = $result->num_rows;
            
            while($row = $result->fetch_assoc()) {
                for($i=0;$i<$rows;$i++){
                    $array = $row;
                }
                $this->select = $array;
            }
        return $this->select;  
    }

    
    function traerModulos($empresa) {
        $this->connect();
        $sql = "SELECT 
                p.id AS postre_id,
                p.empresa AS postre_empresa,
                p.postre_boolean AS postre_boolean,
                p.postre_empresa AS postres,
                p.usar_modulo_fijo AS postre_fijo_boolean,
                p.id_modulo_fijo AS postres_modulos_fijos,
                m.empresa AS modulo_empresa,
                m.modulo_boolean AS modulo_boolean,
                m.modulo_empresa AS modulos,
                b.empresa AS bebida_empresa,
                b.bebidas_boolean AS bebida_boolean,
                b.bebida_empresa AS bebidas
            FROM 
                asignar_postre p
            INNER JOIN 
                asignar_modulo m ON p.empresa = m.empresa
            INNER JOIN 
                asignar_bebidas b ON p.empresa = b.empresa
            WHERE 
                p.empresa = ?";  // Usamos ? como placeholder en lugar de :empresa
        //echo $sql;
        try {
            // Preparamos la consulta usando MySQLi
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            
            // Enlazamos el parámetro
            $stmt->bind_param('s', $empresa);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Obtenemos el resultado
            $result = $stmt->get_result();
            
            $modulos = [];
            
            // Iteramos sobre el resultado
            while ($row = $result->fetch_assoc()) {
                $modulos[] = [
                    'postre_id' => $row['postre_id'],
                    'postre_empresa' => $row['postre_empresa'],
                    'postre_boolean' => $row['postre_boolean'],
                    'postre_fijo_boolean' => $row['postre_fijo_boolean'],
                    'postres' => $row['postres'],
                    'postres_modulos_fijos' => $row['postres_modulos_fijos'],
                    'modulo_empresa' => $row['modulo_empresa'],
                    'modulo_boolean' => $row['modulo_boolean'],
                    'modulos' => $row['modulos'],
                    'bebida_empresa' => $row['bebida_empresa'],
                    'bebida_boolean' => $row['bebida_boolean'],
                    'bebidas' => $row['bebidas']
                ];
            }
            
            // Cerramos el statement
            $stmt->close();
            
            return $modulos;  // Devuelve el array con todos los datos
            
        } catch (Exception $e) {
            error_log('Error en traerModulos: ' . $e->getMessage());
            return null;
        } finally {
            $this->connection = null;
        }
    }
    

    
       
    function filterFilters($filters) {
        $filteredFilters = [];
        
        foreach ($filters as $filter) {
            $filteredFilter = [];
            foreach ($filter as $key => $value) {
                // Solo agregamos el par clave-valor si el valor no es 'todas'
                if (trim($value) !== 'todas') {
                    $filteredFilter[$key] = $value;
                }
            }
            // Solo agregamos el filtro si tiene elementos después de la filtración
            if (!empty($filteredFilter)) {
                $filteredFilters[] = $filteredFilter;
            }
        }
        
        return $filteredFilters;
    }

    function addQuotesToValues($array) {
        foreach ($array as &$subArray) {
            foreach ($subArray as $key => &$value) {
                $value = '"' . $value . '"';
            }
        }
        return $array;
    }
    
    function traerPlatos($modulo){
        $this->connect();
        $sql ="SELECT 
            m.id AS modulo_id,
            m.nombre AS modulo_nombre,
            m.platos AS platos_en_modulo,
            p.id AS plato_id,
            p.nombre AS plato_nombre,
            p.img AS plato_img,
            p.descripcion AS plato_descripcion,
            p.categoria AS plato_categoria,
            p.mostrar AS plato_mostrar,
            p.condicion AS plato_condicion
            p.precio AS plato_precio
            FROM 
                modulos m
            INNER JOIN 
                platos p ON FIND_IN_SET(TRIM(p.nombre), REPLACE(m.platos, ', ', ',')) > 0
            WHERE 
                m.mostrar = 1  -- Filtra solo los módulos activos
                AND p.mostrar = 1  -- Filtra solo los platos activos
                AND m.nombre = ?"; 
        try {
            // Preparamos la consulta usando MySQLi
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            
            // Enlazamos el parámetro
            $stmt->bind_param('s', $modulo);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Obtenemos el resultado
            $result = $stmt->get_result();
            
            $modulos = [];
            
            // Iteramos sobre el resultado
            while ($row = $result->fetch_assoc()) {
                $modulos[] = [
                    'modulo_id' => $row['modulo_id'],
                    'modulo_nombre' => $row['modulo_nombre'],
                    'platos_en_modulo' => $row['platos_en_modulo'],
                    'plato_id' => $row['plato_id'],
                    'plato_nombre' => $row['plato_nombre'],
                    'plato_img' => $row['plato_img'],
                    'plato_descripcion' => $row['plato_descripcion'],
                    'plato_categoria' => $row['plato_categoria'],
                    'plato_mostrar' => $row['plato_mostrar'],
                    'plato_condicion' => $row['plato_condicion'],
                    'plato_precio' => $row['plato_precio']
                ];
            }
            
            // Cerramos el statement
            $stmt->close();
            
            return $modulos;  // Devuelve el array con todos los datos
            
        } catch (Exception $e) {
            error_log('Error en traerModulos: ' . $e->getMessage());
            return null;
        } finally {
            $this->connection = null;
        }        
    }

    function traerPlatosPorNombre($nombre){
        $this->connect();
        $sql ="SELECT 
            *
            FROM 
                platos m
            WHERE 
                nombre = ?"; 
        try {
            // Preparamos la consulta usando MySQLi
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            
            // Enlazamos el parámetro
            $stmt->bind_param('s', $nombre);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Obtenemos el resultado
            $result = $stmt->get_result();
            
            $modulos = [];
            
            // Iteramos sobre el resultado
            while ($row = $result->fetch_assoc()) {
                $modulos = [
                    'plato_id' => $row['id'],
                    'plato_nombre' => $row['nombre'],
                    'plato_img' => $row['img'],
                    'plato_descripcion' => $row['descripcion'],
                    'plato_categoria' => $row['categoria'],
                    'plato_mostrar' => $row['mostrar'],
                    'plato_condicion' => $row['condicion'],
                    'plato_precio' => $row['precio']
                ];
            }
            
            // Cerramos el statement
            $stmt->close();
            
            return $modulos;  // Devuelve el array con todos los datos
            
        } catch (Exception $e) {
            error_log('Error en traerModulos: ' . $e->getMessage());
            return null;
        } finally {
            $this->connection = null;
        }        
    }

    function traerPlatosDeMenuFijo($modulo){
        $this->connect();
        $sql ="SELECT 
            m.nombre AS modulo_nombre,
            m.platos AS platos_en_modulo,
            p.nombre AS plato_nombre,
            p.mostrar
            FROM 
                modulos_fijos m
            INNER JOIN 
                platos p ON FIND_IN_SET(p.nombre, REPLACE(REPLACE(m.platos, '[', ''), ']', '')) > 0 
            WHERE 
                    m.mostrar = 'si'  -- Filtra solo los módulos activos
                AND p.mostrar = 'si'  -- Filtra solo los platos activos
                AND m.nombre = $modulo"; 
                echo $sql;
        try {
            // Preparamos la consulta usando MySQLi
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            
            // Enlazamos el parámetro
            //$stmt->bind_param('s', $modulo);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Obtenemos el resultado
            $result = $stmt->get_result();
            
            $modulos = [];
            
            // Iteramos sobre el resultado
            while ($row = $result->fetch_assoc()) {
                $modulos = [
                    'platos_en_modulo' => $row['platos_en_modulo'],
                ];
            }
            
            // Cerramos el statement
            $stmt->close();
            
            return $modulos;  // Devuelve el array con todos los datos
            
        } catch (Exception $e) {
            error_log('Error en traerModulos: ' . $e->getMessage());
            return null;
        } finally {
            $this->connection = null;
        }        
    }

    function tienePedidos($id){
        $sql = "SELECT 
            m.mes AS mes, 
            m.dia AS dia,
            m.anio AS anio, 
            m.menu AS menu,
            p.plato AS plato,
            p.menu AS modulo,
            p.id AS pedido_id,
            CASE 
                WHEN p.id IS NOT NULL THEN '1' 
                ELSE '0' 
            END AS estado_pedido
            FROM mes m
            LEFT JOIN pedidos p
            ON m.dia = p.dia 
            AND m.mes = p.mes
            AND m.anio = p.anio 
            AND p.id_usuario = ?
            WHERE m.mostrar = 'si'";
            try {
                // Preparamos la consulta usando MySQLi
                $stmt = $this->connection->prepare($sql);
                if (!$stmt) {
                    throw new Exception($this->connection->error);
                }
                
                // Enlazamos el parámetro
                $stmt->bind_param('s', $id);
                
                // Ejecutamos la consulta
                $stmt->execute();
                
                // Obtenemos el resultado
                $result = $stmt->get_result();
                
                $modulos = [];
                
                // Iteramos sobre el resultado
                while ($row = $result->fetch_assoc()) {
                    $modulos[] = [
                        'mes' => $row['mes'],
                        'dia' => $row['dia'],
                        'anio' => $row['anio'],
                        'pedido_id' => $row['pedido_id'],
                        'estado_pedido' => $row['estado_pedido'],
                        'menu' => $row['menu'],
                        'plato' => $row['plato'],
                        'modulo' => $row['modulo'],
                    ];
                }
                
                // Cerramos el statement
                $stmt->close();
                
                return $modulos;  // Devuelve el array con todos los datos
                
            } catch (Exception $e) {
                error_log('Error en traerModulos: ' . $e->getMessage());
                return null;
            } finally {
                $this->connection = null;
            }  
    }

    function traerMesConMasInfo($dia,$mes,$anio) {
        $this->connect();
        $intDia = (int)$dia;
        $sql = "
                SELECT 
                    m.anio, 
                    m.mes, 
                    m.dia, 
                    m.menu, 
                    m.mostrar, 
                    m.semana, 
                    h.id AS plato_id, 
                    h.nombre AS plato_nombre, 
                    h.img AS plato_img, 
                    h.descripcion AS plato_descripcion, 
                    h.categoria AS plato_categoria, 
                    h.mostrar AS plato_mostrar, 
                    h.condicion AS plato_condicion, 
                    h.precio AS plato_precio 
                FROM mes m 
                INNER JOIN platos h 
                    ON m.menu LIKE CONCAT('%[', h.nombre, ']%') 
                WHERE m.mostrar = 'si' 
                    AND m.anio = $anio 
                    AND m.mes = '$mes' 
                    AND m.dia = $intDia";
    
        try {
            // Preparamos la consulta usando MySQLi
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            
            // Ejecutamos la consulta
            $stmt->execute();
    
            // Obtenemos el resultado
            $result = $stmt->get_result();
    
            $modulos = [];
    
            // Iteramos sobre el resultado
            while ($row = $result->fetch_assoc()) {
                $modulos[] = [
                    'anio' => $row['anio'],
                    'mes' => $row['mes'],
                    'dia' => $row['dia'],
                    'menu' => $row['menu'],
                    'mostrar' => $row['mostrar'],
                    'semana' => $row['semana'],
                    'plato_id' => $row['plato_id'],
                    'plato_nombre' => $row['plato_nombre'],
                    'plato_img' => $row['plato_img'],
                    'plato_descripcion' => $row['plato_descripcion'],
                    'plato_categoria' => $row['plato_categoria'],
                    'plato_mostrar' => $row['plato_mostrar'],
                    'plato_condicion' => $row['plato_condicion'],
                    'plato_precio' => $row['plato_precio']
                ];
            }
    
            // Cerramos el statement
            $stmt->close();
    
            return $modulos;  // Devuelve el array con todos los datos
    
        } catch (Exception $e) {
            error_log('Error en traerMesConMasInfo: ' . $e->getMessage());
            return null;
        } finally {
            $this->connection = null;
        }
    }


    function traerPedidosUsuario($id_user){
        $this->connect();
        $sql = 
            "SELECT 
                pp.id_usuario AS usuario_plato, 
                pp.mes AS mes_plato, 
                pp.dia AS dia_plato, 
                pp.anio AS anio_plato, 
                pp.plato AS plato,
                
                po.id_usuario AS usuario_postre, 
                po.mes AS mes_postre, 
                po.dia AS dia_postre, 
                po.anio AS anio_postre, 
                po.plato AS postre, 
                
                pb.id_usuario AS usuario_bebida, 
                pb.mes AS mes_bebida, 
                pb.dia AS dia_bebida, 
                pb.anio AS anio_bebida,
                pb.bebida 
            FROM pedidos pp
            INNER JOIN pedidos_postres po 
                ON pp.id_usuario = po.id_usuario 
                AND pp.dia = po.dia 
                AND pp.mes = po.mes 
                AND pp.anio = po.anio
            INNER JOIN pedidos_bebidas pb 
                ON pp.id_usuario = pb.id_usuario 
                AND pp.dia = pb.dia 
                AND pp.mes = pb.mes 
                AND pp.anio = pb.anio
            WHERE pp.id_usuario = ?";
        //echo $sql;
    
        try {
            // Preparamos la consulta usando MySQLi
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            // Enlazamos el parámetro
            $stmt->bind_param('s', $id_user);
            // Ejecutamos la consulta
            $stmt->execute();
    
            // Obtenemos el resultado
            $result = $stmt->get_result();
    
            $modulos = [];
    
            // Iteramos sobre el resultado
            while ($row = $result->fetch_assoc()) {
                $modulos[] = [
                    'anio' => $row['anio_plato'],
                    'mes' => $row['mes_plato'],
                    'dia' => $row['dia_plato'],
                    'plato' => $row['plato'],
                    'postre' => $row['postre'],
                    'bebida' => $row['bebida'],
                ];
            }
    
            // Cerramos el statement
            $stmt->close();
    
            return $modulos;  // Devuelve el array con todos los datos
    
        } catch (Exception $e) {
            error_log('Error en traerMesConMasInfo: ' . $e->getMessage());
            return null;
        } finally {
            $this->connection = null;
        }

    }

    function traerPedidosUsuarioPorFecha($id_user, $dia, $mes, $anio) {
        $this->connect();
        
        $sql = "
            SELECT 
                pp.anio AS anio,
                pp.mes AS mes,
                pp.dia AS dia,
                pp.plato AS plato,
                NULL AS postre,
                NULL AS bebida
            FROM pedidos pp
            WHERE pp.id_usuario = ? AND pp.dia = ? AND pp.mes = ? AND pp.anio = ?
            
            UNION
            
            SELECT 
                po.anio AS anio,
                po.mes AS mes,
                po.dia AS dia,
                NULL AS plato,
                po.plato AS postre,
                NULL AS bebida
            FROM pedidos_postres po
            WHERE po.id_usuario = ? AND po.dia = ? AND po.mes = ? AND po.anio = ?
            
            UNION
            
            SELECT 
                pb.anio AS anio,
                pb.mes AS mes,
                pb.dia AS dia,
                NULL AS plato,
                NULL AS postre,
                pb.bebida AS bebida
            FROM pedidos_bebidas pb
            WHERE pb.id_usuario = ? AND pb.dia = ? AND pb.mes = ? AND pb.anio = ?
        ";
        
        try {
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            
            // Enlazar parámetros
            $stmt->bind_param(
                'ssssssssssss',
                $id_user, $dia, $mes, $anio,  // Para `pedidos`
                $id_user, $dia, $mes, $anio,  // Para `pedidos_postres`
                $id_user, $dia, $mes, $anio   // Para `pedidos_bebidas`
            );
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Procesar resultados para consolidarlos
            $consolidado = [];
            while ($row = $result->fetch_assoc()) {
                $fechaClave = $row['anio'] . '-' . $row['mes'] . '-' . $row['dia'];
                
                if (!isset($consolidado[$fechaClave])) {
                    $consolidado[$fechaClave] = [
                        'anio' => $row['anio'],
                        'mes' => $row['mes'],
                        'dia' => $row['dia'],
                        'platos' => [],
                        'postres' => [],
                        'bebidas' => [],
                    ];
                }
                
                if ($row['plato']) {
                    $consolidado[$fechaClave]['platos'][] = $row['plato'];
                }
                
                if ($row['postre']) {
                    $consolidado[$fechaClave]['postres'][] = $row['postre'];
                }
                
                if ($row['bebida']) {
                    $consolidado[$fechaClave]['bebidas'][] = $row['bebida'];
                }
            }
            
            $stmt->close();
            
            // Convertimos el array asociativo en uno indexado
            return array_values($consolidado);
            
        } catch (Exception $e) {
            error_log('Error en traerPedidosUsuarioPorFecha: ' . $e->getMessage());
            return null;
        } finally {
            $this->connection = null;
        }
    }

    function traerPlatosDeUnModuloFijo($modulo){
        $this->connect();
        $sql ="SELECT 
            m.nombre AS modulo_nombre,
            m.platos AS platos_en_modulo
            FROM 
                modulos_fijos m
            WHERE 
            m.nombre = ?"; 
            //echo $sql;
        try {
            // Preparamos la consulta usando MySQLi
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            
            // Enlazamos el parámetro
            $stmt->bind_param('s', $modulo);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Obtenemos el resultado
            $result = $stmt->get_result();
            
            $modulos = [];
            
            // Iteramos sobre el resultado
            while ($row = $result->fetch_assoc()) {
                $modulos = [
                    'platos_en_modulo' => $row['platos_en_modulo'],
                ];
            }
            
            // Cerramos el statement
            $stmt->close();
            
            return $modulos;  // Devuelve el array con todos los datos
            
        } catch (Exception $e) {
            error_log('Error en traerModulos: ' . $e->getMessage());
            return null;
        } finally {
            $this->connection = null;
        }        
    }
    
}








