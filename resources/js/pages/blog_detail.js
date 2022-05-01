var BlogDetail = {
  init() {
    this.tocLoad();
  },

  tocLoad() {
    var $editable = $('#main-content');
    var h2 = $editable.find('h2');
    var hList = "<ul id='tableofcontent'>";

    for (var i = 0; i < h2.length; i++) {
      if ($(h2[i]).text() != "") {
        if ($(h2[i]).text().replace(/^\s+/, '').replace(/\s+$/, '') == '') {//Whitespace
        } else {
          $(h2[i]).attr("id", "h2_" + i);
          let blogNumber = i + 1
          hList += "<li><a href='#h2_" + i + "'>" + blogNumber + '. ' + $(h2[i]).text().replace(/(\r\n\t|\n|\r\t)/gm, "") + "</a></li>";
        }
      }

      var h3 = $(h2[i]).nextUntil('h2').filter('h3');

      if (h3.length > 0) {
        hList += "<ul>";

        for (var j = 0; j < h3.length; j++) {
          if ($(h3[j]).text() != "") {
            if ($(h3[j]).text().replace(/^\s+/, '').replace(/\s+$/, '') == '') {//Whitespace
            } else {
              $(h3[j]).attr("id", "h3_" + i + "_" + j);
              hList += "<li><a href='#h3_" + i + '_' + j + "'>" + $(h3[j]).text().replace(/(\r\n\t|\n|\r\t)/gm, "") + "</a></li>";
            }
          }
        }

        hList += "</ul>";
      }
      hList += "</ul>";
    }
    $('#toc-main').append(hList);
  }
}

export default BlogDetail;
