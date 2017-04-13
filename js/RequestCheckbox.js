function handleClick(cb) {
  
  if ( $(cb).is(":checked")){
  var closestTrChecked = $(cb).closest("tr").attr("id"); //get row of selected checkbox
  var closestTd = $(cb).closest("td").attr("id");//get column of selected checkbox
  var checkB = cb.checked;
  
  $.ajax({
    data: {id : closestTrChecked, column: closestTd, check : checkB },
    url: 'requestcheck',
    method: 'GET', // or GET
    success: function(msg) {
        //alert(closestTrChecked);
        //alert(closestTd);
    }
  });
  
  }
}