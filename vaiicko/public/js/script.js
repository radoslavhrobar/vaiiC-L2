function checkEmail(email) {
    let format = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (email.value === "") {
        return ["red", additionalTexts.get(idElements[0])]
    } else if (!format.test(email.value)) {
        return ["red", "Email musí byť v správnom formáte!"]
    } else {
        return ["lightgreen", ""]
    }
}
function checkUsername(username) {
    if (username.value === "") {
        return ["red", additionalTexts.get(idElements[1])]
    } else if (username.value.length < 3 || username.value.length > 30) {
        return ["red", "Používateľské meno musí byť dlhé v rozmedzí od 3 do 30 znakov!"]
    } else if (!isNaN(username.value.charAt(0))) {
        return ["red", "Prvý znak v používateľskom mene niesme byť číslica!"]
    } else if (/[^a-zA-Z0-9]/.test(username.value)) {
        return ["red", "Používateľské meno môže obsahovať len alfanumerické znaky a musí byť bez medzier!"]
    } else {
        return ["lightgreen", ""]
    }
}
function checkPassword(password) {
    if (password.value === "") {
        return ["red", additionalTexts.get(idElements[2])]
    } else if (password.value.length < 8) {
        return ["red", "Heslo musí byť minimálne 8 znakov dlhé!"]
    } else if (!/[A-Z]/.test(password.value)) {
        return ["red", "Heslo musí obsahovať aspoň jedno veľké písmeno!"]
    } else if (!/[a-z]/.test(password.value)) {
        return ["red", "Heslo musí obsahovať aspoň jedno malé písmeno!"]
    } else if (!/[0-9]/.test(password.value)) {
        return ["red", "Heslo musí obsahovať aspoň jednu číslicu!"]
    } else if (!/[!@#$%^&*]/.test(password.value)) {
        return ["red", "Heslo musí obsahovať aspoň jeden zo špeciálnych znakov na výber! [!@#$%^&*]"]
    } else {
        return ["lightgreen", ""]
    }
}
function checkVerifyPassword(verifyPassword, password) {
    if (verifyPassword.value === "") {
        return ["red", additionalTexts.get(idElements[3])]
    } else if (verifyPassword.value !== password.value) {
        return ["red", "Heslá sa musia zhodovať!"]
    } else {
        return ["lightgreen", ""]
    }
}
function checkPersonal(personal) {
    let format = /^[a-zA-ZáäčďéëíĺľňóöôřšťúüýžÁÄČĎÉËÍĹĽŇÓÖÔŘŠŤÚÜÝŽ]+$/u
    if (personal.value === "") {
        return ["gray", ""]
    } else if (personal.value.length > 30) {
        return ["red", (personal.id === idElements[4] ? "Meno" : "Priezvisko") + " nesmie prekročiť dĺžku 30 znakov!"]
    } else if (!format.test(personal.value)) {
        return ["red", (personal.id === idElements[4] ? "Meno" : "Priezvisko") + " môže obsahovať iba písmená!"]
    } else if (personal.value.charAt(0) !== personal.value.charAt(0).toUpperCase()) {
        return ["red", (personal.id === idElements[4] ? "Meno" : "Priezvisko") + " musí začínať veľkým písmenom!"]
    } else {
        return ["lightgreen", ""]
    }
}

function checkForm() {
    let valid = true;
    let resultEmail = checkEmail(document.getElementById(idElements[0]));
    let resultUsername = checkUsername(document.getElementById(idElements[1]));
    let resultPassword = checkPassword(document.getElementById(idElements[2]));
    let resultVerifyPassword = checkVerifyPassword(document.getElementById(idElements[3]), document.getElementById(idElements[2]));
    let resultName = checkPersonal(document.getElementById(idElements[4]));
    let resultSurname = checkPersonal(document.getElementById(idElements[5]));

    let resultElements = [resultEmail, resultUsername, resultPassword, resultVerifyPassword, resultName, resultSurname]
    resultElements.forEach(function(result, i) {
        let element = document.getElementById(idElements[i]);
        let elementMessage = document.getElementById(idMessages[i]);
        updateOutput(element, elementMessage, result[0], result[1])

        if (result[0] === "red") {
            valid = false;
        }
    })
    return valid;
}

function apply(idElement, idMessage, controlFunction, input, focusout) {
    let element = document.getElementById(idElement)
    let elementMessage = document.getElementById(idMessage);

    if (input) {
        element.addEventListener("input", function() {
            let attributes = idElement !== idElements[3] ? controlFunction(element) : controlFunction(element, document.getElementById(idElements[2]))
            updateOutput(element, elementMessage, attributes[0], attributes[1])
        })
    }

    if (focusout) {
        element.addEventListener("focusout", function() {
            if (element.value === "") {
                updateOutput(element, elementMessage, "red", additionalTexts.get(idElement))
            }
        })
    }
}

let sending = document.getElementById("registration")
sending.addEventListener("submit", function(event) {
    if (!checkForm()) {
        event.preventDefault();
        alert("Formulár obsahuje chyby. Skontrolujte prosím všetky údaje.")
    }
})

function updateOutput(element, elementMessage, color, message) {
    element.style.borderColor = color;
    elementMessage.textContent = message;
}

const idElements = ["email", "username", "password", "verifyPassword", "name", "surname"];
const idMessages = ["emailMessage", "usernameMessage", "passwordMessage", "verifyPasswordMessage", "nameMessage", "surnameMessage"];
const additionalTexts = new Map([[idElements[0], "Zadaj email."], [idElements[1],"Zadaj používateľské meno."], [idElements[2], "Zadaj heslo."], [idElements[3], "Zadaj kontrolu hesla."]])


apply(idElements[0], idMessages[0], checkEmail, true,true);
apply(idElements[1], idMessages[1], checkUsername, true, true);
apply(idElements[2], idMessages[2], checkPassword, true, true);
apply(idElements[3], idMessages[3], checkVerifyPassword, true, true);
apply(idElements[4], idMessages[4], checkPersonal, true, false);
apply(idElements[5], idMessages[5], checkPersonal, true, false);
