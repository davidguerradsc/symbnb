$('#add-image').click(function () { //Je récupère le numéro des futurs champs que je vais créer
	const index = + $('#widgets-counter').val();


	//je récupère le prototype des entrées
	const tmpl = $('#annonces_images').data('prototype').replace(/__name__/g, index);

	//J'injecte ce code au sain de la div
	$('#annonces_images').append(tmpl);

	$(' #widgets-counter').val(index + 1);

	// je gère le bouton supprimer
	handleDeleteButtons();
});


function handleDeleteButtons() {
	$('button[data-action="delete"]').click(function () {
		const target = this.dataset.target;
		$(target).remove();
	});
}

function updateCounter() {
	const count = +$('#annonces_images div.form-group').length;

	$('#widgets-counter').val(count);
}

updateCounter();

handleDeleteButtons();