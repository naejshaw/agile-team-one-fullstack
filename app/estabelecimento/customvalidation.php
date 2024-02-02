<?php
$variacao = json_decode($data_content['variacao'], TRUE);
$rules = [];
$messages = [];

for ($x = 0; $x < count($variacao); $x++) {
    $rules[] = "variacao[" . $x . "]: {";
    if ($variacao[$x]['escolha_minima'] >= "1") {
        $rules[] = "required: true,";
    }
    $rules[] = "minlength: " . htmljson($variacao[$x]['escolha_minima']) . ",";
    $rules[] = "maxlength: " . htmljson($variacao[$x]['escolha_maxima']);
    $rules[] = "}";

    $messages[] = "variacao[" . $x . "]: {";
    if ($variacao[$x]['escolha_minima'] >= "1") {
        $messages[] = "required: 'Esse campo é obrigatório',";
    }
    $messages[] = "minlength: 'Você deve escolher ao menos " . htmljson($variacao[$x]['escolha_minima']) . " itens',";
    $messages[] = "maxlength: 'Você deve escolher no máximo " . htmljson($variacao[$x]['escolha_maxima']) . " itens'";
    $messages[] = "}";
}

?>
form.validate({
    focusInvalid: true,
    invalidHandler: function () {
    },
    errorPlacement: function errorPlacement(error, element) {
        element.after(error);
    },
    rules: {
        <?php echo implode("", $rules); ?>
    },
    messages: {
        <?php echo implode("", $messages); ?>
    }
});
