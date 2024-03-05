<?php
require_once '../app/estabelecimento/pedido_delivery.php';
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Preference;
// TODO: inserir a secret key do estabelecimento

MercadoPagoConfig::setAccessToken($secret_key);

$client = new PreferenceClient();
$request_options = new RequestOptions();
$request_options->setCustomHeaders(["X-Idempotency-Key: testMP1305"]);
// TODO: criar a preferência usando os dados do pedido
$preference = $client->create([
    "items"=> array(
        array(
            "id"=> "item-ID-1234",
            "title"=> "Meu produto",
            "currency_id"=> "BRL",
            "picture_url"=> "https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
            "description"=> "Descrição do Item",
            "category_id"=> "art",
            "quantity"=> 1,
            "unit_price"=> $subtotal
        )
    ),
    "payer"=> array(
        "nome"=> $nome,
        "email"=> "user@email.com",
        "whatsapp"=> $whatsapp ,
        "identification"=> array(
            "type"=> "CPF",
            "number"=> "19119119100"
        ),
        "address"=> array(
            "estado" => $estado,
            "cidade" => $cidade,
            "endereco_cep"=> $endereco_cep,
            "endereco_numero"=> $endereco_numero,
            "endereco_bairro" => $endereco_bairro,
            "endereco_rua"=> $endereco_rua,
            "endereco_complemento" => $endereco_complemento,
            "endereco_referencia" => $endereco_referencia
        )
    ),
    "back_urls"=> array(
        "success"=> "https://www.success.com",
        "failure"=> "https://www.failure.com",
        "pending"=> "https://www.pending.com"
    ),
    "auto_return"=> "approved",
    "payment_methods"=> array(
        "excluded_payment_methods"=> array(
            array(
                "id"=> "master",
                "id" => "bolbradesco",
                "id" => "pec",
            )
        ),
        "excluded_payment_types"=> array(
            array(
                "id"=> "ticket"
            )
        ),
        "installments"=> 12
    ),
    "notification_url"=> "https://www.your-site.com/ipn",
    "statement_descriptor"=> "MEUNEGOCIO",
    "external_reference"=> "Reference_1234",
    "expires"=> true,
    "expiration_date_from"=> "2016-02-01T12:00:00.000-04:00",
    "expiration_date_to"=> "2016-02-28T12:00:00.000-04:00"
]);
echo implode($payment);


// Exemplo da documentação MP

