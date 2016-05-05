(function() {
	var category = document.getElementById("category");

	category.oninput = function() {
		var cat = category.value;
		var options = document.getElementById("options");		

		if (cat == "customer_name") {
			options.innerHTML = "<label>Customer Name:</label>";
			options.innerHTML += "<input type=\"text\" class=\"form-control\" name=\"customer_name\">";
			options.innerHTML += "<div class=\"divide15\"></div>";
			options.innerHTML += "<label>Customer Phone:</label>";
			options.innerHTML += "<input type=\"text\" class=\"form-control\" name=\"customer_phone\">";
		} else if (cat == "item_code") {
			options.innerHTML = "<label>Item code:</label>";
			options.innerHTML += "<input type=\"text\" class=\"form-control\" name=\"item_code\">";
			options.innerHTML += "<div class=\"divide15\"></div>";
			options.innerHTML += "<label>Item Name:</label>";
			options.innerHTML += "<input type=\"text\" class=\"form-control\" name=\"item_name\">";
		} else if (cat == "sales_id") {
			options.innerHTML = "<label>Sales Id:</label>";
			options.innerHTML += "<input type=\"text\" class=\"form-control\" name=\"sales_id\">";
		} else if (cat == "purchase_id") {
			options.innerHTML = "<label>Purchase Id:</label>";
			options.innerHTML += "<input type=\"text\" class=\"form-control\" name=\"purchase_id\">";
		} else if (cat == "stock") {
			options.innerHTML = "";
		} else if (cat == "profit_loss") {
			options.innerHTML = "";
		} else {
			options.innerHTML = "";
		}
	};

})();