async function checkEmail(email) {
    let format = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (email.value === "") {
        return ["red", additionalTexts.get(idElements[0])]
    }
    if (!format.test(email.value)) {
        return ["red", "Email musí byť v správnom formáte!"]
    }
    const exists = await serverCheckEmail(email.value);
    if (exists) {
        return ["red", "Tento email je už obsadený!"];
    }
    return ["lightgreen", ""];
}
async function checkUsername(username) {
    if (username.value === "") {
        return ["red", additionalTexts.get(idElements[1])]
    }
    if (!isNaN(username.value.charAt(0))) {
        return ["red", "Prvý znak v používateľskom mene niesme byť číslica!"]
    }
    if (/[^a-zA-Z0-9]/.test(username.value)) {
        return ["red", "Používateľské meno môže obsahovať len alfanumerické znaky a musí byť bez medzier!"]
    }
    if (username.value.length < 3 || username.value.length > 30) {
        return ["red", "Používateľské meno musí byť dlhé v rozmedzí od 3 do 30 znakov!"]
    }
    const exists = await serverCheckUsername(username.value);
    if (exists) {
        return ["red", "Toto používateľské meno je už obsadené!"];
    }
    return ["lightgreen", ""];
}

function checkPassword(password, passwordOptional) {
    if (password.value === "") {
        return passwordOptional ? ["gray", ""] : ["red", additionalTexts.get(idElements[2])]
    }
    if (!/[A-Z]/.test(password.value)) {
        return ["red", "Heslo musí obsahovať aspoň jedno veľké písmeno!"]
    }
    if (!/[a-z]/.test(password.value)) {
        return ["red", "Heslo musí obsahovať aspoň jedno malé písmeno!"]
    }
    if (!/[0-9]/.test(password.value)) {
        return ["red", "Heslo musí obsahovať aspoň jednu číslicu!"]
    }
    if (!/[!@#$%^&*]/.test(password.value)) {
        return ["red", "Heslo musí obsahovať aspoň jeden zo špeciálnych znakov na výber! [!@#$%^&*]"]
    }
    if (password.value.length < 8) {
        return ["red", "Heslo musí byť minimálne 8 znakov dlhé!"]
    }
    return ["lightgreen", ""]
}
function checkVerifyPassword(verifyPassword, password, passwordOptional) {
    if (verifyPassword.value === "") {
        return passwordOptional && password.value === "" ? ["gray", ""] : ["red", additionalTexts.get(idElements[3])]
    }
    if (verifyPassword.value !== password.value) {
        return ["red", "Heslá sa musia zhodovať!"]
    }
    return ["lightgreen", ""]
}

async function checkCurrentPassword(currentPassword, password) {
    if (currentPassword.value === "" && password.value !== "") {
        return ["red", "Zadaj aktuálne heslo pre potvrdenie zmeny hesla!"];
    }
    if (password.value !== "")  {
        const exists = await serverCheckCurrentPassword(currentPassword.value);
        if (!exists) {
            return ["red", "Aktuálne heslo nie je správne!"];
        }
        return ["lightgreen", ""];
    }
    return ["gray", ""];
}

function checkPersonal(personal) {
    let format = /^[a-zA-ZáäčďéëíĺľňóöôřšťúüýžÁÄČĎÉËÍĹĽŇÓÖÔŘŠŤÚÜÝŽ]+$/u
    if (personal.value === "") {
        return ["gray", ""]
    }
    if (personal.value.length > 80) {
        return ["red", (personal.id === idElements[4] ? "Meno" : "Priezvisko") + " nesmie prekročiť dĺžku 80 znakov!"]
    }
    if (!format.test(personal.value)) {
        return ["red", (personal.id === idElements[4] ? "Meno" : "Priezvisko") + " môže obsahovať iba písmená!"]
    }
    if (personal.value.charAt(0) !== personal.value.charAt(0).toUpperCase()) {
        return ["red", (personal.id === idElements[4] ? "Meno" : "Priezvisko") + " musí začínať veľkým písmenom!"]
    }
    return ["lightgreen", ""]
}
async function serverCheckEmail(email) {
    const id = document.getElementById('user-id') ? document.getElementById('user-id').value : null;
    const params = new URLSearchParams({email});

    if (id) {
        params.append("id", id);
    }

    const res = await fetch('/?c=auth&a=ajaxCheckEmail&' + params.toString());
    const json = await res.json();

    return json.exists;
}

async function serverCheckUsername(username) {
    const id = document.getElementById('user-id') ? document.getElementById('user-id').value : null;
    const params = new URLSearchParams({username});

    if (id) {
        params.append("id", id);
    }

    const res = await fetch('/?c=auth&a=ajaxCheckUsername&' + params.toString());
    const json = await res.json();

    return json.exists;
}

async function serverCheckCurrentPassword(currentPassword) {
    const id = document.getElementById('user-id').value;
    const params = new URLSearchParams({currentPassword});

    if (id) {
        params.append("id", id);
    }

    const res = await fetch('/?c=auth&a=ajaxCheckCurrentPassword&' + params.toString());
    const json = await res.json();

    return json.exists;
}

async function checkForm() {
    let valid = true;
    const isEdit = document.getElementById('user-edit') !== null;

    const emailEl = document.getElementById(idElements[0]);
    const usernameEl = document.getElementById(idElements[1]);
    const passwordEl = document.getElementById(idElements[2]);
    const verifyEl = document.getElementById(idElements[3]);
    const nameEl = document.getElementById(idElements[4]);
    const surnameEl = document.getElementById(idElements[5]);
    const currentPasswordEl = document.getElementById(idElements[6]);

    const resultEmail = await checkEmail(emailEl);
    const resultUsername = await checkUsername(usernameEl);
    const resultPassword = checkPassword(passwordEl, isEdit);
    const resultVerifyPassword = checkVerifyPassword(verifyEl, passwordEl, isEdit);
    let resultCurrentPassword;
    if (isEdit) {
        resultCurrentPassword = await checkCurrentPassword(currentPasswordEl, passwordEl);
    }
    const resultName = checkPersonal(nameEl);
    const resultSurname = checkPersonal(surnameEl);

    const resultElements = [resultEmail, resultUsername, resultPassword, resultVerifyPassword, resultName, resultSurname];
    if (isEdit) {
        resultElements.push(resultCurrentPassword);
    }
    resultElements.forEach(function(result, i) {
        const element = document.getElementById(idElements[i]);
        const elementMessage = document.getElementById(idMessages[i]);
        updateOutput(element, elementMessage, result[0], result[1])

        if (result[0] === "red") {
            valid = false;
        }
    })
    return valid;
}

function apply(idElement, idMessage, controlFunction, input, focusout) {
    const element = document.getElementById(idElement);
    const elementMessage = document.getElementById(idMessage);

    async function runValidation() {
        let attributes;
        const passwordOptional = document.getElementById('user-edit') !== null;
        if (idElement === idElements[0] || idElement === idElements[1]) {
            attributes = await controlFunction(element);
        } else if (idElement === idElements[2]) {
            attributes = controlFunction(element, passwordOptional);
        } else if (idElement === idElements[3]) {
            const pwdEl = document.getElementById(idElements[2]);
            attributes = controlFunction(element, pwdEl, passwordOptional);
        } else if (idElement === idElements[6]) {
            const password = document.getElementById(idElements[2]);
            attributes = await controlFunction(element, password);
        } else {
            attributes = controlFunction(element);
        }
        updateOutput(element, elementMessage, attributes[0], attributes[1]);
    }

    if (input) element.addEventListener("input", runValidation);
    if (focusout) element.addEventListener("focusout", runValidation);
}

window.addEventListener('DOMContentLoaded', function() {
    const sending = document.getElementById('registration') || document.getElementById('user-edit');
    if (sending) {
        sending.addEventListener('submit', async function (event) {
            event.preventDefault();
            const valid = await checkForm();
            if (valid) {
                sending.submit();
            }
        });
    }

    apply(idElements[0], idMessages[0], checkEmail, true,true);
    apply(idElements[1], idMessages[1], checkUsername, true, true);
    apply(idElements[2], idMessages[2], checkPassword, true, true);
    apply(idElements[3], idMessages[3], checkVerifyPassword, true, true);
    apply(idElements[4], idMessages[4], checkPersonal, true, true);
    apply(idElements[5], idMessages[5], checkPersonal, true, true);
    apply(idElements[6], idMessages[6], checkCurrentPassword, true, true);
});

function updateOutput(element, elementMessage, color, message) {
    if (element) element.style.borderColor = color;
    if (elementMessage) elementMessage.textContent = message;
}

const idElements = ["email", "username", "password", "verifyPassword", "name", "surname", "currentPassword"];
const idMessages = ["emailMessage", "usernameMessage", "passwordMessage", "verifyPasswordMessage", "nameMessage", "surnameMessage", "currentPasswordMessage"];
const additionalTexts = new Map([[idElements[0], "Zadaj email."], [idElements[1],"Zadaj používateľské meno."], [idElements[2], "Zadaj heslo."], [idElements[3], "Zadaj kontrolu hesla."]])