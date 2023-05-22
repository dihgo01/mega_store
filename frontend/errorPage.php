<?php
    $code = $_SERVER['REDIRECT_STATUS'];
?>
<!doctype html>
<html lang="pt-BR" class="js">
<head>
<!-- META TAGS -->
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='author' content='' />
<meta name='creator' content='' />
<meta name='copyright' content='' />
<meta name='url' content='' />
<meta name='language' content='pt-BR' />
<meta name='robots' content='noindex,nofollow' />
<link rel='alternate' href='' hreflang='pt-BR' />
<link rel='canonical' href='' />
<!-- META TAGS -->

<!-- TITULO, KEYWORDS E DESCRIPTION -->
<title>Quinta Valentina - Erro <?php echo $code; ?></title>
<meta name='keywords' content='Quinta, Valentina, Sapatos, Bolsas, Franquia' />
<meta name='description' content='Intranet da Franqueadora Quinta Valentina.' />
<!-- TITULO, KEYWORDS E DESCRIPTION -->

<!-- FAVICON -->
<link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/images/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
<link rel="manifest" href="/images/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/images/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<!-- FAVICON -->

<!-- CSS -->
<link rel="stylesheet" href="/assets/css/dashlite.css?ver=3.0.2">
<link rel="stylesheet" href="/assets/css/libs/fontawesome-icons.css?ver=3.0.2">
<link rel="stylesheet" href="/assets/css/qv-custom.css?ver=3.0.2">
<!-- CSS -->
</head>

<body class="nk-body bg-white npc-general pg-error">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <?php
                $codes = array(
                    400 => 'Bad Request',
                    401 => 'Autenticação Requerida',
                    403 => 'Forbidden',
                    404 => 'Not Found',
                    500 => 'Internal Server Error'
                );
                $source_url = 'http'.((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                if(array_key_exists($code, $codes) && is_numeric($code)) {
                    if($code == '400') {
                        echo '
                            <div class="nk-content">
                                <div class="nk-block nk-block-middle wide-xs mx-auto">
                                    <div class="nk-block-content nk-error-ld text-center">
                                        <h1 class="nk-error-head">'.$code.'</h1>
                                        <h3 class="nk-error-title">Oops! Why you\’re here?</h3>
                                        <p class="nk-error-text">We are very sorry for inconvenience. It looks like you\’re try to access a page that either has been deleted or never existed.</p>
                                        <a href="https://'.$_SERVER['HTTP_HOST'].'" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>                            
                        ';
                    } elseif($code == '401') {
                        echo '
                            <div class="nk-content">
                                <div class="nk-block nk-block-middle wide-xs mx-auto">
                                    <div class="nk-block-content nk-error-ld text-center">
                                        <h1 class="nk-error-head">'.$code.'</h1>
                                        <h3 class="nk-error-title">'.$codes[$code].'</h3>
                                        <p class="nk-error-text">We are very sorry for inconvenience. It looks like you\’re try to access a page that either has been deleted or never existed.</p>
                                        <a href="https://'.$_SERVER['HTTP_HOST'].'" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>                           
                        ';
                    } elseif($code == '403') {
                        echo '
                            <div class="nk-content">
                                <div class="nk-block nk-block-middle wide-xs mx-auto">
                                    <div class="nk-block-content nk-error-ld text-center">
                                        <h1 class="nk-error-head">'.$code.'</h1>
                                        <h3 class="nk-error-title">'.$codes[$code].'</h3>
                                        <p class="nk-error-text">We are very sorry for inconvenience. It looks like you\’re try to access a page that either has been deleted or never existed.</p>
                                        <a href="https://'.$_SERVER['HTTP_HOST'].'" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>                           
                        ';
                    } elseif($code == '404') {
                        echo '
                            <div class="nk-content">
                                <div class="nk-block nk-block-middle wide-md mx-auto">
                                    <div class="nk-block-content nk-error-ld text-center">
                                        <img class="nk-error-gfx" src="/images/gfx/error-404.svg" alt="">
                                        <div class="wide-xs mx-auto">
                                            <h3 class="nk-error-title">'.$codes[$code].'</h3>
                                            <p class="nk-error-text">We are very sorry for inconvenience. It looks like you\’re try to access a page that either has been deleted or never existed.</p>
                                            <a href="https://'.$_SERVER['HTTP_HOST'].'" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>                        
                        ';
                    } elseif($code == '500') {
                        echo '
                            <div class="nk-content">
                                <div class="nk-block nk-block-middle wide-xs mx-auto">
                                    <div class="nk-block-content nk-error-ld text-center">
                                        <h1 class="nk-error-head">'.$code.'</h1>
                                        <h3 class="nk-error-title">'.$codes[$code].'</h3>
                                        <p class="nk-error-text">We are very sorry for inconvenience. It looks like you\’re try to access a page that either has been deleted or never existed.</p>
                                        <a href="https://'.$_SERVER['HTTP_HOST'].'" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>                          
                        ';
                    } else {
                        echo '
                            <div class="nk-content">
                                <div class="nk-block nk-block-middle wide-xs mx-auto">
                                    <div class="nk-block-content nk-error-ld text-center">
                                        <h1 class="nk-error-head">'.$code.'</h1>
                                        <h3 class="nk-error-title">Erro Desconhecido</h3>
                                        <p class="nk-error-text">We are very sorry for inconvenience. It looks like you\’re try to access a page that either has been deleted or never existed.</p>
                                        <a href="https://'.$_SERVER['HTTP_HOST'].'" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>                      
                        ';
                    }

                }
                ?>

                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
</body>
</html>