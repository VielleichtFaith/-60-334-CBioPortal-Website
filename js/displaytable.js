$.ajax({
  type: "GET",
  url: "../loadclinicaldata.py",
  success: function(json_data) {
	var response = JSON.parse(json_data);
  }
});
