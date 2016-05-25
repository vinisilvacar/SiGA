<?php

/**
 ***** SecretaryEmailNotification class(on /data_types/notification/emails/SecretaryEmailNotification) test class.
 *
 *
 * Provide unit tests for the SecretaryEmailNotification class .
 * To access the report generated by these tests, type on the URL: '../secretary_email_notification_test'
 */

require_once(MODULESPATH."/test/controllers/TestCase.php");
require_once(MODULESPATH."/notification/domain/emails/SecretaryEmailNotification.php");
require_once(MODULESPATH."/notification/exception/EmailNotificationException.php");

class SecretaryEmailNotification_Test extends TestCase{

    public function __construct(){
        parent::__construct($this);
    }
   

    public function getEmailDefaultInformation(){

        $id = 1;
        $userName = "Joao";
        $userEmail = "joao@joao.com";

        $user = new User($id, $userName, FALSE, $userEmail, FALSE, FALSE, FALSE);

        $quantityOfGuestUsers =  1;
        $quantityOfDocumentsRequest = 1;
        
        $message = "Olá, <b>{$userName}</b>. <br>";
            $message = $message."Esta é uma mensagem automática para informar a situação atual da Secretaria Acadêmica. <br>";
            $message = $message."Há <b>".$quantityOfGuestUsers."</b> usuários sem matrícula em um curso. <br>";
            $message = $message."Há <b>".$quantityOfDocumentsRequest."</b> documentos solicitados. <br>"; 

        $emailInfo = array();

        $emailInfo['user'] = $user;
        $emailInfo['quantityOfGuestUsers'] = $quantityOfGuestUsers;
        $emailInfo['quantityOfDocumentsRequest'] = $quantityOfDocumentsRequest;
        $emailInfo['subject'] = SecretaryEmailNotification::SECRETARY_SUBJECT;
        $emailInfo['message'] = $message;       

        return $emailInfo;
    }

    public function shouldReturnEmailInformation(){

        $emailInfo = $this->getEmailDefaultInformation();
        $user = $emailInfo['user'];
        $guestUsers = $emailInfo['quantityOfGuestUsers'];
        $documentsRequest = $emailInfo['quantityOfDocumentsRequest'];
        $notes = "";
        try{
            $email = new SecretaryEmailNotification($user, $guestUsers, $documentsRequest);
            $notes = "Criou";
        }
        catch (EmailNotificationException $e){
            $notes = "<b>Thrown Exception:</b> <i>".get_class($e)."</i> - ".$e->getMessage();
        }
        
        $test_name = "Test if return the receiver name.";
        $this->unit->run($email->getReceiverName(), $user->getName(), $test_name, $notes);

        $test_name = "Test if return the receiver email.";
        $this->unit->run($email->getReceiverEmail(), $user->getEmail(), $test_name, $notes);
       
        $test_name = "Test if return the sender name.";
        $this->unit->run($email->getSenderName(), EmailConstants::SENDER_NAME, $test_name, $notes);

        $test_name = "Test if return the sender email.";
        $this->unit->run($email->getSenderEmail(), EmailConstants::SENDER_EMAIL, $test_name, $notes);

        $test_name = "Test if return the quantity of guest users.";
        $this->unit->run($email->getGuestUsers(), $guestUsers, $test_name, $notes);    

        $test_name = "Test if return the quantity of documents request.";
        $this->unit->run($email->getDocumentsRequest(), $documentsRequest, $test_name, $notes);         

        $test_name = "Test if return the subject.";
        $this->unit->run($email->getSubject(), $emailInfo['subject'], $test_name, $notes);

        $test_name = "Test if return the message.";
        $this->unit->run($email->getMessage(), $emailInfo['message'], $test_name, $notes);
    }

    public function shouldReturnExceptionWithNullGuestUsers(){
        
        $emailInfo = $this->getEmailDefaultInformation();
        $user = $emailInfo['user'];
        $guestUsers = NULL;
        $documentsRequest = $emailInfo['quantityOfDocumentsRequest'];
        $notes = "";
        try{
            $email = new SecretaryEmailNotification($user, $guestUsers, $documentsRequest);
            $notes = "Criou";
        }
        catch (EmailNotificationException $e){
            $email = FALSE;
            $notes = "<b>Thrown Exception:</b> <i>".get_class($e)."</i> - ".$e->getMessage();
        }
        
        $test_name = "Test if return the null guest users.";
        $this->unit->run($email, 'is_false', $test_name, $notes);
    }

    public function shouldReturnExceptionWithNullDocumentsRequest(){
        
        $emailInfo = $this->getEmailDefaultInformation();
        $user = $emailInfo['user'];
        $guestUsers = $emailInfo['quantityOfGuestUsers'];
        $documentsRequest = NULL;
        $notes = "";
        try{
            $email = new SecretaryEmailNotification($user, $guestUsers, $documentsRequest);
            $notes = "Criou";
        }
        catch (EmailNotificationException $e){
            $email = FALSE;
            $notes = "<b>Thrown Exception:</b> <i>".get_class($e)."</i> - ".$e->getMessage();
        }
        
        $test_name = "Test if return the null guest users.";
        $this->unit->run($email, 'is_false', $test_name, $notes);
    }

}