<?php 
    class Files{
        private $path;
        private $arrayData;

        public function __construct($path){
            $this->path = $path;
            $this->arrayData = array();
        } 

        public function Save($data){
            if(!!isset($datos)) return false;
            $this->arrayData = self::Read($this->path);
            array_push($this->arrayData,$data);
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

        public function GetUser($email, $password){
            if($email == '' || $password == '') return null;
            $this->arrayData = self::Read($this->path);
            foreach($this->arrayData as $index => $obj){
                if($obj->email == $email){
                    if($obj->password == $password){
                        return $obj;
                    }
                }
            }
            return null;
        }

        public function GetUsers($user){
            $this->arrayData = self::Read($this->path);
            if($user->type == 'admin') return $this->arrayData;
            $userTypesArray = array();
            foreach($this->arrayData as $index => $obj){
                if($obj->type == 'user') array_push($userTypesArray, $obj);
            }
            return $userTypesArray;
        }
    }
