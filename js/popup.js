// Ouvrir le pop-up pour ajouter un captcha
function openAddPopup() {
    document.getElementById('addPopupForm').style.display = 'flex';
}

// Fermer le pop-up d'ajout
function closeAddPopup() {
    document.getElementById('addPopupForm').style.display = 'none';
}

// Ouvrir le pop-up pour modifier un captcha avec les valeurs actuelles
function openEditPopup(id, q, r) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_q').value = q;
    document.getElementById('edit_r').value = r;
    document.getElementById('editPopupForm').style.display = 'flex';
}

// Fermer le pop-up de modification
function closeEditPopup() {
    document.getElementById('editPopupForm').style.display = 'none';
}
