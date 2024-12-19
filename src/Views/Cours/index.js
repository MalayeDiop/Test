function toggleForm() {
    const formContainer = document.getElementById('form-container');
    formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
}

async function fetchCours() {
    try {
        const response = await fetch('/api/cours'); 
        const data = await response.json();

        const table = document.createElement('table');
        table.border = 1;

        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');
        const headerId = document.createElement('th');
        headerId.textContent = 'ID';
        const headerNomCours = document.createElement('th');
        headerNomCours.textContent = 'Nom du Cours';
        const headerProf = document.createElement('th');
        headerProf.textContent = 'Professeur';

        headerRow.appendChild(headerId);
        headerRow.appendChild(headerNomCours);
        headerRow.appendChild(headerProf);
        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        data.forEach(cour => {
            const row = document.createElement('tr');

            const cellId = document.createElement('td');
            cellId.textContent = cour.id;
            row.appendChild(cellId);

            const cellNomCours = document.createElement('td');
            cellNomCours.textContent = cour.nom_cours;
            row.appendChild(cellNomCours);

            const cellProf = document.createElement('td');
            cellProf.textContent = cour.prof;
            row.appendChild(cellProf);

            tbody.appendChild(row);
        });
        table.appendChild(tbody);

        const coursListContainer = document.getElementById('cours-list');
        coursListContainer.innerHTML = '';
        coursListContainer.appendChild(table);
    } catch (error) {
        console.error('Erreur lors de la récupération des cours:', error);
    }
}

async function addCours(event) {
    event.preventDefault();

    const nomCours = document.getElementById('nom_cours').value;
    const profId = document.getElementById('prof_id').value;

    try {
        const response = await fetch('/api/cours', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nom_cours: nomCours, prof_id: profId })
        });

        const data = await response.json();

        if (response.ok) {
            fetchCours();
            toggleForm();
        } else {
            alert(data.error || 'Erreur lors de l\'ajout du cours');
        }
    } catch (error) {
        console.error('Erreur lors de l\'ajout du cours:', error);
    }
}
document.getElementById('add-cours-form').addEventListener('submit', addCours);

fetchCours();
