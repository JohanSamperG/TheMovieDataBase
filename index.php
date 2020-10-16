<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TMDB</title>
        <link rel="shortcut icon" href="img/film.png" type="image/x-icon">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/6ef8a378c6.js" crossorigin="anonymous"></script>
    </head>
    <?php
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        error_reporting(0);
        $ConsultaPeliculas=file_get_contents("https://api.themoviedb.org/3/trending/movie/day?api_key=2ca4eb2d490a9394aec85e8e7e320378&language=es");
        $resultado=(array)json_decode($ConsultaPeliculas,true);
        $ConsultaPeliculas=$resultado['results'];

        $ConsultaSeries=file_get_contents("https://api.themoviedb.org/3/trending/tv/day?api_key=2ca4eb2d490a9394aec85e8e7e320378&language=es");
        $resultado=(array)json_decode($ConsultaSeries,true);
        $ConsultaSeries=$resultado['results'];
        //print_r($ConsultaPeliculas)

        $url = file_get_contents("http://api.giphy.com/v1/gifs/search?q=movie&api_key=ltf1PN4P0JB4UgopBZ6CasMJL3Qh4PEh");
        $url=(array)json_decode($url,true);
        $url=$url['data'];
        $arrayGif=[];
        $i=0;
        foreach ((array)$url as $key=>$value){
            $gif=$url[$key]["images"];
            foreach ($gif as $key=>$value){
                $arrayGif[$i]=$gif["original"]["url"];
                $i++;
            }
        }
        
        $gifRandom=$arrayGif[array_rand($arrayGif,1)];
        
    ?>

    <style>
        h1{
            font-size: 1.5rem;
        }
        body{
            width: 100%;
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
        .footer{
            margin-top: 40px;
        }
        a{
            text-decoration: none;
            color: black;
        }
        .oculto{
        <?php
             $buscar=$_GET['buscar'];
             if (empty($buscar)):?>
                visibility: hidden;
                display:none !important;
             <?php else:?>
                visibility: visible!important;
             <?php endif;?>
        }
        .principal{
        <?php
             $buscar=$_GET['buscar'];
             if (empty($buscar)):?>
                visibility: visible;
             <?php else:?>
                visibility: hidden;
                display:none !important;
             <?php endif;?>
        }
        
        
    </style>
    <body>
        <nav class="navbar bg-white text-white sticky-top" id="menu">
            <a class="navbar-brand text-decoration-none" href="index.php">
                <img src="img/film.png" width="30" height="30" class="d-inline-block align-top" alt="">
                 TheMovieDataBase
            </a>
        </nav>
        <div class="img" style="background:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),url('<?=$gifRandom?>');color:white;width: 100%;height: 70vh; " id="img">
            <div class="texto d-flex align-items-center justify-content-center align-content-center" style="height: 100%;width: 100%;">
               <div class="container" style="width: 100%;">
                    <h1 class="title" style="font-size: 2.5rem;width: 240px;border-radius: 5px;background-color: none!important">Bienvenidos.</h1>
                    <p style="width: auto; border-radius: 5px;" class="sub-title">Millones de películas y programas de televisión. Explora ahora.</p>
                    <form action="index.php" method="get" >
                        <div class="input-group">
                            <input class="form-control" type="search" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="buscar" placeholder="Busca lo que desees" aria-label="Search" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-danger" style="filter: none!important;"><i class="fas fa-search"></i></button>
                            </div>   
                        </div>
                        Selecciona el tipo de busqueda:</br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="busqueda" id="inlineRadio1" value="movie" required>
                            <label class="form-check-label" for="inlineRadio1">Peliculas</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="busqueda" id="inlineRadio2" value="tv" required>
                            <label class="form-check-label" for="inlineRadio2">Series</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
        <?php
            $buscar;
            if (empty($buscar)) {

            }else{
                $buscar=($_GET['buscar']);
                $buscar=str_replace(' ','%20',$buscar);
                $tipo=$_GET['busqueda'];
                $consulta=file_get_contents("https://api.themoviedb.org/3/search/"."$tipo"."?api_key=2ca4eb2d490a9394aec85e8e7e320378&query="."$buscar"."&language=es-ES");
                $resultado=(array)json_decode($consulta,true);
                $resultado=$resultado['results'];
                $buscar=str_replace('%20',' ',$buscar);
            }
        ?>
        <div class="oculto container h-100" style="visibility: hidden">
            <h1 class="title">Busqueda: <?=$buscar?></h1>
            <div class="testimonial-group" id="testimonial-group">
                <div class="row text-center flex-nowrap">
                <?php if(!empty($resultado)):?>
                <?php foreach($resultado as $key=>$value):?>
                    <?php
                        $id=$resultado[$key]["id"];
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
                                 
                        }
                        
                        //print_r($poster_path);
                    ?>
                    <div class="col-5 col-md-2 text-left" style="padding: 0px;">
                        <a href="vista.php?id=<?=$id?>&original_title=<?=$original_title?>&type=<?=$tipo?>">
                            <img src="<?=$poster_path?>" class="card-img-top img-fluid img-thumbnail" alt="<?=$original_title?>" style="height:60%">
                        </a>
                        <div class="card" style="height:20%;border:none" >
                            <div class="card-body">
                            <a href="vista.php?id=<?=$id?>&original_title=<?=$original_title?>&type=<?=$tipo?>" style="font-weight: 700;"><?=$original_title?></a>
                                <p class="card-text" style="color:grey"><?=$release_date?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <?php else:?>
                        <div class="container">
                            <p class="text-left">No hay resultados por mostrar :(</p>
                        </div>
                        
                    <?php endif;?>
                </div>
            </div>
        </div>
        
        <div class="principal container h-100">
            <h1 class="title">Tendencias en peliculas</h1>
            <div class="testimonial-group" id="testimonial-group">
                <div class="row text-center flex-nowrap">
                <?php foreach($ConsultaPeliculas as $key=>$value):?>
                    <?php
                        $id=$ConsultaPeliculas[$key]["id"];
                        $poster_path=$ConsultaPeliculas[$key]["poster_path"];
                        if($poster_path=="" || $poster_path==null){
                            $poster_path="https://via.placeholder.com/300.png";
                        }else{
                            $poster_path="https://image.tmdb.org/t/p/w500"."$poster_path";
                        }
                        $original_title=$ConsultaPeliculas[$key]["original_title"];
                        if($original_title==""){
                            $original_title="No title";
                        }     
                        $release_date=$ConsultaPeliculas[$key]["release_date"]; 
                        if($release_date=="" || $release_date==null){
                            $release_date="No date";
                        }
                        $backdrop_path=$ConsultaPeliculas[$key]["backdrop_path"];
                        if($backdrop_path=="" || $backdrop_path==null){
                            $backdrop_path="https://via.placeholder.com/300.png";
                        }else{
                            $backdrop_path="https://image.tmdb.org/t/p/w1920_and_h800_multi_faces"."$backdrop_path";
                        }
                        $overview=$ConsultaPeliculas[$key]['overview'];
                        if($overview=="" || $overview==null){
                            $overview="No se tiene información sobre ".$original_title;
                        }
                        $vote_average=$ConsultaPeliculas[$key]['vote_average'];
                        if($vote_average=="" || $vote_average==null){
                            $vote_average="0 / 10";
                        }else{
                            $vote_average="$vote_average / 10";
                        }
                        $tipo='movie';
                    ?>
                    <div class="col-5 col-md-2 text-left" style="padding: 0px;">
                        <a href="vista.php?id=<?=$id?>&original_title=<?=$original_title?>&type=<?=$tipo?>">
                            <img src="<?=$poster_path?>" class="card-img-top img-fluid img-thumbnail" alt="<?=$original_title?>" style="height:60%">
                        </a>
                        <div class="card" style="height:20%;border:none" >
                            <div class="card-body">
                                <a href="vista.php?id=<?=$id?>&original_title=<?=$original_title?>&type=<?=$tipo?>" style="font-weight: 700;"><?=$original_title?></a>
                                <p class="card-text" style="color:grey"><?=$release_date?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <br>
            <br>
            <h1 class="title">Tendencias en series</h1>
            <div class="testimonial-group"  id="testimonial-group">
                <div class="row text-left flex-nowrap">
                <?php foreach($ConsultaSeries as $key=>$value):?>
                    <?php
                        $id=$ConsultaSeries[$key]["id"];
                        $poster_path=$ConsultaSeries[$key]["poster_path"];
                        if($poster_path=="" || $poster_path==null){
                            $poster_path="https://via.placeholder.com/300.png";
                        }else{
                            $poster_path="https://image.tmdb.org/t/p/w500"."$poster_path";
                        }
                        $original_title=$ConsultaSeries[$key]["original_name"];
                        if($original_title==""){
                            $original_title="No title";
                        }   
                        $first_air_date=$ConsultaSeries[$key]["first_air_date"];
                        if($first_air_date=="" || $first_air_date==null){
                            $first_air_date="No date";
                        }
                        $backdrop_path=$ConsultaSeries[$key]["backdrop_path"];
                        if($backdrop_path=="" || $backdrop_path==null){
                            $backdrop_path="https://via.placeholder.com/300.png";
                        }else{
                            $backdrop_path="https://image.tmdb.org/t/p/w1920_and_h800_multi_faces"."$backdrop_path";
                        }
                        $overview=$ConsultaSeries[$key]['overview'];
                        if($overview=="" || $overview==null){
                            $overview="No se tiene información sobre ".$original_title;
                        }
                        $vote_average=$ConsultaSeries[$key]['vote_average'];
                        if($vote_average=="" || $vote_average==null){
                            $vote_average="0 / 10";
                        }else{
                            $vote_average="$vote_average / 10";
                        }
                        $tipo='tv';
                       
                        //print_r($poster_path);
                    ?>
                    <div class="col-5 col-md-2 text-left" style="padding: 0px;">
                        <a href="vista.php?id=<?=$id?>&original_title=<?=$original_title?>&type=<?=$tipo?>">
                            <img src="<?=$poster_path?>" class="card-img-top img-fluid img-thumbnail" alt="<?=$original_title?>" style="height:60%">
                        </a>
                        <div class="card" style="height:20%;border:none">
                            <div class="card-body" style="margin: 0%">
                                <a href="vista.php?id=<?=$id?>&original_title=<?=$original_title?>&type=<?=$tipo?>" style="font-weight: 700;"><?=$original_title?></a>
                                <p class="card-text" style="color:grey"><?=$first_air_date?></p>
                            </div>
                        </div>
                        
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer text-center">
                <p>Todos los derechos reservados, propiedad de <a href="https://jsamperg.herokuapp.com">Jssg</a>.</p>
            </div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script>
            $(window).scrollLeft(function() {
                if ($("#testimonial-group").offset() !=50) {
                    $(".principal").css("border-right-color", "yellow");
                } else {
                    
                }
            });
        </script>
    </body>
</html>