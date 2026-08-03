document.getElementById('fetchBtn').addEventListener('click', function () {
	var pinValue = document.getElementById('search_pin').value;

	fetch('config/fetch_data.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
		},
		body: 'pin=' + encodeURIComponent(pinValue),
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.error) {
				alert(data.error);
			} else {
				// Populate Building Description
				document.getElementById('building_pin').value = data.building.pin;
				document.getElementById('kind_of_building').value =
					data.building.building_kind;
				document.getElementById('structural_type').value =
					data.building.structural_type;
				document.getElementById('building_age').value =
					data.building.building_age;

				// Populate Appraisal
				document.getElementById('ucc').value = data.appraisal.ucc;
				document.getElementById('market_value').value =
					data.appraisal.market_value;

				// Handling Checkboxes (Flooring/Walls)
				// If data is stored as a comma-separated string, we check the boxes
				if (data.walls.chb) {
					// Logic to check checkboxes based on string content
					updateCheckboxes('walls_chb', data.walls.chb);
				}

				alert('Data fetched successfully!');
			}
		});
});

// Helper function to handle those "imploded" checkbox strings
function updateCheckboxes(name, valueString) {
	if (!valueString) return;
	let values = valueString.split(', ');
	let checkboxes = document.getElementsByName(name + '[]');
	checkboxes.forEach((cb) => {
		if (values.includes(cb.value)) cb.checked = true;
	});
}
