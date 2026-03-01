<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.8/af-2.7.0/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (
        !isset($_SESSION['logged_in']) ||
        $_SESSION['logged_in'] !== true ||
        !isset($_SESSION['access']) ||
        (int)$_SESSION['access'] !== 3
    ) {
        header("Location: login.php");
        exit;
    }
    $id = $_SESSION['user_id'] ?? null;
    $email = $_SESSION['email'] ?? null;
    $username = $_SESSION['username'] ?? null;

    ?>



</head>
<style>
    .dt-buttons {
        width: auto;
    }

    .buttons-excel {
        background: rgb(0, 154, 16);
        width: 100px;
        margin: 10px 10px;
    }

    .buttons-print {
        background: rgba(1, 77, 94, 0.52);
        width: 100px;
        margin: 10px 10px;
    }

    .buttons-colvis {
        width: auto;
        height: auto;
        margin: 10px 10px;
    }

    .buttons-pdf {
        background: rgb(202, 8, 8);
        width: 100px;
        margin: 10px 10px;
    }

    .add_medicine {
        background: rgb(9, 93, 220);
        color: white;
        width: 100px;
        margin: 10px 10px;
    }

    .add_medicine:hover {
        background: rgb(0, 32, 77);
    }

    .buttons-excel:hover {
        background: rgb(0, 77, 8);
    }

    .buttons-print:hover {
        background: rgb(0, 54, 69);
    }

    .buttons-pdf:hover {
        background: rgb(153, 6, 6);
    }

    .dropdown {
        position: relative;
        display: inline-block;
        z-index: 100;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        left: 100%;
        background-color: #fff;
        border: 1px solid var(--bs-info);
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        padding: 12px 16px;
        z-index: 100;
    }

    .dropdown-content::before {
        content: "";
        position: absolute;
        top: 40%;
        z-index: -10;
        left: -5%;
        transform: translate(-50%, -50%) rotate(45deg);
        height: 15px;
        width: 15px;
        background: var(--bs-info);
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-item:hover {
        color: var(--bs-info);
    }

    .dt-search {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    div.dt-container .dt-search input {
        outline: none;
    }

    div.dt-container .dt-search input:focus {
        border: 1px solid var(--bs-info);
    }

    div.dtsb-searchBuilder button.dtsb-button {
        background: cadetblue;
        color: #fff;
    }

    div.dtsb-searchBuilder div.dtsb-group div.dtsb-logicContainer button.dtsb-logic {
        color: #000;
    }

    div.dt-length {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    td {
        font-size: 12px;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control::before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control::before {
        margin-right: .5em;
        display: inline-block;
        content: "~";
        border: 0;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr.dtr-expanded>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr.dtr-expanded>th.dtr-control:before {
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
        background-color: var(--bs-info);
        border: .15em solid #fff;
        border-radius: 1em;
        box-shadow: 0 0 .2em #444;
        color: #fff;
        content: "~";
        display: block;
        font-family: Courier New, Courier, monospace;
        height: 1em;
        width: 1em;
        position: absolute;
        text-align: center;
        top: 50%;
        left: 5px;
        margin-top: -9px;
    }
</style>