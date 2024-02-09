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

        public function __construct($data){
            $this->m_id = $data['id'];
            $this->m_name = $data['name'];
            $this->m_height = $data['height'];
            $this->m_mass = $data['mass'];
            $this->m_hair_color = $data['hair_color'];
            $this->m_skin_color = $data['skin_color'];
            $this->m_eye_color = $data['eye_color'];
            $this->m_birth_year = $data['birth_year'];
            $this->m_gender = $data['gender'];
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