<?php
    const IVA=0.16;
    define('PRECIO',1200);
    
    $numero=5;
    $numero2=10;
    $numero3="hola";
    
    if($numero<$numero2){
    echo "el $numero es menor que el $numero2 ";
}else{
    echo 'el $numero es mayor que el '.$numero2.'';
}
$calif=50;
if($calif<=100 && $calif>=85){
    echo "\nTu calificacion es exelente";
}
elseif($calif>70){
    echo "\nTu calificacion es buena";
}
elseif($calif==70){
    echo "\nTu calificacion es suficiente";
}
else{
    echo "\nReprobaste";
}
echo"<br>";
$control=1;
switch($control){
    case 1:
        echo "\nEres el usuario 1";
        break;
    case 2:
        echo "\nEres el usuario 2";
        break;
    default:
        echo "\nNo eres usuario";
        break;
}
echo"<br>";
for($i=0;$i<10;$i++){
    echo "\nEl valor de i es: $i<br>";
}
echo"<br>";
$j=1;
while($j<=10){
    echo "\nEl valor de j es: $j<br>";
    $j+=2;
}
echo"<br>";
do{
    echo "\nEl valor de j en do while es: $j<br>";
    $j+=3;
}while($j<=10);
echo"<br>";
$numeros=[0,1,2,3,4,5,6,7,8,9];
$numeros[0]=10;
$numeros[1]=15;
$numeros[2]=17;

echo"| ";
foreach($numeros as $num){
    echo "\nEl valor es: $num |";
}
?>