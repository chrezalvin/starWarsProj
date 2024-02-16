<?php
    require_once('../include/database.php');

    class People {
        private int $m_id;
        private string $m_name;
        private ?int $m_height;
        private ?int $m_mass;
        private ?string $m_hair_color;
        private ?string $m_skin_color;
        private ?string $m_eye_color;
        private ?string $m_birth_year;
        private ?string $m_gender;
        private ?string $m_img_url;

        public static function get_people_from_query(array $queryData): People{
            $id = $queryData['id'] ?? 0;
            $name = $queryData['name'] ?? 'n/a';
            $height = $queryData['height'] ?? null;
            $mass = intval($queryData['mass']) === 0 ? null : intval($queryData['mass']);
            $hair_color = $queryData['hair_color'] ?? null;
            $skin_color = $queryData['skin_color'] ?? null;
            $eye_color = $queryData['eye_color']  ?? null;
            $birth_year = $queryData['birth_year'] ?? null;
            $gender = $queryData['gender'] ?? null;
            $img_url = $queryData['img_url'] ?? null;

            return new People($id, $name, $height, $mass, $hair_color, $skin_color, $eye_color, $birth_year, $gender, $img_url);
        }

        public function __construct(
            int $id, 
            string $name, 
            ?int $height, 
            ?int $mass, 
            ?string $hair_color, 
            ?string $skin_color, 
            ?string $eye_color, 
            ?string $birth_year, 
            ?string $gender,
            ?string $img_url
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
            $this->m_img_url = $img_url;
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

        public function getImgUrl(){
            return $this->m_img_url;
        }
    }