function checkBody(body) {
    let firstLetterFormat = /^[\p{Lu}0-9]$/u;
    if (body.value.length === 0) {
        return ["gray", ""];
    }
    if (body.value.trim().length === 0) {
        return ["red", "Text recenzie nemôže obsahovať len medzery!"]
    }
    if (!firstLetterFormat.test(body.value.charAt(0))) {
        return ["red", "Recenzia musí začínať veľkým písmenom alebo číslicou!"]
    }
    if (body.value.length < 10) {
        return ["red", "Text recenzie musí mať aspoň 10 znakov!"]
    }
    return ["lightgreen", ""];
}

function checkRating(rating) {
    if (rating === "") {
        return ["red", "Hodnotenie je povinné pole!"];
    }
    return ["lightgreen", ""];
}

function checkForm() {
    let valid = true;
    const reviewBody = document.getElementById('reviewBody');
    const selected = document.querySelector('input[name="rating"]:checked');
    const ratingValue = selected ? selected.value : document.getElementById('noStar').value;
    const reviewBodyMessage = document.getElementById('reviewBodyMessage');
    const ratingMessage = document.getElementById('ratingMessage');

    const resultBody = checkBody(reviewBody);
    const resultRating = checkRating(ratingValue);

    updateOutput(reviewBody, reviewBodyMessage, resultBody[0], resultBody[1]);
    if (ratingMessage) ratingMessage.textContent = resultRating[1];
    if (resultBody[0] === "red" || resultRating[0] === "red") {
        valid = false;
    }
    return valid;
}

window.addEventListener('DOMContentLoaded', function() {
    const sending = document.getElementById('reviewForm');
    if (sending) {
        sending.addEventListener('submit',  function (event) {
            event.preventDefault();
            const valid = checkForm();
            if (valid) {
                sending.submit();
            }
        });
    }
    const reviewBody = document.getElementById('reviewBody');
    const reviewBodyMessage = document.getElementById('reviewBodyMessage');

    reviewBody.addEventListener("input", function() {
        const resultBody = checkBody(reviewBody);
        updateOutput(reviewBody, reviewBodyMessage, resultBody[0], resultBody[1]);
    })
});

function updateOutput(element, elementMessage, color, message) {
    if (element) element.style.borderColor = color;
    if (elementMessage) elementMessage.textContent = message;
}
