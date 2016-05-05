(function() {
	
	var itemcode = document.getElementById("code");
	var itemname = document.getElementById("itemname");

	itemcode.oninput = function() {
		var url = document.getElementById("itemcodeurl").value;
		var codeval = itemcode.value;	

		Tutsplus.ajax(url, {
			method: "POST",
			data:  {
				code: codeval
			},
			complete: function(response) {
				itemname.value = response;
			}
		});
	};

	itemname.oninput = function() {
		var url = document.getElementById("itemnameurl").value;
		var nameval = itemname.value;

		Tutsplus.ajax(url, {
			method: "POST",
			data:  {
				name: nameval
			},
			complete: function(response) {
				itemcode.value = response;
			}
		});
	};

	var discount = document.getElementById("discount");
	discount.oninput = function() {
		var s_total = document.getElementById("sub_total").innerHTML;
		var total = document.getElementById("total");
		var tot = s_total - discount.value;
		total.innerHTML = tot;
		document.getElementById("netamount").innerHTML = tot;
	};

	var cashr = document.getElementById("cashr");
	cashr.oninput = function() {
		var cashb = document.getElementById("cashb");
		var netamount = document.getElementById("netamount").innerHTML;
		var total = cashr.value - netamount;
		cashb.innerHTML = total;
	};

	var payment = document.getElementById("payment_mode");
	payment.onchange = function() {
		var tr = document.getElementById("credit_customer");
		var url = "php/credit_customer_ajax.php";
		Tutsplus.ajax(url, {
			method: "POST",
			data:  {
				payment_mode: payment.value
			},
			complete: function(response) {
				tr.innerHTML = response;
			}
		});

	};


})();
