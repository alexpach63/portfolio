<?php
/**
 * Первое задание.
 * Нужно написать код, который из массива выведет то что приведено ниже в комментарии.
 */
$x = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h');
$newAra = array();
for ($i=0; $i < count($x); $i++) { 
    $newAra = array($x[$i] => $newAra);
}
$x = $newAra;

// print_r($x);
// Array
// (
//     [h] => Array
//         (
//             [g] => Array
//                 (
//                     [f] => Array
//                         (
//                             [e] => Array
//                                 (
//                                     [d] => Array
//                                         (
//                                             [c] => Array
//                                                 (
//                                                     [b] => Array
//                                                         (
//                                                             [a] => 
//                                                         )

//                                                 )

//                                         )

//                                 )

//                         )

//                 )

//         )

// );


/**
 * Втрое задание.
 * Написать функцию которая из этого массива
 */
$data = [
    'parent.child.field' => 1,
    'parent.child.field2' => 2,
    'parent2.child.name' => 'test',
    'parent2.child2.name' => 'test',
    'parent2.child2.position' => 10,
    'parent3.child3.position' => 10,
];

function ParseToArray($data){ // приводим в нормальный вид
    $a = 0;
    
    foreach ($data as $key => $value) {
        $newData[$a] = $value;
 
        $keys = array_reverse(explode('.',$key));
        for ($i=0; $i < count($keys); $i++) { 
            $newData[$a] = array($keys[$i] => $newData[$a]);
        }
        $a++;
    }
    $last = array_merge_recursive($newData[0], $newData[1], $newData[2], $newData[3], $newData[4], $newData[5]);
    echo "<pre>";
    print_r($last);
    echo "</pre>";
    return $last;
}
$data = ParseToArray($data);

//сделает такой и наоборот
// $data = [
//     'parent' => [
//         'child' => [
//             'field' => 1,
//             'field2' => 2,
//         ]
//     ],
//     'parent2' => [
//         'child' => [
//             'name' => 'test'
//         ],
//         'child2' => [
//             'name' => 'test'
//             'position' => 10
//         ]
//     ],
//     'parent3' => [
//         'child3' => [
//             'position' => 10
//         ]
//     ],
// ];

$newAra = array();
function ParseToString($array,$road){ // приводим в строчный массив
    global $newAra;
    foreach ($array as $key => $var) { 
        $road1 = $road.".".$key; 
        if(is_array($var)){ 
            ParseToString($var,$road1); 
        } 
        else {
            $road1 = mb_substr( $road1, 1);
            $newAra[$road1] = $var;
            // echo $road1." => ".$var."<br>"; 
        }
    } 
} 

ParseToString($data,$road);

/**
 * Третье задание.
 * Дан массив с элементами начинающимися с ADDRESS_* и REGISTRATION_*, как скопировать все элементы ADDRESS_* в соответствующие REGISTRATION_*?
 */
$data = [
    'ADDRESS_CITY' => 'Москва',
    'ADDRESS_STREET' => 'Правды',
    'ADDRESS_HOUSE' => '10',
    'REGISTRATION_CITY' => 'Москва',
    'REGISTRATION_STREET' => 'Рочдельская',
    'REGISTRATION_HOUSE' => '12'
];

function copyA($data){
    foreach ($data as $key => $value) {
        $prefix = explode('_', $key);
        if($prefix[0] == 'ADDRESS' && array_key_exists('REGISTRATION_'.$prefix[1] ,$data)){
            $data['REGISTRATION_'.$prefix[1]] = $value;
        }
    }
    return $data;
}
$data = copyA($data);

// echo "<pre>";
// print_r($data);
// echo "</pre>";

//результат должен быть такой
// $data = [
//     'ADDRESS_CITY' => 'Москва',
//     'ADDRESS_STREET' => 'Правды',
//     'ADDRESS_HOUSE' => '10',
//     'REGISTRATION_CITY' => 'Москва',
//     'REGISTRATION_STREET' => 'Правды',
//     'REGISTRATION_HOUSE' => '10'
// ];


/**
 * Четвертое задание.
 * Написать функцию, принимающую массив строк, а возвращающую перечисление этих строк подобно 
 * правилам русского языка: строки перечисляются через запятую, а перед последней строкой союз "и".  
 * Предусмотреть корректное поведение при передаче в функцию не только массива любых строк, но и  
 * при попытках передать на вход объект, число и т.п. 
 * Примеры входных данных:
 */
$input1 = ["красный","оранжевый","жёлтый","зелёный"];
$input2 = ["красный","оранжевый","жёлтый","зелёный", ","];
$input3 = [",красный","оранжевый","жёлтый",",зелёный,"];
$input4 = ["!", ":", ";", ".", ","];


function russian($input){
    $res = '';
    $count = count($input);
    $i = 1;
    foreach ($input as $value) {
        if(gettype($value) != 'string'){ 
            $res = 'Ну кто такие данные передает??'; 
            break;
        }
        if($i == $count) $res .= $value;
        else if($i == $count-1) $res .= $value.' и ';
        else $res .= $value.', ';
        $i++;
    }
    return $res;
}

// echo russian($input4);






