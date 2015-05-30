<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
$c = oci_connect("SYSTEM", "rogerfed17","localhost/XE");
//inregisrarile filtrate
if(isset($_GET['nume'])){

    if (isset($_GET['nr_pg'])&&(isset($_GET['nr_del']))) {
        $nr_pagina = $_GET['nr_pg'];
        $nr_de_elemente = $_GET['nr_del'];
    }

    else{
        $nr_pagina = 1;
        $nr_de_elemente = 10;
    }

    $nume_cautat=$_GET['nume'];
        $s=ociparse($c, "SELECT * from (select u.username, rownum r from utilizatori u) where r <= $nr_pagina * $nr_de_elemente and r > ($nr_pagina-1)*$nr_de_elemente and username = :nume_cautat");
        oci_bind_by_name($s,':nume_cautat',$nume_cautat);
        if(oci_execute($s)){
            while(ocifetch($s))
        {
            echo "<td>".ociresult($s, "USERNAME")."</td>";
            echo '<br>';
        }
    }

    $s=ociparse($c, "SELECT COUNT(*) FROM utilizatori");

    if(oci_execute($s)){
        ocifetch($s);
        $numar_inreg=ociresult($s,"COUNT(*)");
    }

    $number_of_paginas=floor($numar_inreg/$nr_de_elemente);
    if($numar_inreg%$nr_de_elemente!=0)
        $number_of_paginas++;

    $next = $nr_pagina+1;
    $previous = $nr_pagina-1;

    if($nr_pagina<=1){
        echo "<button disabled onclick=\"location.href='http://localhost/gus/thePagination.php?nr_pg=$previous&nr_del=$nr_de_elemente'\"> previous </button>";
    }
    else{
        echo "<button onclick=\"location.href='http://localhost/gus/thePagination.php?nr_pg=$previous&nr_del=$nr_de_elemente'\"> previous </button>";
    }

    if($nr_pagina>=$number_of_paginas){
        echo "<button disabled onclick=\"location.href='http://localhost/gus/thePagination.php?nr_pg=$next&nr_del=$nr_de_elemente'\"> next </button>";
    }
    else{
        echo "<button onclick=\"location.href='http://localhost/gus/thePagination.php?nr_pg=$next&nr_del=$nr_de_elemente'\"> next </button>";
    }
}



//toate inregistrarile
else{
    if (isset($_GET['nr_pg'])&&(isset($_GET['nr_del']))) {
        $nr_pagina = $_GET['nr_pg'];
        $nr_de_elemente = $_GET['nr_del'];
    }
    else{
        $nr_pagina = 1;
        $nr_de_elemente = 10;
    }

    $s=ociparse($c, "SELECT * from (select u.username, rownum r from utilizatori u) where r <= $nr_pagina * $nr_de_elemente and r > ($nr_pagina-1)*$nr_de_elemente");
    if(oci_execute($s)){
        while(ocifetch($s))
        {
            echo "<td>".ociresult($s, "USERNAME")."</td>";
            echo '<br>';
        }
    }


    $s=ociparse($c, "SELECT COUNT(*) FROM utilizatori");

    if(oci_execute($s)){
        ocifetch($s);
        $numar_inreg=ociresult($s,"COUNT(*)");
    }

    $number_of_paginas=floor($numar_inreg/$nr_de_elemente);
    if($numar_inreg%$nr_de_elemente!=0)
        $number_of_paginas++;

    $next = $nr_pagina+1;
    $previous = $nr_pagina-1;

    if($nr_pagina<=1){
        echo "<button disabled onclick=\"location.href='http://localhost/gus/thePagination.php?nr_pg=$previous&nr_del=$nr_de_elemente'\"> previous </button>";
    }
    else{
        echo "<button onclick=\"location.href='http://localhost/gus/thePagination.php?nr_pg=$previous&nr_del=$nr_de_elemente'\"> previous </button>";
    }

    if($nr_pagina>=$number_of_paginas){
        echo "<button disabled onclick=\"location.href='http://localhost/gus/thePagination.php?nr_pg=$next&nr_del=$nr_de_elemente'\"> next </button>";
    }
    else{
        echo "<button onclick=\"location.href='http://localhost/gus/thePagination.php?nr_pg=$next&nr_del=$nr_de_elemente'\"> next </button>";
    }
}

oci_close($c);

?>

<form action="thePagination.php" method="GET">
    Pagina: <input type="text" name="nr_pg"><br>
    Numar de elemente: <input type="text" name="nr_del"><br>
    <input type="submit" value="Search">
</form>

<form action="thePagination.php" method="GET">
    Numele: <input type="text" name="nume"><br>
    <input type="submit" value="Search">
</form>

</body>
</html>