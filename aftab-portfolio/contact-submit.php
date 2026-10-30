<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/config/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
    { 
        header('Location: ' . url('contact.php'), true, 303); 
        exit; 
    }
if (!hash_equals($_SESSION['csrf_token'] ?? '', (string)($_POST['csrf_token'] ?? ''))) 
    { 
        http_response_code(400); 
        exit('Invalid form request. Please return to the contact page and try again.'); 
    }
// Consume the token so an accidental refresh cannot resubmit the same request.
unset($_SESSION['csrf_token']);
if (!empty($_POST['website'])) 
    { 
        header('Location: ' . url('contact.php'), true, 303); 
        exit; 
    }
$form = ['name'=>trim((string)($_POST['name'] ?? '')), 'email'=>trim((string)($_POST['email'] ?? '')), 'subject'=>trim((string)($_POST['subject'] ?? '')), 'budget'=>trim((string)($_POST['budget'] ?? '')), 'message'=>trim((string)($_POST['message'] ?? ''))];
$errors = [];
if ($form['name'] === '' || mb_strlen($form['name']) > 100) $errors['name'] = 'Enter your name (up to 100 characters).';
if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($form['email']) > 190) $errors['email'] = 'Enter a valid email address.';
if ($form['subject'] === '' || mb_strlen($form['subject']) > 150) $errors['subject'] = 'Select a service or subject.';
if ($form['message'] === '' || mb_strlen($form['message']) > 5000) $errors['message'] = 'Enter a message of up to 5,000 characters.';

if ($errors) 
    { 
        $_SESSION['contact_form']=$form;
        $_SESSION['contact_errors']=$errors; 
        header('Location: '.url('contact.php'), true, 303);
        exit; 
    }
    try { 
        require_once __DIR__ . '/config/database.php';
        
        $statement = database()->prepare('INSERT INTO contact_messages 
        (name,email,subject,budget,message) VALUES 
        (:name,:email,:subject,:budget,:message)'); 
        $statement->execute($form); $_SESSION['contact_success'] = 'Thank you—your message has been saved successfully. I will review it soon.'; 
    } 
    catch (PDOException $exception) 
    { 
        error_log('Portfolio contact storage error: '.$exception->getMessage());
        $_SESSION['contact_form']=$form; $_SESSION['contact_errors']=['message'=>'Your message could not be saved right now. Please try again later.']; 
    }

header('Location: '.url('contact.php'), true, 303);
