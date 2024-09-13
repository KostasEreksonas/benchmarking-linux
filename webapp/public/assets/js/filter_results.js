document.getElementById('resolution').onchange = function() {
	location.reload()
	var res = this.value;
	document.cookie = escape("Resolution") + "=" + escape(res) + "; path=/";
}
