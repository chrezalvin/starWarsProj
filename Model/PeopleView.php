<?php
    require_once('../Model/People.php');

    class PeopleView extends People{
        private string | null $m_homeworld;
        private int | null $m_homeworldId;

        public static function get_people_view_from_query(array $queryData): PeopleView{
            $people = parent::get_people_from_query($queryData);
            $homeworld = $queryData['homeworld'];
            $homeworldId = $queryData['homeworld_id'];

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
                $homeworld,
                $homeworldId
            );
        }

        function __construct(
            int $id, 
            string $name, 
            int $height, 
            int $mass, 
            string $hair_color, 
            string $skin_color, 
            string $eye_color, 
            string $birth_year, 
            string $gender,
            string | null $homeworld,
            int | null $homeworldId
        )
        {
            parent::__construct($id, $name, $height, $mass, $hair_color, $skin_color, $eye_color, $birth_year, $gender);
            $this->m_homeworld = $homeworld;
            $this->m_homeworldId = $homeworldId;
        }

        // getter
        public function getHomeWorld(){
            return $this->m_homeworld;
        }

        public function getHomeWorldId(){
            return $this->m_homeworldId;
        }
        
    }