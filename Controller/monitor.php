<?php
    require_once('../include/session.php');
    require_once('../include/library.php');

    require_once("../service/PeopleView.php");
    require_once("../service/PlanetView.php");
    require_once("../service/VehicleView.php");

    class Page{
        private string $m_pageTitle;
        private string $m_pageName;
        private string $m_urlTable;
        private string $m_createUrl;
        private string $m_updateUrl;
        private string $m_deleteUrl;
        private string $form;

        public function __construct(
            string $pageTitle,
            string $pageName,
            string $urlTable, 
            string $createUrl, 
            string $updateUrl, 
            string $deleteUrl,
            string $form = ""
        ){
            $this->m_pageTitle = $pageTitle;
            $this->m_pageName = $pageName;
            $this->m_urlTable = $urlTable;
            $this->m_createUrl = $createUrl;
            $this->m_updateUrl = $updateUrl;
            $this->m_deleteUrl = $deleteUrl;
            $this->form = $form;
        }

        public function getPageTitle(): string{
            return $this->m_pageTitle;
        }

        public function getPageName(): string{
            return $this->m_pageName;
        }

        public function getUrlTable(): string{
            return $this->m_urlTable;
        }

        public function getCreateUrl(): string{
            return $this->m_createUrl;
        }

        public function getUpdateUrl(): string{
            return $this->m_updateUrl;
        }

        public function getDeleteUrl(): string{
            return $this->m_deleteUrl;
        }

        public function getForm(): string{
            return $this->form;
        }
    }

    $indexPage = [
        "planet" => new Page(
            "Planets",
            "planet",
            "./table.php?table=planets",
            "./add_planet.php",
            "./edit_planet.php",
            "./delete_planet.php",
            PlanetView::create_form()
        ),
        "vehicle" => new Page(
            "Vehicles",
            "vehicle",
            "./table.php?table=vehicles",
            "./add_vehicle.php",
            "./edit_vehicle.php",
            "./delete_vehicle.php",
            VehicleView::create_form()
        ),
        "people" => new Page(
            "People",
            "people",
            "./table.php?table=people",
            "./add_people.php",
            "./edit_people.php",
            "./delete_people.php",
            PeopleView::create_form()
        ),
    ];

    $indexArrKeys = array_keys($indexPage);

    $getPage = $_GET['page'] ?? "planet";

    // redirect to 404 when page is not found
    if($getPage !== null && !in_array($getPage, $indexArrKeys)){
        header("Location: ./404.php");
        exit;
    }

    $curr = array_search($getPage, $indexArrKeys);
    $page = $indexPage[$indexArrKeys[$curr]];
    $prev = $curr - 1 >= 0 ? $indexPage[$indexArrKeys[$curr - 1]] : null;
    $next = $curr + 1 < count($indexArrKeys) ? $indexPage[$indexArrKeys[$curr + 1]] : null;
    $error = "";