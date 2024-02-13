<?php
    require_once('../include/database.php');

    class People {
        private $m_id;
        private $m_name;
        private $m_height;
        private $m_mass;
        private $m_hair_color;
        private $m_skin_color;
        private $m_eye_color;
        private $m_birth_year;
        private $m_gender;

        public static function get_people_from_query(array $queryData): People{
            $id = $queryData['id'];
            $name = $queryData['name'];
            $height = $queryData['height'];
            $mass = $queryData['mass'];
            $hair_color = $queryData['hair_color'];
            $skin_color = $queryData['skin_color'];
            $eye_color = $queryData['eye_color'];
            $birth_year = $queryData['birth_year'];
            $gender = $queryData['gender'];

            return new People($id, $name, $height, $mass, $hair_color, $skin_color, $eye_color, $birth_year, $gender);
        }

        public function __construct(
            int $id, 
            string $name, 
            int $height, 
            int $mass, 
            string $hair_color, 
            string $skin_color, 
            string $eye_color, 
            string $birth_year, 
            string $gender
        ){
            $this->m_id = $id;
            $this->m_name = $name;
            $this->m_height = $height;
            $this->m_mass = $mass;
            $this->m_hair_color = $hair_color;
            $this->m_skin_color = $skin_color;
            $this->m_eye_color = $eye_color;
            $this->m_birth_year = $birth_year;
            $this->m_gender = $gender;
        }

        // getter
        public function getId(){
            return $this->m_id;
        }

        public function getName(){
            return $this->m_name;
        }

        public function getHeight(){
            return $this->m_height;
        }

        public function getMass(){
            return $this->m_mass;
        }

        public function getHairColor(){
            return $this->m_hair_color;
        }

        public function getSkinColor(){
            return $this->m_skin_color;
        }

        public function getEyeColor(){
            return $this->m_eye_color;
        }

        public function getBirthYear(){
            return $this->m_birth_year;
        }

        public function getGender(){
            return $this->m_gender;
        }

    }