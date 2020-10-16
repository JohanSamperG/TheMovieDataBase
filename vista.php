<?php
    $titulo=$_GET['original_title'];
    $titulo=str_replace(' ','%20',$titulo);
    $id_buscar=$_GET['id'];
    $tipo=$_GET['type'];
    $consulta=file_get_contents("https://api.themoviedb.org/3/search/"."$tipo"."?api_key=2ca4eb2d490a9394aec85e8e7e320378&query="."$titulo"."&language=es-ES");
    $resultado=(array)json_decode($consulta,true);
    $resultado=$resultado['results'];
    $titulo=str_replace('%20',' ',$titulo);
    foreach ($resultado as $key=>$value){
        $id_resultado=$resultado[$key]["id"];
        if($id_buscar==$id_resultado){
            if($tipo=='tv'){
                $poster_path=$resultado[$key]["poster_path"];
                if($poster_path=="" || $poster_path==null){
                    $poster_path="https://via.placeholder.com/300.png";
                }else{
                    $poster_path="https://image.tmdb.org/t/p/w500"."$poster_path";
                }
                $original_title=$resultado[$key]["original_name"];
                if($original_title==""){
                    $original_title="No title";
                }   
                $release_date=$resultado[$key]["first_air_date"];
                if($release_date==""||$release_date==null){
                    $release_date="No date";
                }
                $backdrop_path=$resultado[$key]["backdrop_path"];
                if($backdrop_path=="" || $backdrop_path==null){
                    $backdrop_path="https://via.placeholder.com/300.png";
                }else{
                    $backdrop_path="https://image.tmdb.org/t/p/w1920_and_h800_multi_faces"."$backdrop_path";
                }
                $overview=$resultado[$key]['overview'];
                if($overview=="" || $overview==null){
                    $overview="No se tiene información sobre ".$original_title;
                }
                $vote_average=$resultado[$key]['vote_average'];
                if($vote_average=="" || $vote_average==null){
                    $vote_average="0 / 10";
                }else{
                    $vote_average="$vote_average / 10";
                }
            }else{
                $poster_path=$resultado[$key]["poster_path"];
                if($poster_path=="" || $poster_path==null){
                    $poster_path="https://via.placeholder.com/300.png";
                }else{
                    $poster_path="https://image.tmdb.org/t/p/w500"."$poster_path";
                }
                $original_title=$resultado[$key]["original_title"];  
                if($original_title==""){
                    $original_title="No title";
                }   
                $release_date=$resultado[$key]["release_date"];
                if($release_date==""||$release_date==null){
                    $release_date="No date";
                } 
                $backdrop_path=$resultado[$key]["backdrop_path"];
                if($backdrop_path=="" || $backdrop_path==null){
                    $backdrop_path="https://image.tmdb.org/t/p/w500"."$poster_path";
                }else{
                    $backdrop_path="https://image.tmdb.org/t/p/w1920_and_h800_multi_faces"."$backdrop_path";
                }
                $overview=$resultado[$key]['overview'];
                if($overview=="" || $overview==null){
                    $overview="No se tiene información sobre ".$original_title;
                }
                $vote_average=$resultado[$key]['vote_average'];
                if($vote_average=="" || $vote_average==null){
                    $vote_average="0 / 10";
                }else{
                    $vote_average="$vote_average / 10";
                }
            }
        }
    }
    $credits=file_get_contents("https://api.themoviedb.org/3/$tipo/$id_buscar/credits?api_key=2ca4eb2d490a9394aec85e8e7e320378&language=es-ES");
    $grupo=(array)json_decode($credits,true);
    $grupo=$grupo['cast'];
?>
<!DOCTYPE html>
<html lang="en">
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
    .testimonial-group::-webkit-scrollbar-thumb {
            background: purple;
            border-radius: 2px;
    }
    .testimonial-group > .row {
        overflow-x: auto;
        white-space: auto;
    }   
    .testimonial-group > .row > .col-sm-4 {
        display: inline-block;
        float: none;
    }
    .card-body > a{
        color: white;
    }

</style>
<body style="background:linear-gradient(rgba(0,0,0,0.8),rgba(0,0,0,0.8)),url('<?=$backdrop_path?>');background-repeat:repeat;">
    <nav class="navbar bg-white text-white" id="menu">
                <a class="navbar-brand text-decoration-none" href="index.php">
                    <img src="img/film.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    TheMovieDataBase
                </a>
    </nav>
    <div class="jumbotron" style="color:white; background: transparent;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 text-center">
                    <img src="<?=$poster_path?>" class="img-fluid rounded img-thumbnail" alt="">
                </div>
                <div class="col-sm-12 col-md-8" style="background: transparent!important;">
                    <b><h1 class="display-4 title"><?=$titulo?></h1></b>
                    <p class="text" style="color:grey; font-size: 10px;margin: 1px;"><?=$release_date?></p>
                    <p>Puntuación por los usuarios: <?=$vote_average?></p>
                    <b><p class="text"  style="margin: 0">Vista General</p></b>
                    <p class="text-justify"><?=$overview?></p>
                    <b><p class="text"  style="margin: 0">Elenco Principal</p></b>
                    <div class="testimonial-group " id="testimonial-group">
                        <div class="row text-center flex-nowrap">
                            <?php foreach ($grupo as $key => $value):?>
                                <?php 
                                    $personaje=$grupo[$key]["character"];
                                    $credit_id=$grupo[$key]["credit_id"];
                                    $gender=$grupo[$key]["gender"];
                                    if ($gender==1) {
                                        $gender='Hombre';
                                    }else{
                                        $gender='Mujer';
                                    }
                                    $id=$grupo[$key]["id"];
                                    $name=$grupo[$key]["name"]; 
                                    $profile_path=$grupo[$key]["profile_path"];
                                    if ($profile_path==null) {
                                        $profile_path="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
                                    }else{
                                        $profile_path="https://image.tmdb.org/t/p/w500".$profile_path;
                                    }
                                ?>
                                <div class="col-3 col-md-2 text-left" style="padding: 3px;">
                                    <a href="vistaActor.php?id=<?=$id?>&name=<?=$name?>" style="color: white;">
                                        <img src="<?=$profile_path?>" class="card-img-top img-fluid img-thumbnail" alt="<?=$name?>" style="height:45%; max-height: 45%; margin-top:10px;">
                                    </a>
                                    <div class="c card bg-transparent" style="height:40%;border:none">
                                        <div class="card-body">
                                            <a href="vistaActor.php?id=<?=$id?>&name=<?=$name?>"><?=$name?></a>
                                            <p class="card-text" style="color:grey; font-size: 7px;">Personaje: <?=$personaje?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer text-center">
            <p>Todos los derechos reservados, propiedad de <a href="https://jsamperg.herokuapp.com" style="color:white">Jssg &copy;</a>.</p>
        </div>
    </footer>
</body>
</html>