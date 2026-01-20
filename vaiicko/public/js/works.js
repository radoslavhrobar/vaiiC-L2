function checkWorkName(workName) {
    let format = /^[\p{L}0-9 :,.&?'-]+$/u;
    let firstLetterFormat =  /^[\p{Lu}0-9]$/u;
    let value = workName.value.trim();
    if (value === "") {
        return ["red", additionalTexts.get(idElements[0])]
    }
    if (!firstLetterFormat.test(value.charAt(0))) {
        return ["red", "Názov musí začínať veľkým písmenom alebo číslicou!"]
    }
    if (!format.test(value)) {
        return ["red", "Názov musí byť v správnom formáte!"]
    }
    if (value.length < 2) {
        return ["red", "Názov nesmie mať menej ako 2 znaky!"]
    }
    if (value.length > 255) {
        return ["red", "Názov nesmie mať viac ako 255 znakov!"]
    }
    return ["lightgreen", ""];
}

function checkDescription(description) {
    let value = description.value.trim()
    let firstLetterFormat = /^[\p{Lu}0-9]$/u;
    if (value === "") {
        return ["red", additionalTexts.get(idElements[1])]
    }
    if (!firstLetterFormat.test(value.charAt(0))) {
        return ["red", "Popis musí začínať veľkým písmenom alebo číslicou!"]
    }
    if (value.length < 3) {
        return ["red", "Popis nesmie mať menej ako 3 znaky!"]
    }
    if (value.length > 1000) {
        return ["red", "Popis nesmie mať viac ako 1000 znakov!"]
    }
    return ["lightgreen", ""];
}

function checkImage(workImage, isEdit) {
    if (isEdit && !workImage.files[0]) {
        return ["lightgreen", ""];
    }
    if (!workImage.files[0]) {
        return ["red", "Náhľad je povinný!"];
    }
    const maxSizeInBytes = 5 * 1024 * 1024;
    if (workImage.files[0].size > maxSizeInBytes) {
        return ["red", "Obrázok nesmie byť väčší ako 5 MB!"];
    }
    return ["lightgreen", ""];
}

function checkProdCompany(prodCompany, additionalTexts, work) {
    let format =/^[\p{L}0-9 .,&'\-]+$/u;
    let firstLetterFormat = /^[\p{Lu}0-9]$/u;
    let value = prodCompany.value.trim();
    if (value === "") {
        return ["red", additionalTexts.get(work)]
    }
    if (!firstLetterFormat.test(value.charAt(0))) {
        return ["red", "Produkčná spoločnosť musí začínať veľkým písmenom alebo číslicou!"]
    }
    if (value.length > 255) {
        return ["red", "Produkčná spoločnosť nesmie mať viac ako 255 znakov!"]
    }
    if (value.length < 2) {
        return ["red", "Produkčná spoločnosť nesmie mať menej ako 2 znaky!"]
    }
    if (!format.test(value)) {
        return ["red", "Produkčná spoločnosť musí byť v správnom formáte!"]
    }
    return ["lightgreen", ""];
}

function checkDirector(director, additionalTexts, work) {
    let format =/^[\p{L} '\-]+$/u;
    let firstLetterFormat = /^\p{Lu}$/u;
    let value = director.value.trim();
    if (value === "") {
        return ["red", additionalTexts.get(work)]
    }
    if (!firstLetterFormat.test(value.charAt(0))) {
        return ["red", "Režisér musí začínať veľkým písmenom!"]
    }
    if (value.length > 255) {
        return ["red", "Režisér nesmie mať viac ako 255 znakov!"]
    }
    if (value.length < 5) {
        return ["red", "Režisér nesmie mať menej ako 5 znakov!"]
    }
    if (!format.test(value)) {
        return ["red", "Režisér musí byť v správnom formáte!"]
    }
    return ["lightgreen", ""];
}

function checkPublishers(publishers) {
    let format =/^[\p{L}0-9 .,&'\-]+$/u;
    let firstLetterFormat = /^[\p{Lu}0-9]$/u;
    let value = publishers.value.trim();
    if (value === "") {
        return ["red", additionalTextsBook.get(idElementsBook[0])]
    }
    if (!firstLetterFormat.test(value.charAt(0))) {
        return ["red", "Vydavateľstvo musí začínať veľkým písmenom alebo číslicou!"]
    }
    if (value.length > 255) {
        return ["red", "Vydavateľstvo nesmie mať viac ako 255 znakov!"]
    }
    if (value.length < 2) {
        return ["red", "Vydavateľstvo nesmie mať menej ako 2 znaky!"]
    }
    if (!format.test(value)) {
        return ["red", "Vydavateľstvo musí byť v správnom formáte!"]
    }
    return ["lightgreen", ""];
}

function checkAuthor(author) {
    let format =/^[\p{L} '\-]+$/u;
    let firstLetterFormat = /^\p{Lu}$/u;
    let value = author.value.trim();
    if (value === "") {
        return ["red", additionalTextsBook.get(idElementsBook[1])]
    }
    if (!firstLetterFormat.test(value.charAt(0))) {
        return ["red", "Autor musí začínať veľkým písmenom!"]
    }
    if (value.length > 255) {
        return ["red", "Autor nesmie mať viac ako 255 znakov!"]
    }
    if (value.length < 5) {
        return ["red", "Autor nesmie mať menej ako 5 znakov!"]
    }
    if (!format.test(value)) {
        return ["red", "Autor musí byť v správnom formáte!"]
    }
    return ["lightgreen", ""];
}

function checkSeasonsEpisodesNumLogic(numOfSeasons, numOfEpisodes) {
    const seasons = parseInt(numOfSeasons.value, 10);
    const episodes = parseInt(numOfEpisodes.value, 10);
    if (Number.isNaN(seasons) || Number.isNaN(episodes)) {
        return ["gray", ""];
    }
    const avgEpisodes = episodes / seasons;
    if (avgEpisodes < 1) {
        return ["red", "Počet epizód musí byť väčší alebo rovný počtu sezón!"];
    }
    if (avgEpisodes > 50) {
        return ["red", "Priemerný počet epizód na sezónu nesmie byť väčší ako 50!"];
    }
    return ["lightgreen", ""];
}

function checkForm() {
    let valid = true;
    const isEdit = document.getElementById('movieEdit') !== null || document.getElementById('bookEdit') !== null || document.getElementById('seriesEdit') !== null;

    const workName = document.getElementById(idElements[0]);
    const description = document.getElementById(idElements[1]);
    const workImage = document.getElementById(idElements[2]);
    const resultWorkName = checkWorkName(workName);
    const resultDescription = checkDescription(description);
    const resultWorkImage = checkImage(workImage, isEdit);
    document.getElementById(idMessages[2]).textContent = resultWorkImage[1];
    if (resultWorkImage[0] === "red") {
        valid = false;
    }

    const resultElements = [resultWorkName, resultDescription];

    resultElements.forEach(function(result, i) {
        const element = document.getElementById(idElements[i]);
        const elementMessage = document.getElementById(idMessages[i]);
        updateOutput(element, elementMessage, result[0], result[1])

        if (result[0] === "red") {
            valid = false;
        }
    })

    const movieLength = document.getElementById('movieLength');
    const numOfSeasons = document.getElementById(idElementsSeries[2]);
    const numOfPages = document.getElementById('numOfPages');

    let isMovie = movieLength !== null;
    let isSeries = numOfSeasons !== null;
    let isBook = numOfPages !== null;

    if (isMovie) {
        const resultProdCompany = checkProdCompany(document.getElementById(idElementsMovie[0]), additionalTextsMovie, idElementsMovie[0]);
        const resultDirector = checkDirector(document.getElementById(idElementsMovie[1]), additionalTextsMovie, idElementsMovie[1]);
        const resultMovieElements = [resultProdCompany, resultDirector];
        resultMovieElements.forEach(function(result, i) {
            const element = document.getElementById(idElementsMovie[i]);
            const elementMessage = document.getElementById(idMessagesMovie[i]);
            updateOutput(element, elementMessage, result[0], result[1])

            if (result[0] === "red") {
                valid = false;
            }
        })
    } else if (isSeries) {
        const resultProdCompany = checkProdCompany(document.getElementById(idElementsSeries[0]), additionalTextsSeries, idElementsSeries[0]);
        const resultDirector = checkDirector(document.getElementById(idElementsSeries[1]), additionalTextsSeries, idElementsSeries[1]);
        const resultSeasonsEpisodesLogic = checkSeasonsEpisodesNumLogic(numOfSeasons, document.getElementById(idElementsSeries[3]));
        updateOutput(document.getElementById(idElementsSeries[3]), document.getElementById(idMessagesSeries[3]), resultSeasonsEpisodesLogic[0], resultSeasonsEpisodesLogic[1]);
        if (resultSeasonsEpisodesLogic[0] === "red") {
            valid = false;
        }

        const resultElementsSeries = [resultProdCompany, resultDirector];
        resultElementsSeries.forEach(function(result, i) {
            const element = document.getElementById(idElementsSeries[i]);
            const elementMessage = document.getElementById(idMessagesSeries[i]);
            updateOutput(element, elementMessage, result[0], result[1])

            if (result[0] === "red") {
                valid = false;
            }
        })
    } else if (isBook) {
        const resultPublishers = checkPublishers(document.getElementById(idElementsBook[0]));
        const resultAuthor = checkAuthor(document.getElementById(idElementsBook[1]));
        const resultElementsBook = [resultPublishers, resultAuthor];
        resultElementsBook.forEach(function(result, i) {
            const element = document.getElementById(idElementsBook[i]);
            const elementMessage = document.getElementById(idMessagesBook[i]);
            updateOutput(element, elementMessage, result[0], result[1])

            if (result[0] === "red") {
                valid = false;
            }
        })
    }
    return valid;
}


function apply(idElement, idMessage, controlFunction, input, focusout) {
    const element = document.getElementById(idElement);
    if (!element ) {
        return;
    }
    const elementMessage = document.getElementById(idMessage);

    function runValidation() {
        let result;
       if (idElement === idElementsMovie[0]) {
            result = controlFunction(element, additionalTextsMovie, idElementsMovie[0]);
        } else if (idElement === idElementsMovie[1]) {
            result = controlFunction(element, additionalTextsMovie, idElementsMovie[1]);
        } else if (idElement === idElementsSeries[0]) {
            result = controlFunction(element, additionalTextsSeries, idElementsSeries[0]);
        } else if (idElement === idElementsSeries[1]) {
            result = controlFunction(element, additionalTextsSeries, idElementsSeries[1]);
        } else if (idElement === idElementsSeries[3]) {
            const numOfSeasons = document.getElementById(idElementsSeries[2]);
            result = checkSeasonsEpisodesNumLogic(numOfSeasons, element);
        } else {
            result = controlFunction(element);
        }
        updateOutput(element, elementMessage, result[0], result[1]);
    }

    if (input) element.addEventListener("input", runValidation);
    if (focusout) element.addEventListener("focusout", runValidation);
}

window.addEventListener('DOMContentLoaded', function() {
    const sending = document.getElementById('movieAdd') || document.getElementById('bookAdd') || document.getElementById('seriesAdd')
    || document.getElementById('movieEdit') || document.getElementById('bookEdit') || document.getElementById('seriesEdit');

    if (sending) {
        sending.addEventListener('submit',  function (event) {
            event.preventDefault();
            const valid = checkForm();
            if (valid) {
                sending.submit();
            }
        });
    }

    apply(idElements[0], idMessages[0], checkWorkName, true,true);
    apply(idElements[1], idMessages[1], checkDescription, true, true);
    apply(idElementsMovie[0], idMessagesMovie[0], checkProdCompany, true, true);
    apply(idElementsMovie[1], idMessagesMovie[1], checkDirector, true, true);
    apply(idElementsSeries[0], idMessagesSeries[0], checkProdCompany, true, true);
    apply(idElementsSeries[1], idMessagesSeries[1], checkDirector, true, true);
    apply(idElementsBook[0], idMessagesBook[0], checkPublishers, true, true);
    apply(idElementsBook[1], idMessagesBook[1], checkAuthor, true, true);
    apply(idElementsSeries[3], idMessagesSeries[3], checkSeasonsEpisodesNumLogic, true, true);
});

function updateOutput(element, elementMessage, color, message) {
    if (element) element.style.borderColor = color;
    if (elementMessage) elementMessage.textContent = message;
}

const idElements = ["workName", "description", "workImage"];
const idElementsMovie = ["prodCompany", "director"];
const idElementsSeries = ["prodCompany", "director", "numOfSeasons", "numOfEpisodes"];
const idElementsBook = ["publishers", "author"];
const idMessages = ["workNameMessage", "descriptionMessage", "workImageMessage"];
const idMessagesMovie = ["prodCompanyMessage", "directorMessage"];
const idMessagesSeries = ["prodCompanyMessage", "directorMessage", "numOfSeasonsMessage", "numOfEpisodesMessage"];
const idMessagesBook = ["publishersMessage", "authorMessage"];
const additionalTexts = new Map([[idElements[0], "Zadaj názov."], [idElements[1], "Zadaj popis."]]);
const additionalTextsMovie = new Map([[idElementsMovie[0],"Zadaj produkčnú spoločnosť."], [idElementsMovie[1], "Zadaj režiséra."]]);
const additionalTextsSeries = new Map([[idElementsSeries[0], "Zadaj produkčnú spoločnosť."], [idElementsSeries[1], "Zadaj režiséra."]]);
const additionalTextsBook = new Map([[idElementsBook[0],"Zadaj vydavateľa."], [idElementsBook[1], "Zadaj autora."]]);