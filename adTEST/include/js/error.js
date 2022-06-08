let er = document.querySelector('#setting-error-ad_err');
er.style.display = "none";
let regex = "(^#{1}[a-zA-Z0-9_\-]+$)|(^\.{1}[a-zA-Z0-9_\-]+(\s?\.{1}[a-zA-Z0-9_\-]+)+$)";
let div = document.querySelector('#ad_div').value;
if(!div.match(regex)){
	er.style.display = "block";
}