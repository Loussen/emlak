<?php
function getFilteredParam($param){
    $filterList = array(
        'cardType'    => "/^[v|m]$/",
        'amount'      => '/^[0-9.]*$/',
        'item'        => '/^[a-zA-Z\(\) 0-9\-]*$/',
        'lang'        => '/^(lv|en|ru)$/',
        'payment_key' => '/^[a-zA-Z0-9\-]*$/'
    );
    $filter = $filterList[$param];
    if (is_null($filter) || !is_string($filter)) {
        echo "Filter for this parameter not found: ".$param;
        exit();
    }
    $new_param = filter_input(INPUT_POST, $param, FILTER_SANITIZE_STRING); 
    if ($new_param == null) {
        $new_param = filter_input(INPUT_GET, $param, FILTER_SANITIZE_STRING); 
    }
    if (!preg_match($filter, $new_param)){
        echo "Wrong parameter characters: ".$new_param;
        exit();
    }
    return $new_param;
}
if (false) {
    echo 'You select wrong value for parameter.';
    exit();
}