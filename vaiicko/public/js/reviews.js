function checkBody(body) {
    if (body.value.length === 0) {
        return ["gray", ""];
    }
    if (body.value.trim().length === 0) {
        return ["red", "Text recenzie nemôže obsahovať len medzery!"]
    }
    if (body.value.length < 10) {
        return ["red", "Text recenzie musí mať aspoň 10 znakov!"]
    }
    return ["lightgreen", ""];
}

function checkRating(rating) {
    if (rating.value === "") {
        return ["red", "Hodnotenie je povinné pole!"]
    }
    return ["lightgreen", ""];
}

function checkForm() {
    let valid = true;
    const reviewBody = document.getElementById('reviewBody');
    const rating = document.getElementById('rating');
    const reviewBodyMessage = document.getElementById('reviewBodyMessage');
    const ratingMessage = document.getElementById('ratingMessage');

    const resultBody = checkBody(reviewBody);
    const resultRating = checkRating(rating);

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
            } else {
                alert('Formulár obsahuje chyby. Skontroluj prosím všetky údaje.')
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
