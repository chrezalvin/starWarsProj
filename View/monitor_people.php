<?php include_once '../Controller/home.php' ?>
<?php require_once('../include/top.php'); ?>
<?php require_once('../include/table.php'); ?>

<?= top("Monitor People") ?>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    <!-- prompt for error -->
    <?php if($error != null): ?>
        <div class="d-flex justify-content-center">
            <div class="alert alert-danger alert-dismissible w-50 my-1">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Add Button -->
    <div class="position-absolute end-0 m-2">
        <button 
            class="btn btn-outline-success fw-bold text-warning"
            data-bs-toggle="modal"
            data-bs-target="#addPerson"
            >
            Add a Person
        </button>
    </div>

        <!-- Add Button -->
        <div class="position-absolute start-0 m-2">
            <a href="./api.php">
                <button class="btn btn-primary fw-bold px-5"> API </button>
            </a>
        </div>

    <!-- modal for adding a person -->
    <div class="modal" id="addPerson" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a Person</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form 
                    action="./add_people.php" 
                    method="post" 
                    enctype="multipart/form-data"
                >
                <div class="modal-body">
                    <?= PeopleView::create_form(null, $allPlanetList) ?>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-success" type="submit">Create</button>
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

        <div class="d-flex justify-content-center align-items-center gap-2">
            <h1 class="text-center">Characters</h1>
            <a href="./monitor_planet.php" class="h-100 link-underline link-underline-opacity-0">Planets</a>
        </div>
        <div class="d-flex justify-content-center">
            <form action="" class="w-50 d-flex justify-content-center gap-2">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        class="form-control text-center"
                        placeholder="Search for name here"
                        value="<?= $search ?? "" ?>"
                    />
                    <button class="btn btn-outline-primary">
                        <i class="bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <?php foreach($people as $person): ?>
                        <div class="modal" id="modal<?= $person->getId() ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmation</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete <?= $person->getName() ?>?</p>
                                        <p>This data cannot be recovered afterwards</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post" action="./delete_people.php">
                                            <input type="hidden" name="deleteId" value="<?= $person->getId() ?>" />
                                            <button type="submit" class="btn btn-danger">Yes, Delete It</button>
                                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <div class="modal" id="modalEdit<?= $person->getId() ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form 
                                        action="./edit_people.php" 
                                        method="post"
                                        enctype="multipart/form-data"
                                    >
                                        <div class="modal-body">
                                            <?= PeopleView::create_form($person, $allPlanetList) ?>
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
                    <?php endforeach; ?>
        <?=
            TableElement::createTable(
                [
                    new TableElement("Name", array_map(function($person){ 
                        ob_start(); ?>

                            <?php if($person->getImgUrl() != null): ?>
                                <img 
                                    src="../public/people/<?= $person->getImgUrl() ?>" 
                                    class="img-fluid object-fit-cover rounded-2"
                                    width="60"
                                    height="80"
                                    alt="<?= $person->getName() ?>'s image" 
                                />
                            <?php endif; ?>
                            <?= $person->getName() ?>

                        <?php 
                            return ob_get_clean();
                    }, $people), "d-flex justify-content-center flex-column align-items-center"),
                    new TableElement("Height", array_map(function($person){ return $person->getHeight(); }, $people)),
                    new TableElement("Mass", array_map(function($person){ return $person->getMass(); }, $people)),
                    new TableElement("Hair Color", array_map(function($person){ return $person->getHairColor(); }, $people)),
                    new TableElement("Skin Color", array_map(function($person){ return $person->getSkinColor(); }, $people)),
                    new TableElement("Eye Color", array_map(function($person){ return $person->getEyeColor(); }, $people)),
                    new TableElement("Birth Year", array_map(function($person){ return $person->getBirthYear(); }, $people)),
                    new TableElement("Gender", array_map(function($person){ return $person->getGender(); }, $people)),
                    new TableElement("Homeworld", array_map(function($person){ return $person->getHomeworld(); }, $people)),
                    new TableElement("Action", array_map(function($person){ 
                        ob_start(); ?>
                            <div class='d-flex justify-content-center gap-1'>
                            <button
                                type='button'
                                data-bs-toggle='modal'
                                data-bs-target='#modalEdit<?= $person->getId() ?>'
                                class='btn btn-warning'
                            >
                                <i class="bi-pen-fill text-dark"></i>
                        </button>
                            <button
                                type='button'
                                data-bs-toggle='modal'
                                data-bs-target='#modal<?= $person->getId() ?>'
                                class='btn btn-danger'
                            >
                                <i class="bi-trash3-fill text-dark"></i>
                            </button>
                    <?php 
                        return ob_get_clean();
                    }, $people))
                ],
                "table w-100 px-4 mt-4",
                "text-center",
                "text-center align-middle"
            );
        ?>
</body>

<script>
    // check for max file size (10mb)
    document.getElementById('image')
        .addEventListener('change', function(){
        if(this.files[0].size > 10000000){
            alert(`File is too big! Maximum file size is 10MB.`);
            this.value = "";
        }
    });
</script>

</html>