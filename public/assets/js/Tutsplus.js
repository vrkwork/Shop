var Tutsplus = {};

Tutsplus.createXHR = function(url, options) {
	var xhr = false;

	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		try {
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {
			xhr = false;
		}
	}

	if (xhr) {
		options = options || {};
		options.method = options.method || "GET";
		options.data = options.data || null;

		if (options.data) {
			var qstring = [];

			for (var key in options.data) {
				qstring.push(encodeURIComponent(key)+"="+encodeURIComponent(options.data[key]));
			}

			options.data = qstring.join("&");
		}

		if (options.cache == false && options.method.toUpperCase() == "GET") {
			url = url+"?_="+ new Date().getTime();
		}

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 1) {
				if (options.before) {
					options.before.call(xhr);
				}
			}

			if ((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304)) {
				var contentType = xhr.getResponseHeader('Content-Type');

				if (options.complete) {
					if (contentType == "application/json") {
						options.complete.call(xhr, JSON.parse(xhr.responseText));
					} else if (contentType == "text/xml" || contentType == "application/xml") {
						options.complete.call(xhr, xhr.responseXML);
					} else {
						options.complete.call(xhr, xhr.responseText);
					}
				}		
			}
		};

		xhr.open(options.method, url, true);
		return xhr;
	} else {
		return false
	}
};

Tutsplus.ajax = function(url, options) {
	var xhr = Tutsplus.createXHR(url, options);

	if (xhr) {
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

		if (options.method.toUpperCase() == "POST") {
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		}
		xhr.send(options.data);
	}
};

Tutsplus.flash = function(elem) {
	elem.style.backgroundColor = "yellow";

	window.setTimeout(function() {
		elem.style.backgroundColor = "white";
	}, 300);
};