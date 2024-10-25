<?php

function handle_file($filePath)
{
    $data = array();
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        $header = fgetcsv($handle);
        if ($header === false) {
            \Log::error('Failed to read CSV header.');
            return [];
        }
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($row) === count($header)) {
                $data[] = array_combine($header, $row);
            } else {
                \Log::warning('Row does not match header count, skipping:', ['row' => $row]);
            }
        }
        fclose($handle);
    }else {
        \Log::error('Failed to open the CSV file.');
    }
    return $data;
}
function prepare_data($data)
{
    return array(
        'id' => $data['id'] != '' ? (int)$data['id'] : null,
        'name' => $data['name'] != '' ? $data['name'] : null,
        'sku' => $data['sku'] != '' ? $data['sku'] : null,
        'status' => $data['status'] != '' ? $data['status'] : null,
        'variations' => $data['variations'] != '' ? $data['variations'] : null,
        'price' => $data['price'] != '' ? (float)$data['price'] : null,
        'currency' => $data['currency'] != '' ? $data['currency'] : null,
    );
}
