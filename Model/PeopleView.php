<?php
    require_once('../Model/People.php');

    class PeopleView extends People{
        private string | null $m_homeworld;
        private int | null $m_homeworldId;
        private ?string $m_homeworld_img_url; 

        /**
         * @param PeopleView $people
         * @param Planet[] $allPlanetList
         */
        public static function create_form(PeopleView $people = null, array $allPlanetList = []){
            $id = $people?->getId();
            $name = $people?->getName() ?? "";
            $height = $people?->getHeight() ?? "";
            $mass = $people?->getMass() ?? "";
            $hair_color = $people?->getHairColor() ?? "";
            $skin_color = $people?->getSkinColor() ?? "";
            $eye_color = $people?->getEyeColor() ?? "";
            $birth_year = $people?->getBirthYear() ?? "";

            $birth_year_number = preg_match('/(\d+)/', $birth_year, $matches) ? $matches[0] : '0';
            $birth_year_label = preg_match('/(BBY|ABY)/', $birth_year, $matches) ? $matches[0] : 'BBY';

            $gender = $people?->getGender() ?? '';
            $homeworldId = $people?->getHomeWorldId() ?? 0;

            ob_start(); ?>

            <?php if($id): ?>
                <input type='hidden' name='id' value='<?= $id ?>' />
            <?php endif; ?>

            <div class='form-group'>
                <label for='image'>Insert New Image</label>
                <input 
                    type='file' 
                    name='photo'
                    accept='.png, .jpg, .jpeg'
                    id='image'
                    class='form-control' 
                    size='60'    
                />
            </div>
            <div class='form-group'>
                <label for='name'>Name</label>
                <input type='text' name='name' id='name' class='form-control' value='<?= $name ?? "" ?>' required/>
            </div>
            <div class='form-group'>
                <label for='height'>Height</label>
                <input type='number' name='height' id='height' class='form-control' value='<?= $height ?? "" ?>' min='0'/>
            </div>
            <div class='form-group'>
                <label for='mass'>Mass</label>
                <input type='number' name='mass' id='mass' class='form-control' value='<?= $mass ?? "" ?>' min='0' required/>
            </div>
            <div class='form-group'>
                <label for='hair_color'>Hair Color</label>
                <input type='text' name='hair_color' id='hair_color' class='form-control' value='<?= $hair_color ?? "" ?>' />
            </div>
            <div class='form-group'>
                <label for='skin_color'>Skin Color</label>
                <input type='text' name='skin_color' id='skin_color' class='form-control' value='<?= $skin_color ?? "" ?>' />
            </div>
            <div class='form-group'>
                <label for='eye_color'>Eye Color</label>
                <input type='text' name='eye_color' id='eye_color' class='form-control' value='<?= $eye_color ?? "" ?>' />
            </div>
            <div class='form-group'>
                <label for='birth_year'>Birth Year</label>
                <div class='input-group'>
                    <input type='number' name='birth_year' id='birth_year' class='form-control' value='<?= $birth_year_number ?? "" ?>' min='0' />
                    <div class='input-group-append'>
                        <select name='birth_year_indicator' id='birthyear' class='form-select fw-bold'>
                            <option value='BBY' <?= $birth_year_label === "BBY" ? "selected": "" ?> >BBY</option>
                            <option value='ABY' <?= $birth_year_label === "ABY" ? "selected": "" ?> >ABY</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class='form-group'>
                <label for='homeworld'>Home World</label>
                <div class='input-group'>
                    <select name='homeworld' id='homeworld' class='form-select fw-bold'>
                    <?php foreach($allPlanetList as $planet): ?>
                        <option value="<?= $planet->getId() ?>" <?= $planet->getId() === $homeworldId ? 'selected': '' ?>>
                            <?= $planet->getName() ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class='form-group'>
                <label for='gender'>Gender</label>
                <input type='text' name='gender' id='gender' class='form-control' value="<?= $gender ?? "" ?>" />
            </div>

            <?php
                return ob_get_clean();
        }

        /**
         * @param PeopleView[] $peopleViews
         */
        public static function create_table($peopleViews = []){

        }

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