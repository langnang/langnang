var txtbox = document.querySelectorAll('textarea');
var copied = document.getElementById('copied');

document.addEventListener("DOMContentLoaded", function() {
  
  // this loops through each textarea and counts the number of lines, and then assigns it a "rows" attribute
  txtbox.forEach(function(box) {
    var value = box.value;
    var numLines = value.split(/\r\n|\r|\n/).length;
    //console.log(numLines);
    box.setAttribute("rows", numLines);
    box.addEventListener("click", copyText, true);

    function copyText() {
      var value = event.target.value;
      var e = event.target;
      e.select();
      document.execCommand('copy');
      copyNotify();
    }

    function copyNotify() {
      console.log('text copied.');
      copied.style.display = "block";
      setTimeout(function() {
        copied.style.display = "none";
      }, 1000)
    }
  });
    
  //});

  
  //document.body.append(span);
//console.log(box.childNodes);
  
});