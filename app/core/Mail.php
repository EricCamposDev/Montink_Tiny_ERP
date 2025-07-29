<?php


    namespace App\Core;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mail {
        private $stmt;
        public function __construct()
        {
            $this->stmt = new PHPMailer((APP_ENV == 'DEV'));
            $this->stmt->isSMTP();
            $this->stmt->Host = SMTP_HOST;
            $this->stmt->SMTPAuth = true;
            $this->stmt->Port = SMTP_PORT;
            $this->stmt->Username = SMTP_USERNAME;
            $this->stmt->Password = SMTP_PASSWORD;
        }

        public function template($templateName, $keyWords): Mail
        {
            $this->stmt->CharSet = 'UTF-8';
            $this->stmt->ContentType = 'text/html';

            $maiilBody = file_get_contents(__DIR__. '/../views/mail/' . $templateName . '.html');

            foreach($keyWords as $key => $word){
                $maiilBody = str_replace('{{'.$key.'}}', $word, $maiilBody);
            }

            $this->stmt->Body = $maiilBody;
            $this->stmt->isHTML(true);
            return $this;
        }

        public function sendTo($name, $email, $subject)
        {
            $this->stmt->Subject = $subject;
            $this->stmt->addAddress($email, $name);
            $this->stmt->setFrom(APP_MAILER_ADDRESS, APP_MAILER_NAME);
            $this->stmt->send();
        }
    }

