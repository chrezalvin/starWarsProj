<?php
    require_once('../service/PeopleView.php');
    require_once('../service/PlanetView.php');
    require_once('../service/VehicleView.php');
    require_once('../service/Planet.php');
    require_once('../include/table.php');

    $tableName = $_REQUEST['table'];
    $search = $_GET['search'] ?? null;

    function createImgIfExist(string $name, ?string $imgUrl = null){
        ob_start(); ?>
            <?php if(!is_null($imgUrl)): ?>
                <img 
                    src="<?= $imgUrl ?>" 
                    class="img-fluid object-fit-cover rounded-2"
                    width="60"
                    height="80"
                    alt="<?= $name ?>'s image" 
                />
            <?php endif; ?>
            <p class="text-dark"><?= $name ?></p>
        <?php 
            return ob_get_clean();
    }

    function formatNumberIfExist(?int $number){
        return is_null($number) ? "n/a" : number_format($number);
    }

    function createDeleteAction(Base $base, string $deleteUrl, bool $disabled = false){
        ob_start(); ?>
            <?php if(!$disabled): ?>
                <div class="modal text-start" id="modal<?= $base->getId() ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmation</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <?= $base->getName() ?>?</p>
                                <p>This data cannot be recovered afterwards</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="<?= $deleteUrl ?>">
                                    <input type="hidden" name="deleteId" value="<?= $base->getId() ?>" />
                                    <button type="submit" class="btn btn-danger">Yes, Delete It</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <button
                type='button'
                data-bs-toggle='modal'
                data-bs-target='#modal<?= $base->getId() ?>'
                class='btn btn-danger'
                <?= $disabled ? "disabled" : "" ?>
            >
                <i class="bi-trash3-fill text-dark"></i>
            </button>
        <?php return ob_get_clean();
    }

    function createEditAction(Base $base, string $form, string $editUrl){
        ?>
            <div class="modal text-start" id="modalEdit<?= $base->getId() ?>" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form 
                            action="<?= $editUrl ?>" 
                            method="post"
                            enctype="multipart/form-data"
                        >
                            <div class="modal-body">
                                <?= $form ?>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button
                type='button'
                data-bs-toggle='modal'
                data-bs-target='#modalEdit<?= $base->getId() ?>'
                class='btn btn-warning'
            >
                <i class="bi-pen-fill text-dark"></i>
            </button>
        <?php
    }

    function inputCheckbox(Base $base){
        ob_start(); ?>
             <input 
                class="form-check-input mt-0" 
                type="checkbox" 
                value="<?= $base->getId() ?>"
                aria-label="Checkbox for following text input"
            >
        <?php
            return ob_get_clean();
    }

    /**
     * @template T
     * @param T[] $arr
     * @param (Callable(T): string)[] $elements
     * @return TableElement[]
     */
    function generateTableElements(array $elements, array $arr){
        $tableElements = [];
        foreach($elements as $key => $fn)
            $tableElements[] = new TableElement($key, array_map($fn, $arr), "");

        return $tableElements;
    }

    switch($tableName){
        case "people":
            $data = TableElement::createTable(
                generateTableElements([
                    "Name" => fn(PeopleView $person) => createImgIfExist(
                            $person->getName(), 
                            is_null($person->getImgUrl()) ? null : "../public/people/" . $person->getImgUrl()
                    ),
                    "Height" => fn(PeopleView $person) => formatNumberIfExist($person->getHeight()),
                    "Mass" => fn(PeopleView $person) => formatNumberIfExist($person->getMass()),
                    "Hair Color" => fn(PeopleView $person) => $person->getHairColor(),
                    "Skin Color" => fn(PeopleView $person) => $person->getSkinColor(),
                    "Eye Color" => fn(PeopleView $person) => $person->getEyeColor(),
                    "Birth Year" => fn(PeopleView $person) => $person->getBirthYear(),
                    "Gender" => fn(PeopleView $person) => $person->getGender(),
                    "Homeworld" => fn(PeopleView $person) => $person->getHomeworld(),
                    "Action" => function(PeopleView $person){ 
                            ob_start(); ?>
                                <div class="d-flex justify-content-center flex-column gap-1">
                                    <div class='d-flex justify-content-center gap-1'>
                                        <input type="checkbox" class="select-multiple btn-check" id="btncheck<?= $person->getId() ?>" value="<?= $person->getId() ?>" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck<?= $person->getId() ?>">
                                            <i class="bi-check"></i>
                                        </label>
                                    </div>
                                    <div class='d-flex justify-content-center gap-1'>
                                        <?= createDeleteAction($person, "./delete_people.php") ?>
                                        <?= createEditAction($person, PeopleView::create_form($person), "./edit_people.php") ?>
                                    </div>
                                </div>
                        <?php 
                            return ob_get_clean();
                        }
                ], PeopleViewDatabase::get_view($search)),
                "table w-100 px-4 mt-4",
                "text-center",
                "text-center align-middle"
            );
            break;
        case "planets":
            $data = TableElement::createTable(
                generateTableElements([
                    "Name" => fn(PlanetView $planet) => createImgIfExist(
                            $planet->getName(), 
                            is_null($planet->getImgUrl()) ? null : "../public/planet/" . $planet->getImgUrl()
                    ),
                    "Rotation Period" => fn(PlanetView $planet) => formatNumberIfExist($planet->getRotationPeriod()),
                    "Orbital Period" => fn(PlanetView $planet) => formatNumberIfExist($planet->getOrbitalPeriod()),
                    "Diameter" => fn(PlanetView $planet) => formatNumberIfExist($planet->getDiameter()),
                    "Climate" => fn(PlanetView $planet) => $planet->getClimate(),
                    "Gravity" => fn(PlanetView $planet) => $planet->getGravity(),
                    "Terrain" => fn(PlanetView $planet) => $planet->getTerrain(),
                    "Surface Water" => fn(PlanetView $planet) => formatNumberIfExist($planet->getSurfaceWater()),
                    "Population" => fn(PlanetView $planet) => formatNumberIfExist($planet->getPopulation()),
                    "Action" => function(PlanetView $planet){ 
                            ob_start(); ?>
                                <div class="d-flex justify-content-center flex-column gap-1">
                                    <div class='d-flex justify-content-center gap-1'>
                                        <input type="checkbox" class="select-multiple btn-check" id="btncheck<?= $planet->getId() ?>" value="<?= $planet->getId() ?>" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck<?= $planet->getId() ?>">
                                            <i class="bi-check"></i>
                                        </label>
                                    </div>
                                    <div class='d-flex justify-content-center gap-1'>
                                        <?= createDeleteAction($planet, "./delete_planet.php", $planet->isDeletable())?>
                                        <?= createEditAction($planet, PlanetView::create_form($planet), "./edit_planet.php") ?>
                                    </div>
                                </div>
                        <?php 
                            return ob_get_clean();
                        }
                ], PlanetViewDatabase::get_view($search)),
                "table w-100 px-4 mt-4",
                "text-center",
                "text-center align-middle"
            );
            break;
        case "vehicles":
            $data = TableElement::createTable(
                generateTableElements([
                    "Name" => fn(VehicleView $vehicle) => createImgIfExist(
                            $vehicle->getName(), 
                            is_null($vehicle->getImgUrl()) ? null : "../public/vehicle/" . $vehicle->getImgUrl()
                    ),
                    "Model" => fn(VehicleView $vehicle) => $vehicle->getModel(),
                    "Manufacturer" => fn(VehicleView $vehicle) => $vehicle->getManufacturer(),
                    "Cost In Credits" => fn(VehicleView $vehicle) => $vehicle->getCostInCredits(),
                    "Length" => fn(VehicleView $vehicle) => $vehicle->getLength(),
                    "Max Atmosphering Speed" => fn(VehicleView $vehicle) => formatNumberIfExist($vehicle->getMaxAtmospheringSpeed()),
                    "Crew" => fn(VehicleView $vehicle) => formatNumberIfExist($vehicle->getCrew()),
                    "Passengers" => fn(VehicleView $vehicle) => formatNumberIfExist($vehicle->getPassengers()),
                    "Cargo Capacity" => fn(VehicleView $vehicle) => formatNumberIfExist($vehicle->getCargoCapacity()),
                    "Consumables" => fn(VehicleView $vehicle) => $vehicle->getConsumables(),
                    "Vehicle Class" => fn(VehicleView $vehicle) => $vehicle->getVehicleClass(),
                    "Action" => function(VehicleView $vehicle){ 
                            ob_start(); ?>
                                <div class="d-flex justify-content-center flex-column gap-1">
                                    <div class='d-flex justify-content-center gap-1'>
                                        <input type="checkbox" class="select-multiple btn-check" id="btncheck<?= $vehicle->getId() ?>" value="<?= $vehicle->getId() ?>" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck<?= $vehicle->getId() ?>">
                                            <i class="bi-check"></i>
                                        </label>
                                    </div>
                                    <div class='d-flex justify-content-center gap-1'>
                                        <?= createDeleteAction($vehicle, "./delete_vehicle.php") ?>
                                        <?= createEditAction($vehicle, VehicleView::create_form($vehicle), "./edit_vehicle.php") ?>
                                    </div>
                                </div>
                        <?php 
                            return ob_get_clean();
                        }
                ], VehicleViewDatabase::get_view($search)),
                "table w-100 px-4 mt-4",
                "text-center",
                "text-center align-middle"
            );
            break;
        default:
            $data = "";
    }
    