function exibirFiltroAcc(id_componente) {
	var accordion = document.getElementById(id_componente);
	accordion.style.display === "block" ? accordion.style.display = "none" : accordion.style.display = "block";
	accordion.classList.toggle("acc-aberto");
}