<?php
    $titulo=$_GET['name'];
    $id_buscar=$_GET['id'];
    $consulta=file_get_contents("https://api.themoviedb.org/3/person/$id_buscar?api_key=2ca4eb2d490a9394aec85e8e7e320378&language=es-ES");
    $resultado=(array)json_decode($consulta,true);
    foreach ($resultado as $key=>$value){
        $birthday=$resultado["birthday"];
        $Rol=$resultado["known_for_department"];
        $muerte=$resultado["deathday"];
        $genero=$resultado["gender"];
        $biografía=$resultado["biography"];
        $popularidad=$resultado["popularity"];
        $lugar_nacimiento=$resultado["place_of_birth"];
        $foto="https://image.tmdb.org/t/p/w500".$resultado["profile_path"];

        if ($muerte==null) {
            $birthday="$birthday";
        }else{
            $birthday="$birthday - $muerte";
        }
        if ($biografía==null){
            $biografía="No se tiene más información de ".$titulo;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMDB - <?=$titulo?></title>
    <link rel="shortcut icon" href="img/film.png" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6ef8a378c6.js" crossorigin="anonymous"></script>
</head>
<style>
    .row::-webkit-scrollbar{
        display: none;
    }
    a{
        text-decoration: none;
        color: black;
    }

</style>
<body style="background:white">
    <nav class="navbar bg-white text-black" id="menu">
                <a class="navbar-brand text-decoration-none" href="index.php">
                    <img src="img/film.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    TheMovieDataBase
                </a>
    </nav>
    <div class="jumbotron" style="color:white; background: transparent; color:black">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 text-center">
                    <img src="<?=$foto?>" class="img-fluid rounded img-thumbnail" alt="">
                </div>
                <div class="col-sm-12 col-md-8" style="background: transparent!important;">
                    <b><h1 class="display-4 title"><?=$titulo?></h1></b>
                    <p class="text" style="color:grey; font-size: 10px;margin: 1px;"><?=$birthday?> - <?=$lugar_nacimiento?></p>
                    <p>Poularidad: <?=$popularidad?></p>
                    <b><p class="text"  style="margin: 0">Biografía</p></b>
                    <div class="bio" style="overflow-y: scroll; height:359px">
                        <p class="text-justify"><?=$biografía?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer text-center">
            <p>Todos los derechos reservados, propiedad de <b><a href="https://jsamperg.herokuapp.com" style="color:black">Jssg &copy;</a>.</p></b>
        </div>
    </footer>
</body>
</html>