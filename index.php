<?php
/*
* show the guestbook form
* handle form entries 
* display the entries
*/
require_once('models/guestbook.php');

$gb = new Guestbook('');
$requiredFields = ['name', 'email', 'text'];
$filtered_input = [];
$formMessage = '';
$bool_saved = false;

if (!empty($_POST)){

  foreach ($requiredFields as $field){
    if ($field == 'email'){
      $email = filter_input(INPUT_POST, $field, FILTER_SANITIZE_EMAIL);
    }

    if ( isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
      $filtered_input[$field] = $email;
      unset($email);
      continue;
    }
    
    $save_input = filter_input(INPUT_POST, $field);
    if ( $save_input ){
      $filtered_input[$field] = $save_input;
    }
    
  }

  if ( is_array($filtered_input) && (count($filtered_input) == count($requiredFields)) ){
    $filtered_input['date'] = date('Y-m-d H:i:s');
    $gb->setValues($filtered_input);
    $bool_saved = $gb->save();
  }

  $formMessage = $bool_saved ? 'Bedankt voor uw bericht :-)' : 'Alle velden zijn verplicht!';
}
$entries = $gb->getEntries();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <script src="validation.js"></script>
  <body>
    <div class="container">
      <h1>Gastenboek</h1>
      <?= '<span class="text-message">'.$formMessage.'</span>'; ?>
      <div class="guestbook">
        <form name="guestbook" class="" method="post" onsubmit="return validateForm()">
        <div id="name-container" class="name">
          <label for="name">Naam</label><br/ >
          <input type="text" id="name" name="name">
          </div>
          <div id="email-container" class="email">
          <label class="email-input" for="email">E-mailadres</label>
          <input class="email-input" type="email" id="email" name="email">
        </div>
          <div id="message-container" class="message">
          <label for="text">Bericht</label>
          <textarea id="text" name="text"></textarea>
          <input type="submit" value="Verstuur">
          </div>
        </form>
      </div>
      <div class="entries-container">
        <div class="entries">
          <?php foreach ($entries as $entry):?>
            <div class="entry">
              <span class="entry-name"><?= htmlspecialchars($entry->name);?></span>
              <span class="entry-email"><a href="mailto:<?= htmlspecialchars($entry->email);?>" target="_blank">stuur een e-mail</a></span>
              <span class="entry-date"><?= date('d-m-Y', strtotime($entry->date));?></span>
              <span class="entry-text"><?= htmlspecialchars($entry->text);?></span>
            </div>
          <?php endforeach;?>
        </div>
      </div>
    </div>  
  </body>
</html>