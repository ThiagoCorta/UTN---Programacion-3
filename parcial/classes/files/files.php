<?php 
    class Files{
        private $path;
        private $arrayData;

        public function __construct($path){
            $this->path = $path;
            $this->arrayData = array();
        } 

        public function Save($data, $update = null){
            if(!!isset($datos)) return false;
            $this->arrayData = self::Read($this->path);
            if($update){
                foreach ($this->arrayData as $key => $value) {
                    if($value->id == $data->id){
                        $value->stock = $data->stock;
                    }
                }
            }else{
                array_push($this->arrayData,$data);
            }
            try
            {
                $fileOpen = fopen($this->path,'w');
                $wroteData = fwrite($fileOpen,serialize($this->arrayData));
                fclose($fileOpen);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            return $wroteData > 1 ? true : false;
        }

        public static function Read($path){
            if(!(file_exists($path))) return [];
            $fileSize = 20;
            if(filesize($path) > 1) $fileSize = filesize($path);
            try
            {
                $fileOpen = fopen($path,'r');
                $dataRead = fread($fileOpen,$fileSize);
                fclose($fileOpen);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            return $dataRead == '' ? [] : unserialize($dataRead);
        }

        public function GetData($email, $clave){
            if($email == '' || $clave == '') return null;
            $this->arrayData = self::Read($this->path);
            foreach($this->arrayData as $index => $obj){
                if($obj->email == $email){
                    if($obj->clave == $clave){
                        return $obj;
                    }
                }
            }
            return null;
        }

        public function getAllData(){
            return self::Read($this->path);
        }

        public static function processImage($string,$imagen){
            $arr = explode(".", $imagen['name']);
            $destino = './imagenes/' . $string . '.' . end($arr);
            move_uploaded_file($imagen['tmp_name'],$destino);
            return __DIR__ . $destino;
        }
    }
