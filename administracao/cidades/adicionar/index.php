<?php
// CORE
include('../../../_core/_includes/config.php');
// RESTRICT
restrict('1');
// SEO
$seo_subtitle = "Adicionar cidade";
$seo_description = "";
$seo_keywords = "";
// HEADER
$system_header .= "";
include('../../_layout/head.php');
include('../../_layout/top.php');
include('../../_layout/sidebars.php');
include('../../_layout/modal.php');
?>

<?php

  // Globals

  global $numeric_data;

  // Checar se formulário foi executado

  $formdata = isset($_POST['formdata']);

  if( $formdata ) {

    // Setar campos

    $estado = mysqli_real_escape_string( $db_con, $_POST['estado'] );
    $nome = mysqli_real_escape_string( $db_con, $_POST['nome'] );

    // Checar Erros

    $checkerrors = 0;
    $errormessage = array();

      // -- Estado

      if( !$estado ) {
        $checkerrors++;
        $errormessage[] = "O estado não pode ser nulo";
      }

      // -- Nome

      if( !$nome ) {
        $checkerrors++;
        $errormessage[] = "O nome não pode ser nulo";
      }

    // Executar registro

    if( !$checkerrors ) {

      if( new_cidade( $estado,$nome ) ) {

        header("Location: index.php?msg=sucesso");

      } else {

        header("Location: index.php?msg=erro");

      }

    }

  }
  
?>

<div class="middle minfit bg-gray">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

        <div class="title-icon pull-left">
          <i class="lni lni-pin"></i>
          <span>Adicionar cidade</span>
        </div>

        <div class="bread-box pull-right">
          <div class="bread">
            <a href="<?php admin_url(); ?>"><i class="lni lni-home"></i></a>
            <span>/</span>
            <a href="<?php admin_url(); ?>/cidades">Cidades</a>
            <span>/</span>
            <a href="<?php admin_url(); ?>/cidades/adicionar">Adicionar</a>
          </div>
        </div>
        
			</div>

		</div>

		<!-- Content -->

		<div class="data box-white mt-16">

      <form id="the_form" class="form-default" method="POST" enctype="multipart/form-data">

          <div class="row">

            <div class="col-md-12">

              <?php if( isset($checkerrors) ) { list_errors(); } ?>

              <?php if( isset($_GET['msg']) == "erro" ) { ?>

                <?php modal_alerta("Erro, tente novamente!","erro"); ?>

              <?php } ?>

              <?php if( isset($_GET['msg']) == "sucesso" ) { ?>

                <?php modal_alerta("Cadastro efetuado com sucesso!","sucesso"); ?>

              <?php } ?>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Estado:</label>
                  <div class="fake-select">
                    <i class="lni lni-chevron-down"></i>
                    <select id="input-estado" name="estado">

                        <option value="">Estado</option>
                        <?php 
                        $quicksql = mysqli_query( $db_con, "SELECT * FROM estados ORDER BY nome ASC LIMIT 999" );
                        while( $quickdata = mysqli_fetch_array( $quicksql ) ) {
                        ?>

                          <option <?php if( isset($_POST['estado']) == $quickdata['id'] ) { echo "SELECTED"; }; ?> value="<?php echo $quickdata['id']; ?>"><?php echo $quickdata['nome']; ?></option>

                        <?php } ?>

                    </select>
                    <div class="clear"></div>
                </div>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Nome:</label>
                  <input type="text" id="input-nome" name="nome" placeholder="Nome" value="<?php echo htmlclean( isset($_POST['nome']) ); ?>">

              </div>

            </div>

          </div>

          <div class="row lowpadd">

          	<div class="col-md-6 col-sm-5 col-xs-5">
          		<div class="form-field form-field-submit">
  							<a href="javascript:history.back(1)" class="backbutton pull-left">
  								<span><i class="lni lni-chevron-left"></i> Voltar</span>
  							</a>
  						</div>
          	</div>

  					<div class="col-md-6 col-sm-7 col-xs-7">
  						<input type="hidden" name="formdata" value="true"/>
  						<div class="form-field form-field-submit">
  							<button class="pull-right">
  								<span>Cadastrar <i class="lni lni-chevron-right"></i></span>
  							</button>
  						</div>
  					</div>

          </div>

      </form>

		</div>

		<!-- / Content -->

	</div>

</div>

<?php 
// FOOTER
$system_footer .= "";
include('../../_layout/rdp.php');
include('../../_layout/footer.php');
?>

<script>

$(document).ready( function() {
          
  // Globais

  $("#the_form").validate({

      /* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */

      rules:{

        estado:{
        required: true
        },
        nome:{
        required: true
        }

      },
          
      /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
              
      messages:{

        estado:{
          required: "Esse campo é obrigatório"
        },
        nome:{
          required: "Esse campo é obrigatório"
        }

      }

    });

  });

</script>