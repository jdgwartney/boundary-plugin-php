<?php
$data = json_encode([
                [$hostname, 'RESULTS_REQUEST_DATES', 1],
                [$hostname, 'RESULTS_REQUEST_NODATES', 2],
                [$hostname, 'RESULTS_REQUEST_COORDS', 3],
                [$hostname, 'DETAILS_REQUEST', 4],
                [$hostname, 'REGION_REQUEST', 5]
        ]);

echo $data;
