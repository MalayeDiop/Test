function toggleForm() {
    const formContainer = document.getElementById('form-container');
    formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
}

async function fetchNiveaux() {
    try {
        const response = await fetch('/api/niveaux');
        const data = await response.json();

        const list = document.createElement('ul');
        data.forEach(niveau => {
            const listItem = document.createElement('li');
            listItem.textContent = niveau.nom_niveau;
            list.appendChild(listItem);
        });

        const niveauListContainer = document.getElementById('niveau-list');
        niveauListContainer.innerHTML = '';
        niveauListContainer.appendChild(list);
    } catch (error) {
        console.error('Erreur lors de la récupération des niveaux', error);
    }
}

document.getElementById('add-niveau-form').addEventListener('submit', async function (event) {
    event.preventDefault();

    const nomNiveau = document.getElementById('nom_niveau').value;

    try {
        const response = await fetch('/api/niveaux', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ nom_niveau: nomNiveau }),
        });

        if (response.ok) {
            fetchNiveaux();
            document.getElementById('nom_niveau').value = '';
            toggleForm();
        } else {
            alert('Erreur lors de l\'ajout du niveau');
        }
    } catch (error) {
        console.error('Erreur lors de l\'ajout du niveau', error);
    }
});

window.onload = fetchNiveaux;
