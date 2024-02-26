<?php include_once '../Controller/monitor.php' ?>
<?php require_once('../include/top.php'); ?>
<?php require_once('../include/table.php'); ?>

<?= top("Monitor People") ?>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    <!-- button for delete multiple -->
    <div class="position-fixed bottom-0 end-0 m-2" id="deleteSelected">
        <button
            class="btn btn-danger"
            id="deleteMultiple"
            data-bs-toggle="modal"
            data-bs-target="#modalDeleteMultiple"
        >
            Delete Multiple
        </button>
    </div>

    <!-- Modal for delete multiple -->
    <div class="modal text-start" id="modalDeleteMultiple" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                    <p>This data cannot be recovered afterwards</p>
                </div>
                <div class="modal-footer">
                    <form method="post" action="<?= $page->getDeleteUrl() ?>">
                        <button 
                            type="submit" 
                            class="btn btn-danger"
                            id="btnConfirmDeleteMultiple"
                        >Yes, Delete It</button>
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <img 
        src="../assets/Star_wars2.svg" 
        class="img-fluid position-fixed top-50 start-50 translate-middle"
        style="opacity: 0.1;"
        alt=""
    >

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
            data-bs-target="#addButton"
            >
            Add a New <?= $page->getPageName() ?>
        </button>
    </div>

        <!-- Add Button Modal -->
        <div class="modal" id="addButton" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add <?= $page->getPageName() ?></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form 
                        action="<?= $page->getCreateUrl() ?>" 
                        method="post"
                        enctype="multipart/form-data"
                    >
                        <div class="modal-body">
                            <?= $page->getForm() ?>
                        </div>

                        <div class="modal-footer">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-primary" type="submit">Create</button>
                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Add Button -->
    <div class="position-absolute start-0 m-2">
        <a href="./api.php">
            <button class="btn btn-primary fw-bold px-5"> SWAPI </button>
        </a>
    </div>

        <div class="d-flex justify-content-center align-items-center gap-2">
            <?php if($prev !== null): ?>
                <a 
                    href="./monitor.php?page=<?= $prev->getPageName() ?>" 
                    class="h-100 link-underline link-underline-opacity-0">
                    <?= $prev->getPageTitle() ?>
                </a>
            <?php endif; ?>
            <h1 class="text-center"><?=  $page->getPageTitle() ?></h1>
            <?php if($next !== null): ?>
                <a 
                    href="./monitor.php?page=<?= $next->getPageName() ?>" 
                    class="h-100 link-underline link-underline-opacity-0">
                    <?= $next->getPageTitle() ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="d-flex justify-content-center">
            <form action="" class="w-50 d-flex justify-content-center gap-2">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        class="form-control text-center"
                        placeholder="Search for name here"
                        id="search"
                    />
                    <button class="btn btn-outline-primary" id="searchBtn">
                        <i class="bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div id="table">

        </div>
</body>

<script>
    const SearchBtnOnLoading = /*html*/`
        <div class="spinner-border text-primary" style="width: 20px; height: 20px;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `;

    const searchBtnDefault = /*html*/`
        <i class="bi-search"></i>
    `;

    const selectId = [];

    function onTableLoaded(){
        $("#searchBtn").html(searchBtnDefault);

        // check all the checkboxes that is listed
        $(".select-multiple").each((i, e) => {
            if(selectId.includes(e.value)){
                e.checked = true;
            }
        })
        
        $(".select-multiple").on("change", (e) => {
            const id = e.target.value;
            if(e.target.checked){
                selectId.push(id);
            } else {
                selectId.splice(selectId.indexOf(id), 1);
            }

            $('#deleteSelected').attr('hidden', selectId.length == 0);
        })
    }

    $(() => {
        let timeout = null;
        $("#table").load("<?= $page->getUrlTable() ?>", '', onTableLoaded);
        $('#deleteSelected').attr('hidden', selectId.length == 0);

        $("#btnConfirmDeleteMultiple").on("click", () => {
            $("#btnConfirmDeleteMultiple").attr("disabled", true);
            $("#btnConfirmDeleteMultiple").html(/*html*/`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Deleting...
            `);

            Promise.all(selectId.map((id) => {
                return $.post("<?= $page->getDeleteUrl() ?>", { deleteId: id });
            })).finally(() => {
                location.reload();
            });
        });

        $("#search").on("input", (e) => {
            // waits for 1 second, if the input stop then it will reload with the new search
            clearTimeout(timeout);
            $("#searchBtn").html(SearchBtnOnLoading);
            timeout = setTimeout(() => {
                $("#table").load(`<?= $page->getUrlTable() ?>&search=${e.target.value}`, "", onTableLoaded);
            }, 1000);
        })
    })

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