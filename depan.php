<?php
require 'function.php';

// Fetch distinct years from the database for the dropdown
$years_query = "SELECT DISTINCT tahun FROM penelitian ORDER BY tahun DESC";
$years_result = $conn->query($years_query);

// Fetch distinct instances from the database for the dropdown
$instansi_query = "SELECT DISTINCT nama_instansi FROM instansi ORDER BY nama_instansi ASC";
$instansi_result = $conn->query($instansi_query);

// Fetch distinct faculties from the database for the dropdown
$fakultas_query = "SELECT DISTINCT nama_fakultas FROM fakultas ORDER BY nama_fakultas ASC";
$fakultas_result = $conn->query($fakultas_query);

// Fetch distinct categories from the database for the dropdown
$categories_query = "SELECT DISTINCT nama_kategori FROM kategori ORDER BY nama_kategori ASC";
$categories_result = $conn->query($categories_query);

// Fetch distinct locations from the database for the dropdown
$locations_query = "SELECT DISTINCT id_rak FROM rak ORDER BY id_rak ASC";
$locations_result = $conn->query($locations_query);
?>
