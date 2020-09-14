<?php

/*
 * Copyright 2008 Wilker Lucio <wilkerlucio@gmail.com>
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License. 
 */

/**
 * Classe simples para acesso a dados
 *
 * @package DB
 * @author Wilker
 */
class DbCommand
{
    private static $DB_HOST = "teste_imip.mysql.dbaas.com.br";
    private static $DB_USER = "teste_imip";
    private static $DB_PASSWORD = "teste123";
    private static $DB_DATABASE = "teste_imip";
    
    public static $connection = null;
    
    /**
     * undocumented function
     *
     * @return void
     * @author Wilker
     **/
    public static function configure($host, $user, $password, $database)
    {
        self::$DB_HOST = $host;
        self::$DB_USER = $user;
        self::$DB_PASSWORD = $password;
        self::$DB_DATABASE = $database;
    }
    
    /**
     * Conectar ao banco de dados
     *
     * @return void
     * @author Wilker
     */
    protected static function connect()
    {
        if(self::$connection !== null) {
            return;
        }
        
        self::$connection = mysqli_connect(self::$DB_HOST, self::$DB_USER, self::$DB_PASSWORD, self::$DB_DATABASE  );
        
        if (!(self::$connection)) {
            throw new DbConnectionException("Unable to connect to database");
        }
        
        //if (!mysqli_select_db(self::$DB_DATABASE, self::$connection)) {
        //   throw new DbConnectionException("Unable to select " . self::$DB_DATABASE . " database");
        //}
        
    }
    
    /**
     * Verificar se existe conex&atilde;o, conectar caso n&atilde;o exista
     *
     * @return void
     * @author Wilker
     */
    protected static function check_connection()
    {
        if(self::$connection === null) {
            self::connect();
        }
    }
    
    /**
     * Efetuar comando SQL
     *
     * @param $sql Consulta SQL
     * @return integer
     * @author Wilker
     */
    protected static function query($sql)
    {
        self::check_connection();
        
        $result = mysqli_query(self::$connection, $sql);
        
        if (!$result) {
            throw new InvalidQueryException("Error executing query: " . mysqli_error(self::$connection) . " at " . $sql);
        }
        
        return $result;
    }
    
    /**
     * Executar comando SQL no banco
     *
     * @param $sql Consulta SQL
     * @return integer
     * @author Wilker
     */
    public static function execute($sql)
    {
        self::query($sql);
        
        return mysqli_affected_rows(self::$connection);
    }
    
    /**
     * Executa uma query e retorna a primeira linha de resultado
     *
     * @param $sql Consulta SQL
     * @return array
     * @author Wilker
     */
    public static function row($sql)
    {
        $result = self::query($sql);
        
        
        return $result->fetch_assoc();
    }
    
    /**
     * Executa a query e retorna a primeira c&eacute;lula do primeiro resultado
     *
     * @param $sql Consulta SQL
     * @return string
     * @author Wilker
     */
    public static function cell($sql)
    {
        $result = self::query($sql);
        
        return $result->fetch_field();
    }
    
    /**
     * Le todos os resultados de uma consulta
     *
     * @param $sql Consulta SQL
     * @return array
     * @author Wilker
     */
    public static function all($sql)
    {
        $result = self::query($sql);
        $data = array();
       
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
         
        //echo '<pre>aqui111';
        //print_r($data);
        //die;
        

        return $data;
    }
    
    /**
     * Retorna a defini&ccedil;&atilde;o de uma tabela
     *
     * @param $table Table name
     * @return array
     * @author Wilker
     */
    public static function table_fields($table)
    {
        $data = self::all("DESCRIBE `$table`");
        $fields = array();
        
        foreach ($data as $field) {
            $fields[] = $field['Field'];
        }
        
        return $fields;
    }
    
    /**
     * Ler o &uacute;ltimo ID inserido na base de dados
     *
     * @return integer
     * @author wilker
     */
    public static function insert_id()
    {
        self::check_connection();

        return mysqli_insert_id(self::$connection);
    }

    /**
     * Irá Escapar  a execução
     *
     * @param $sql Consulta SQL
     * @return scape
     * @author Alberto
     */
    public static function escape_string($string)
    {
        self::check_connection();
        return mysqli_real_escape_string(self::$connection, $string);
    }
} // END class DbCommand

class DbConnectionException extends Exception {}
class InvalidQueryException extends Exception {}
