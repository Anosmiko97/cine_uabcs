<?php

require "./src/config/database.php";
$config = require __DIR__.'/../config/config.php';
define('BASE_URL', $config['base_url']);
define('ASSETS_URL', $config['assets_url']);
define('SRC_URL', $config['src_url']);
define('CAREERS_CACHE_FILE',  __DIR__ .'/../cache/careers.json');

class Cache {

    private array $data;

    /**
     * Esta clase recibe un array de datos clave valor
     * y los establece como cache
     * @param array $data
     */
    public function __construct(array $data) {
        $this->data = $data;

        $pdo = DB::getPDO();

        try {
            $sql = "SELECT name, abbreviation FROM careers";
            $stmt = $pdo->query($sql);
            $careers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Si no existe, se crea el directorio
            if (!is_dir(__DIR__.'/../cache')) {
                mkdir(__DIR__.'/../cache', 0755, true);
            }

            //Se convierte a JSON y se agrega al archivo
            file_put_contents(CAREERS_CACHE_FILE, json_encode($careers));
        } catch (PDOException $e) {
            error_log("Error al consultar la base de datos: " . $e->getMessage());
        }
    }

    

    function getData()
    {
        $careers = [];

        if (file_exists(CAREERS_CACHE_FILE)) {
            $careers = json_decode(file_get_contents(CAREERS_CACHE_FILE), true);
        }

        if(count($careers) == 0){
            cache_careers();
        }

        return json_decode(file_get_contents(CAREERS_CACHE_FILE), true);
    }

function getCareers() 
{
    $pdo = getPDO();

    try{
        $sql = "SELECT name, abbreviation FROM careers";
        $stmt = $pdo->query($sql);
        $careers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $careers;
    }catch (PDOException $e){
        error_log("Error al consultar la base de datos". $e->getMessage());
        return [];
    }
}

function getCareerData($career = null){

    if($career == null && isset($_GET['career'])){
        $career = filter_input(INPUT_GET, 'career', FILTER_SANITIZE_STRING);
    }

    if ($career === null) {
        return [];
    }

    $pdo = getPDO();

    try {
        $sql = "SELECT * FROM careers WHERE abbreviation = :career LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['career' => $career]);
        $careerData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$careerData) {
            return []; // Carrera no encontrada
        }

        return $careerData;
    } catch (PDOException $e) {
        error_log("Error al consultar la base de datos: " . $e->getMessage());
        return [];
    }

}

    public function setData(array $data): void {
        $this->data = $data;
    }

    public function getCache(): array {
        return $this->data;
    }
}