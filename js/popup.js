
function openAddPopup() {
    document.getElementById('addPopupForm').style.display = 'flex';
}


function closeAddPopup() {
    document.getElementById('addPopupForm').style.display = 'none';
}


function openEditPopup(id, q, r) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_q').value = q;
    document.getElementById('edit_r').value = r;
    document.getElementById('editPopupForm').style.display = 'flex';
}


function closeEditPopup() {
    document.getElementById('editPopupForm').style.display = 'none';
}
