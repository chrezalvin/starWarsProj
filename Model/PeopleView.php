<?php
    require_once('../Model/People.php');

    class PeopleView extends People{
        private string | null $m_homeworld;
        private int | null $m_homeworldId;
        private ?string $m_homeworld_img_url; 

        public static function get_people_view_from_query(array $queryData): PeopleView{
            $people = parent::get_people_from_query($queryData);
            $homeworld = $queryData['homeworld'];
            $homeworldId = $queryData['homeworld_id'];
            $homeworld_img_url = $queryData['homeworld_img_url'];

            return new PeopleView(
                $people->getId(), 
                $people->getName(), 
                $people->getHeight(), 
                $people->getMass(), 
                $people->getHairColor(), 
                $people->getSkinColor(), 
                $people->getEyeColor(), 
                $people->getBirthYear(), 
                $people->getGender(),
                $people->getImgUrl(),
                $homeworld,
                $homeworldId,
                $homeworld_img_url
            );
        }

        function __construct(
            int $id, 
            string $name, 
            ?int $height, 
            ?int $mass, 
            ?string $hair_color, 
            ?string $skin_color, 
            ?string $eye_color, 
            ?string $birth_year, 
            ?string $gender,
            ?string $img_url,
            ?string $homeworld,
            ?int $homeworldId,
            ?string $homeworld_img_url
        )
        {
            parent::__construct($id, $name, $height, $mass, $hair_color, $skin_color, $eye_color, $birth_year, $gender, $img_url);
            $this->m_homeworld = $homeworld;
            $this->m_homeworldId = $homeworldId;
            $this->m_homeworld_img_url = $homeworld_img_url;
        }

        // getter
        public function getHomeWorld(){
            return $this->m_homeworld;
        }

        public function getHomeWorldId(){
            return $this->m_homeworldId;
        }

        public function getHomeWorldImgUrl(){
            return $this->m_homeworld_img_url;
        }
        
    }