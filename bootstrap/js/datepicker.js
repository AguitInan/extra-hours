	jQuery.datepicker.setDefaults(jQuery.datepicker.regional['fr']);
	$(function() {
		$( "#Date_Entree_Collectivite, #Date_Entree_Collectivite2, #Date_Saisie, #Date" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd'
		});
	});