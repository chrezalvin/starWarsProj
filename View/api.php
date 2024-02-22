<?php require_once('../Controller/api.php'); ?>
<?php require_once('../include/top.php'); ?>

<?php
    class Test extends SwapiResponseBulk{
        /**
         * @var Base[] $people
         */
        private $m_listLookup;

        /**
         * @param Base[] $listLookup
         */
        public function __construct(SwapiResponseBulk $swapi, $listLookup){
            parent::__construct(
                $swapi->getCount(), 
                $swapi->getNext(), 
                $swapi->getPrevious(), 
                $swapi->getResults()
            );

            $this->m_listLookup = $listLookup;
        }

        public function isAlreadyExistOnList(Base $base){
            foreach($this->m_listLookup as $list){
                if(strtolower($list->getName()) == strtolower($base->getName())){
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * @param Base[] $list
     */
    function createListSection(string $name, $list){
        ob_start(); ?>

            <div class="d-flex flex-column gap-1">
                <h3 class="text-center"><?= $name ?></h3>
                <?php foreach($list as $elem): ?>
                    <div class="d-flex">
                        <p class="fw-bold flex-grow-1"><?= $elem->getName() ?></p>
                        <a href="./api.php?remove<?= $name ?>= <?= $elem->getId() ?>"><button class="btn btn-danger">Remove</button></a>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php
            return ob_get_clean();
    }

?>

<?php
    $collection = [
        'people' => new Test($peopleSwapi, array_merge($peopleList, $db_people)),
        'vehicle' => new Test($vehicleSwapi, array_merge($vehicleList, $db_vehicles)),
        'planet' => new Test($planetSwapi, array_merge($planetList, $db_planets)),
    ];

    $listSections = [
        'People' => $peopleList,
        'Vehicle' => $vehicleList,
        'Planet' => $planetList,
    ];
?>

<?= top("SWAPI") ?>
<body class="min-vh-100 mb-4">
    <img 
        src="../assets/Star_wars2.svg" 
        class="img-fluid position-fixed top-50 start-50 translate-middle z-n1"
        style="opacity: 0.1;"
        alt=""
    >

    <!-- Add Button -->
    <div class="position-absolute end-0 m-2">
        <a href="./monitor_people.php">
            <button class="btn btn-outline-success fw-bold text-warning"> Back to Database </button>
        </a>
    </div>

        <!-- this only opens when at least a list in inserted -->
        <?php if(count($planetList) + count($peopleList) + count($vehicleList) > 0): ?>
        <div class="position-absolute start-0 top-0 m-3">
        <button 
            class="btn btn-primary" 
            data-bs-toggle="collapse"
            data-bs-target="#listCollapsable"
        >Show list</button>

        <div class="collapse bg-light" id="listCollapsable">
            <div class="border border-3 rounded-3 px-2 py-1" style="width: 25vw; z-index: 999;">
                <?php foreach($listSections as $key => $listSection): ?>
                    <?php if(count($listSection) > 0): ?>
                        <?= createListSection($key, $listSection) ?>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div class="d-flex justify-content-center my-3">
                    <a href="./api_add_multiple.php">
                        <button class="btn btn-primary">Add to Database</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Error and Success Message -->
    <?php if($error): ?>
        <div class="d-flex justify-content-center">
            <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="d-flex justify-content-center">
            <div class="alert alert-success alert-dismissible fade show w-50" role="alert">
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center">
        <h1 class="px-2 border border-top-0 border-start-0 border-end-0 border-warning border-4">
            SWAPI
        </h1>
    </div>

    <?php foreach($collection as $key => $list): ?>
        <? if($list === null) continue; ?>
        
        <div class="d-flex justify-content-center my-2">
        <?php if($list->getPrevious() !== null): ?>
            <h2>
                <a href="./api.php?<?= $key ?>Page=<?= $list->getPrevious() ?>" class="link link-underline link-underline-opacity-0"><</a>
            </h2>
        <?php endif; ?>
        <h2 class="px-2 border border-top-0 border-start-0 border-end-0 border-warning border-4">
            <?= ucfirst($key) ?>
        </h2>
        <?php if($list->getNext() !== null): ?>
            <h2>
                <a href="./api.php?<?= $key ?>Page=<?= $list->getNext() ?>" class="link link-underline link-underline-opacity-0">></a>
            </h2>
        <?php endif; ?>
        </div>

        <div class="container-fluid">
        <div class="row gx-3 gy-1 px-2">
            <?php foreach($list->getResults() as $elem): ?>
                <div class="col-lg-3 col-md-6 col-sm-6 d-flex border border-2 rounded-2 px-2 py-1 gap-2 shadow">
                    <div class="flex-grow-1">
                        <h4><?= $elem->getName() ?></h4>
                    </div>
                    <div>
                        <a href="./api.php?add<?= ucfirst($key) ?>=<?= $elem->getId() ?>">
                            <button
                                class="btn btn-success position-relative z-n1 <?= $list->isAlreadyExistOnList($elem) ? "disabled": "" ?>"
                            >
                                Add
                            </button>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</body>
</html>