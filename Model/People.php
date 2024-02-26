<?php
    require_once('../Model/Base.php');
    require_once('../include/database.php');
    require_once('../Model/Planet.php');

    class People extends Base {
        private ?int $m_height;
        private ?int $m_mass;
        private ?string $m_hair_color;
        private ?string $m_skin_color;
        private ?string $m_eye_color;
        private ?string $m_birth_year;
        private ?string $m_gender;
        private ?string $m_img_url;

        public static function get_people_from_query(array $queryData): ?People{
            $id = $queryData['id'] ?? 0;
            $name = $queryData['name'] ?? 'n/a';
            $height = intval($queryData['height']) === 0 ? null : intval($queryData['height']);
            $mass = intval($queryData['mass']) === 0 ? null : intval($queryData['mass']);
            $hair_color = $queryData['hair_color'] ?? null;
            $skin_color = $queryData['skin_color'] ?? null;
            $eye_color = $queryData['eye_color']  ?? null;
            $birth_year = $queryData['birth_year'] ?? null;
            $gender = $queryData['gender'] ?? null;
            $img_url = $queryData['img_url'] ?? null;

            return new People($id, $name, $height, $mass, $hair_color, $skin_color, $eye_color, $birth_year, $gender, $img_url);
        }

        public static function isValidBirthYear(string $birthYear): bool{
            return preg_match("/\d{1,5}(BBY|ABY)/", $birthYear) === 1;
        }

        protected function __construct(
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
            parent::__construct($id, $name);
            $this->m_height = $height;
            $this->m_mass = $mass;
            $this->m_hair_color = $hair_color;
            $this->m_skin_color = $skin_color;
            $this->m_eye_color = $eye_color;
            $this->m_birth_year = $birth_year;
            $this->m_gender = $gender;
            $this->m_img_url = $img_url;
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

        public function asJson(){
            $json = [];
            $json['id'] = $this->getId();
            $json['name'] = $this->getName();
            $json['height'] = $this->getHeight();
            $json['mass'] = $this->getMass();
            $json['hair_color'] = $this->getHairColor();
            $json['skin_color'] = $this->getSkinColor();
            $json['eye_color'] = $this->getEyeColor();
            $json['birth_year'] = $this->getBirthYear();
            $json['gender'] = $this->getGender();
            $json['img_url'] = $this->getImgUrl();

            return json_encode($json);
        }
    }