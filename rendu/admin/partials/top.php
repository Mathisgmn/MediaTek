<?php

include("../utils/global_settings.php");

?><!doctype html>
<html lang="fr" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MediaTek - Dashboard (Pico CSS)</title>

    <!-- Pico CSS stylesheet main file -->
    <link href="../vendor/picocss/pico.min.css" rel="stylesheet">
    <!-- Pico CSS stylesheet color utilities file -->
    <link href="../vendor/picocss/pico.colors.min.css" rel="stylesheet">
    <!-- Light Icons stylesheet main file -->
    <link href="../vendor/light_icons/dist/light-icon.css" rel="stylesheet">
    <!-- flatpickr stylesheet main file -->
    <link href="../vendor/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <!-- flatpickr stylesheet dark theme file -->
    <link href="../vendor/flatpickr/dist/themes/dark.css" rel="stylesheet">
    <!-- flatpickr JS main file -->
    <script src="../vendor/flatpickr/dist/flatpickr.min.js" defer></script>
    <!-- flatpickr French locale file -->
    <script src="../vendor/flatpickr/dist/l10n/fr.js" defer></script>
    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    <!-- HEADER -->
    <header id="admin-header">
        <h1>MediaTek - Dashboard</h1>
        <?php

        include_once "sidebar.php";

        ?>
    </header>

    <!-- MAIN -->
    <main id="admin-main">
        <div class="main-content"> <!-- MAIN-CONTENT : START -->
