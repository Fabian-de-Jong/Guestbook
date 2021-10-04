// validate form fields
function validateForm() {
    var isValid = true;
    
    var emailContainer = document.getElementById("email-container");
    emailContainer.setAttribute("class", "email");
    let emailValue = document.forms["guestbook"]["email"].value;
    if (emailValue == "") {
      emailContainer.setAttribute("class", "email required");
      isValid = false;
    }

    var messageContainer = document.getElementById("message-container");
    messageContainer.setAttribute("class", "message");
    let messageValue = document.forms["guestbook"]["text"].value;
    if (messageValue == "") {
      messageContainer.setAttribute("class", "message required");
      isValid = false;
    }
    
    var nameContainer = document.getElementById("name-container");
    nameContainer.setAttribute("class", "name");
    let nameValue = document.forms["guestbook"]["name"].value;
    if (nameValue == "") {
      nameContainer.setAttribute("class", "name required");
      isValid = false;
    }

    if (isValid === false){
       return false;
    }
}