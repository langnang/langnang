$(function(){
	// console.log('Load ace-init');
	ace.require("ace/ext/language_tools");


	var htmlEditor = ace.edit("htmlEditor",{
		theme:'ace/theme/chrome'
		,mode:'ace/mode/html'
		,maxLines:'40'
		,minLines:'40'
		,foldStyle:'markbeginend'
	});


	// if (typeof ace == "undefined" && typeof require == "undefined") {
	// 	document.body.innerHTML = "<p style='padding: 20px 50px;'>couldn't find ace.js file, <br>"
	// 	+ "to build it run <code>node Makefile.dryice.js full<code>"
	// } else if (typeof ace == "undefined" && typeof require != "undefined") {
	// 	require(["ace/ace"], setValue)
	// } else {
	// 	require = ace.require;
	// 	setValue();
	// }

	// setValue =function(url) {
	// 	$.get(url, function(data){
	// 		document.getElementById("htmlEditor").env.editor.setValue(data, 1);
	// 	})
	// }
	// setValue=function(data){
	// 	if (typeof ace == "undefined" && typeof require == "undefined") {
	// 		document.body.innerHTML = "<p style='padding: 20px 50px;'>couldn't find ace.js file, <br>"
	// 		+ "to build it run <code>node Makefile.dryice.js full<code>"
	// 	} else if (typeof ace == "undefined" && typeof require != "undefined") {
	// 		require(["ace/ace"], setValue)
	// 	} else {
	// 		require = ace.require;
	// 		// require("ace/lib/net").get(url, function(t){
	// 			document.getElementById("htmlEditor").env.editor.setValue(data, 1);
	// 			// return t;
	// 		// })
	// 	}
	// }
	// getValue=function(){
	// 	return document.getElementById("htmlEditor").env.editor.getValue();
	// }
})
