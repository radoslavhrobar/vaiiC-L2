let heart = document.getElementById("favoriteHeart")

async function serverUpdateFav() {
    const workId = heart.dataset.workId;
    const formData = new URLSearchParams();
    formData.append('workId', workId);

    const res = await fetch('/?c=work&a=ajaxUpdateFav&', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: formData.toString()
    });
    const json = await res.json();

    if (json.adding) {
        heart.classList.add("bi-heart-fill", "text-danger");
        heart.classList.remove("bi-heart", "text-secondary");
    } else {
        heart.classList.add("bi-heart", "text-secondary");
        heart.classList.remove("bi-heart-fill", "text-danger");
    }
}

window.addEventListener('DOMContentLoaded', () => {
    heart.addEventListener('click', serverUpdateFav);
});
