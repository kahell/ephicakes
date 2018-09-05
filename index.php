<?php
require __DIR__ . '/vendor/autoload.php';

use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use \LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use \LINE\LINEBot\SignatureValidator as SignatureValidator;

// set false for production
$pass_signature = true;

// set LINE channel_access_token and channel_secret
$channel_access_token = "nAl+XgsShVSZuYgGwH4GRETML3qh+/JLheMqQnZ66RDySMc840Vqo3JO1ixDx3BZEJQROteHx86CQN3hf4rnxDs5KsnhZHdp28TKnd3p52Kx97En8UBM1ff1Qxze8t8lO3CerBxhWy1TdaiqjNnlewdB04t89/1O/w1cDnyilFU=";
$channel_secret = "2e32b81013d0a6ef5ff4ddd506fd4fd5";

// inisiasi objek bot
$httpClient = new CurlHTTPClient($channel_access_token);
$bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);

$configs =  [
    'settings' => ['displayErrorDetails' => true],
];
$app = new Slim\App($configs);

// buat route untuk url homepage
$app->get('/', function($req, $res)
{
  echo "Welcome at Slim Framework";
});

// buat route untuk webhook
$app->post('/webhook', function ($request, $response) use ($bot, $pass_signature)
{
    // get request body and line signature header
    $body        = file_get_contents('php://input');
    $signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '';

    // log body and signature
    file_put_contents('php://stderr', 'Body: '.$body);

    if($pass_signature === false)
    {
        // is LINE_SIGNATURE exists in request header?
        if(empty($signature)){
            return $response->withStatus(400, 'Signature not set');
        }

        // is this request comes from LINE?
        if(! SignatureValidator::validateSignature($body, $channel_secret, $signature)){
            return $response->withStatus(400, 'Invalid signature');
        }
    }

    // Kode aplikasi disini
    $data = json_decode($body, true);
    if(is_array($data['events'])){
        foreach ($data['events'] as $event)
        {
            if ($event['type'] == 'message')
            {
                if($event['message']['type'] == 'text')
                {
                    // send same message as reply to user
                    // $result = $bot->replyText($event['replyToken'], $event['message']['text']);

                    // or we can use replyMessage() instead to send reply message
                    // $textMessageBuilder = new TextMessageBuilder($event['message']['text']);
                    // $result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);

                    /* Send sticker message
                    * List $packageId dan $stickerId https://developers.line.me/media/messaging-api/messages/sticker_list.pdf
                    *  $stickerId = 3;
                    * $packageId = 1;
                    * $stickerMessageBuilder = new StickerMessageBuilder($packageId, $stickerId);
                    * $bot->replyMessage($replyToken, $stickerMessageBuilder);
                    */

                    /* Send Image message
                    * add that code to top use \LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
                    * $imageMessageBuilder = new ImageMessageBuilder('url gambar asli', 'url gambar preview');
                    * $bot->replyMessage($replyToken, $imageMessageBuilder);
                    */

                    /* Send audio message
                    * use \LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
                    * $audioMessageBuilder = new AudioMessageBuilder('url audio asli', 'durasi audio');
                    * $bot->replyMessage($replyToken, $audioMessageBuilder);
                    */

                    /* Send Video Message
                    * use \LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
                    * $videoMessageBuilder = new VideoMessageBuilder('url video asli', 'url gambar preview video');
                    * $bot->replyMessage($replyToken, $videoMessageBuilder);
                    */
                    $multiMessageBuilder = new MultiMessageBuilder();
                    if (strpos($event['message']['text'], '1') !== false) {
                      $textMessageBuilder1 = new TextMessageBuilder("Python Cakes - 38.000\n Python cakes adalah kueh berbentuk logo python yang dibuat menggunakan coklat pilihan
                      dan kacang almond yang lezat");
                      $textMessageBuilder2 = new TextMessageBuilder("Silahkan order dengan template sebagai berikut: \n
                      Nama: \nAlamat\nNomor HP\nJumlah Pesanan\nKirim ke nomor rekening 0000-01-0000000-129, A/n. Helfi Pangestu\n
                      Ketika sudah transfer silahkan konfirmasi dengan ketik: konfirmasi");

                      $multiMessageBuilder->add($textMessageBuilder1);
                      $multiMessageBuilder->add($textMessageBuilder2);
                    }elseif (strpos($event['message']['text'], '2') !== false) {
                      $textMessageBuilder1 = new TextMessageBuilder("Java Cakes - 68.000\n Java cakes adalah kueh berbentuk logo java yang dibuat menggunakan storowbery pilihan
                      dan dibalut dengan keju yang sangat lezat");
                      $textMessageBuilder2 = new TextMessageBuilder("Silahkan order dengan template sebagai berikut: \n
                      Nama: \nAlamat\nNomor HP\nJumlah Pesanan\nKirim ke nomor rekening 0000-01-0000000-129, A/n. Helfi Pangestu\n
                      Ketika sudah transfer silahkan konfirmasi dengan ketik: konfirmasi");

                      $multiMessageBuilder->add($textMessageBuilder1);
                      $multiMessageBuilder->add($textMessageBuilder2);
                    }elseif (strpos($event['message']['text'], '3') !== false) {
                      $textMessageBuilder1 = new TextMessageBuilder("PHP Cakes - 68.000\n PHP cakes adalah kueh berbentuk logo PHP yang dibuat menggunakan coklat dan strowbery pilihan
                      dan diberikan taburan blueberry segar pilihan");
                      $textMessageBuilder2 = new TextMessageBuilder("Silahkan order dengan template sebagai berikut: \n
                      Nama: \nAlamat\nNomor HP\nJumlah Pesanan\nKirim ke nomor rekening 0000-01-0000000-129, A/n. Helfi Pangestu\n
                      Ketika sudah transfer silahkan konfirmasi dengan ketik: konfirmasi");

                      $multiMessageBuilder->add($textMessageBuilder1);
                      $multiMessageBuilder->add($textMessageBuilder2);
                    }elseif (strpos($event['message']['text'], 'konfirmasi') !== false) {
                      $textMessageBuilder1 = new TextMessageBuilder("Terimakasih sudah mentransfer. Kami akan mengecek pengiriman anda dan kemudian akan mengirimkan anda konfirmasi melalu nomor HP anda.
                      Paling lambat 1x24 jam.\n
                      Jika belum menerima balasan dari kami 1x24 jam silahkan hubungi kami melalui cs@ephicakes.com");

                      $multiMessageBuilder->add($textMessageBuilder1);
                    }else{
                      // send multiple message
                      $textMessageBuilder1 = new TextMessageBuilder('Selamat datang di ephi cake, Ephi Cake adalah toko kue yang memiliki tema programmer!');
                      $textMessageBuilder2 = new TextMessageBuilder("Kami memilik variasi menu! \n 1. Python Cakes\n 2. Java Cakes\n 3. PHP Cakes");
                      $textMessageBuilder3 = new TextMessageBuilder('Jika ingin pesan silahkan ketik: pesan 1 (1,2, atau 3)');
                      $stickerMessageBuilder = new StickerMessageBuilder(1, 106);

                      $multiMessageBuilder->add($textMessageBuilder1);
                      $multiMessageBuilder->add($textMessageBuilder2);
                      $multiMessageBuilder->add($textMessageBuilder3);
                      $multiMessageBuilder->add($stickerMessageBuilder);
                    }

                    $bot->replyMessage($event['replyToken'], $multiMessageBuilder);

                    return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                }
            }
        }
    }

});

$app->run();
