// Botones asginadas y realizadas
function showTab(tabName) {
    let tabs = document.querySelectorAll('.tab');
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].style.display = 'none';
    }
    document.getElementById(tabName).style.display = 'block';
}


function asignarIncidencia(id) {
    document.getElementById("id_incidencia").value = id;
}
