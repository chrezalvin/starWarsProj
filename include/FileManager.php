<?php

    class FileManager{
        private string $m_dir = "./";

        /**
         * manages a photo directory
         * @param string $dir the directory of the photos
         */
        function __construct(string $dir){
            $this->m_dir = $dir;
        }

        /**
         * check if the photo is valid
         * @param array $photo the photo array from $_FILES
         * @return bool true if the photo is valid, false otherwise
         */
        public static function isFileValid(array $photo): bool{
            var_dump($photo);
            if(isset($photo['name']) && isset($photo['full_path']) && isset($photo['size']))
                if($photo['name'] !== "" && $photo["full_path"] !== "" && $photo['size'] < 10000000){
                    return true;
                }

            return false;
        }

        /**
         * save the photo to the directory
         * @param array $photo the photo array from $_FILES
         * @param string $name the name of the photo (defaulted to the name of the photo from $_FILES)
         * @return bool true if the photo is successfully saved, false otherwise
         */
        public function savePhoto(array $photo, ?string $name): bool{
            if(!isset($photo['name']) && !isset($photo['data']))
                return false;

            // cancel when file size exceeds 10MB
            if($photo['size'] > 10000000)
                throw new Exception("File size exceeds 10MB");

            $fileExist = $this->getPhoto($name ?? $photo['name']);
            $path = $this->m_dir."/".($name ?? $photo['name']);
            $data = file_get_contents($photo['tmp_name']);
            
            if($fileExist !== null)
                // if exist, then delete the old file first
                $this->deletePhoto($fileExist);

            $res = file_put_contents($path, $data) ? $path : false;

            return $res;
        }

        /**
         * delete the photo from the directory by name, ignoring the file extension
         * @param string $name the name of the photo
         * @return bool true if the photo is successfully deleted, false otherwise
         */
        public function deletePhoto(string $name): bool{
            // ignores the file extension
            $name = explode(".", $name)[0];
            $files = scandir($this->m_dir);

            foreach($files as $file){
                if(explode(".", $file)[0] == $name)
                    return unlink($this->m_dir."/".$file);
            }

            // throw new Error("Photo $name not found 2");
            return false;
        }

        /**
         * get the photo from the directory by name, ignoring the file extension
         * @param string $name the name of the photo
         * @return string|null the photo name or null if the photo is not found
         */
        public function getPhoto(string $name): ?string{
            $files = scandir($this->m_dir);
            $name = explode(".", $name)[0];

            foreach($files as $file)
                if(explode(".", $file)[0] == $name)
                    return $file;
            
            // throw new Exception("Photo $name not found");
            return null;
        }
    }