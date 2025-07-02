<?php
// array_helper.php
// Fungsi-fungsi bantu untuk manipulasi array di PHP

/**
 * Mengecek apakah array adalah multidimensi
 *
 * @param array $arr
 * @return bool
 */
function isMultidimensional(array $arr): bool {
    return count($arr) !== count($arr, COUNT_RECURSIVE);
}

/**
 * Menghapus nilai duplikat dari array (khusus array 1 dimensi)
 *
 * @param array $arr
 * @return array
 */
function removeDuplicates(array $arr): array {
    return array_values(array_unique($arr));
}

/**
 * Menggabungkan array menjadi string dengan pemisah
 *
 * @param array $arr
 * @param string $delimiter
 * @return string
 */
function arrayToString(array $arr, string $delimiter = ', '): string {
    return implode($delimiter, $arr);
}

/**
 * Mendapatkan nilai yang paling sering muncul (modus)
 *
 * @param array $arr
 * @return mixed|null
 */
function mostFrequentValue(array $arr) {
    if (empty($arr)) return null;

    $counts = array_count_values($arr);
    arsort($counts);
    return array_key_first($counts);
}
