async function serverCheckTypeOfWork() {
    const typeSelect = document.getElementById('typeOfWork');
    const genreSelect = document.getElementById('genreRankings');
    const yearFrom = document.getElementById('yearFrom');
    const yearTo = document.getElementById('yearTo');

    if (!typeSelect || !genreSelect || !yearFrom || !yearTo) return;

    const type = typeSelect.value;

    const params = new URLSearchParams({type});

    const res = await fetch('/?c=work&a=ajaxCheckTypeOfWork&' + params.toString());
    const json = await res.json();

    genreSelect.innerHTML = '<option value="všetky">-všetky-</option>';

    json.genres.forEach(genre => {
        const option = document.createElement('option');
        option.value = genre.id;
        option.textContent = genre.name;
        genreSelect.appendChild(option);
    });

    yearFrom.min = json.yearFrom;
    yearTo.min = json.yearFrom;
}

window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('typeOfWork')
        .addEventListener('change', serverCheckTypeOfWork);
    document.getElementById('yearFrom').addEventListener('change', e => {
        const yearTo = document.getElementById('yearTo');
        if (!yearTo) return;
        document.getElementById('yearTo').min = e.target.value;
    });
});

