<?php 
// include('_core/_includes/config.php');
include_once "./_core/_includes/config.php";
  // Globais - Definição de variáveis
  $rootpath;
  $httprotocol;
  $simple_url;
  $gowww = $httprotocol.$simple_url;
  $firstdomain = explode(".", $simple_url); //Separa a url em um array, usando como parâmetro de divisão o "." neste caso
  $firstdomain = $firstdomain[0]; //Atribui o primeiro valor do array gerado anteriormente à variável $firstdomain
  
  // Mapeando subdominio //
  $insubdominio = explode('.', $_SERVER['HTTP_HOST'])[0];
  // var_dump($insubdominio);
  if ( strpos($insubdominio, '.') !== false) {
    $insubdominio = substr($insubdominio, 0, strpos($insubdominio, '.'));
  }
  $insubdominio = isset($_GET['insubdominio']) ? $_GET['insubdominio'] : ''; 
  if( !$insubdominio ) { 
    $insubdominio = explode(".", $_SERVER['HTTP_HOST']);
    $insubdominio = array_shift($insubdominio);
    if( $insubdominio == $firstdomain ) {
      $insubdominio = "";
    }
    if( $insubdominio == "www" ) {
        header("location: ".$gowww);
      }
    }

  // Estabelecimento
  if( mysqli_num_rows( mysqli_query( $db_con, "SELECT id,subdominio FROM estabelecimentos WHERE subdominio = '$insubdominio' AND excluded != '1' LIMIT 1" ) ) ) {
    $query = mysqli_query( $db_con, "SELECT id,subdominio FROM estabelecimentos WHERE subdominio = '$insubdominio' LIMIT 1" );
    $data = mysqli_fetch_array( $query );
    $has_insubdominio = "1";
    $insubdominioid = $data['id'];
    $insubdominiotipo = 1;
    
  }

  // Cidade
  if( mysqli_num_rows( mysqli_query( $db_con, "SELECT id,subdominio FROM cidades WHERE subdominio = '$insubdominio' LIMIT 1" ) ) ) {
    $query = mysqli_query( $db_con, "SELECT id,subdominio FROM cidades WHERE subdominio = '$insubdominio' LIMIT 1" );
    $data = mysqli_fetch_array( $query );
    $has_insubdominio = "1";
    $insubdominioid = $data['id'];
    $insubdominiotipo = 2;
    
  }

  // Subdominio
  if( mysqli_num_rows( mysqli_query( $db_con, "SELECT * FROM subdominios WHERE subdominio = '$insubdominio' LIMIT 1" ) ) ) {
    $query = mysqli_query( $db_con, "SELECT * FROM subdominios WHERE subdominio = '$insubdominio' LIMIT 1" );
    $data = mysqli_fetch_array( $query );
    $has_insubdominio = "1";
    $insubdominioid = $data['rel_id'];
    $insubdominiotipo = $data['tipo'];
    if( $insubdominiotipo == "1" ) {
      if( data_info( "estabelecimentos",$insubdominioid,"excluded" ) == "1" ) {
        $has_insubdominio = "0";
        $insubdominioid = "";
        $insubdominiotipo = "";
        
      }
    }
  }

  // Se existe o subdominio
  if ($insubdominio) {

      // Tipo do subdominio
      // switch ($insubdominio) {
      //   case 'estabelecimento':
      //     $insubdominiotipo = 1;
      //     break;
      //   case 'cidade':
      //     $insubdominiotipo = 2;
      //     break;
      //   default:
      //     $insubdominiotipo = 0;
      // }



    // Roteando
    $router = $_GET['inrouter'];
    $router = explode('/', $router);
    $inacao = $router[0];
    $inparametro = isset($router[1]) ? $router[1] : '';
    var_dump($router);
    var_dump("Acao: ".$inacao);
    var_dump("Parametro: ".$inparametro);
    // Estabelecimento
    if ($insubdominiotipo == 1) {
      $virtualpath = $rootpath.'/app/estabelecimento';
      switch ($inacao) {
        case '':
          $chamar = $virtualpath.'/index.php';
          break;
        case 'categoria':
          $chamar = $virtualpath.'/categoria.php';
          break;
        case 'produto':
          $chamar = $virtualpath.'/produto.php';
          break;
        case 'sacola':
          $chamar = $virtualpath.'/sacola.php';
          break;
        case 'pedido':
          $chamar = $virtualpath.'/pedido.php';
          break;
        default:
          $chamar = $virtualpath.'/404.php';
      }
    }

    // Cidade

  if ($insubdominiotipo == 2) {
      $virtualpath = $rootpath.'/app/cidade';
      switch ($inacao) {
        case '':
          $chamar = $virtualpath.'/index.php';
          break;
        case 'produtos':
          $chamar = $virtualpath.'/produtos.php';
          break;
        case 'estabelecimentos':
          $chamar = $virtualpath.'/estabelecimentos.php';
          break;
        case 'sacola':
          $chamar = $virtualpath.'/sacola.php';
          break;
        default:
          $chamar = $virtualpath.'/404.php';
      }
    }
    var_dump("Chamar: ".$chamar);
    var_dump("Subdominio: ".$insubdominio);
    var_dump("Subdominio ID: ".$insubdominioid);
    var_dump("Subdominio Tipo: ".$insubdominiotipo);
  } else {

    if( $insubdominio ) {
      include("404.php");
    } else {
      include("localizacao/index.php"); //DESMASCAR PARA USAR MARKETPLACE COMO PAGINA PADRAO
      // header("Location: https://ominichanel.redewe2m.com.dev/conheca");
    }

  }


?>