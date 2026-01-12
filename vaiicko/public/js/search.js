const inputE = document.getElementById("searchInput");

async function serverSearchWorks() {
    const results = document.getElementById("searchResults");
    if (!inputE || !results) return;
    const text = inputE.value.trim();
    if (text.length < 2) {
        results.innerHTML = "";
        return;
    }

    const params = new URLSearchParams({text});

    const res = await fetch('/?c=work&a=ajaxSearchWorks&' + params.toString());
    const json = await res.json();

    results.innerHTML = "";
    if (json.works.length === 0) {
        results.innerHTML =
            `<div class="list-group-item text-muted">Žiadne výsledky</div>`;
        return;
    }

    json.works.forEach(work => {
        const item = document.createElement("a");
        item.href = work.url;
        item.className = "list-group-item list-group-item-action";
        item.innerHTML = `
                        <strong>${work.name}</strong>
                        <span class="text-muted">(${work.type})</span>
                    `;
        results.appendChild(item);
    });
}

window.addEventListener('DOMContentLoaded', () => {
        inputE.addEventListener('input', serverSearchWorks);
});
