<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function loadLayoutClient($path, $data = [])
{
    if (!empty($path)) {
        require_once _WEB_PATH_TEMPLATE . '/client/' . $path;
    }
}


function layout($layoutName = 'header', $dir = '', $data = [])
{

    if (!empty($dir)) {
        $dir = '/' . $dir;
    }

    if (file_exists(_WEB_PATH_TEMPLATE . $dir . '/layouts/' . $layoutName . '.php')) {
        require_once _WEB_PATH_TEMPLATE . $dir . '/layouts/' . $layoutName . '.php';
    }
}

function sendMail($to, $subject, $content)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'ndkdzvl@gmail.com';                     //SMTP username
        $mail->Password   = 'dchuzrbjuruftzrj';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ndkdzvl@gmail.com', 'Duy Kien Dev');
        $mail->addAddress($to);     //Add a recipient
        //Content
        $mail->isHTML(true);                             //Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $content;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


// kiem tra phuong thuc
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }

    return false;
}

function getBody($method = '')
{
    $bodyArr = [];

    if (empty($method)) {
        if (isGet()) {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if (isPost()) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    } else {
        if ($method == 'get') {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        } elseif ($method == 'post') {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    }
    return $bodyArr;
}

// viet ham xu ly email
function isEmail($email)
{
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

function isNumberInt($number, $range = [])
{
    /*
     * $range = ['min_range'=>1, 'max_range'=>20];
     *
     * */
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $options);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    }

    return $checkNumber;
}

//Kiểm tra số thực
function isNumberFloat($number, $range = [])
{
    /*
     * $range = ['min_range'=>1, 'max_range'=>20];
     *
     * */
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT, $options);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    }

    return $checkNumber;
}

function isPhone($phone)
{
    $pattern = '/^0[0-9]{9}$/';
    if (preg_match($pattern, $phone)) {
        return true;
    }

    return false;
}

function getMsg($msg, $msgType = 'danger')
{
    if (!empty($msg)) {
        echo '<div class="alert alert-' . $msgType . '">';
        echo $msg;
        echo '</div>';
    }
}

function redirect($path = 'index.php')
{
    header("Location: $path");
    exit;
}

function oldData($fieldName, $oldData, $default = null)
{
    return !empty($oldData[$fieldName]) ? $oldData[$fieldName] : $default;
}

function errorData($fieldName, $errorArr)
{
    return !empty($errorArr[$fieldName]) ? $errorArr[$fieldName] : false;
}

function isLogin()
{
    $checkLogin = false;
    if (!empty(getSession('login_token'))) {
        $loginToken = getSession('login_token');
        $tokenQuery = firstRaw("SELECT client_id FROM login_token WHERE token='$loginToken'");
        if (!empty($tokenQuery)) {
            $checkLogin = $tokenQuery;
        } else {
            removeSession('login_token');
        }
    } else {
        removeSession('login_token');
    }

    return $checkLogin;
}


function autoRemoveTokenLogin()
{
    $allClientNum = getRaw("SELECT * FROM client WHERE status = 1");

    if (!empty($allClientNum)) {
        foreach ($allClientNum as $client) {
            $now = date('Y-m-d H:i:s');
            $beforeTime = $client['last_activity'];
            $diff = strtotime($now) - strtotime($beforeTime) . '<br/>';
            $diff = intval($diff);
            $diff = ($diff / 60);
            if ($diff > 15) {
                delete('login_token', 'client_id=' . $client['id']);
            }
        }
    }
}

function getClientinfor($client_id)
{
    $clientInfor = firstRaw("SELECT * FROM client WHERE id=$client_id");
    return $clientInfor;
}

function getOption($key, $type = '')
{
    $sql = "SELECT * FROM options WHERE opt_key='$key'";
    $options = firstRaw($sql);
    if (!empty($options)) {
        if ($type == 'label') {
            return $options['name'];
        }

        return $options['opt_value'];
    }

    return false;
}