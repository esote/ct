<?php

/*

Print JavaScript required for classes pages

Variables needed:
	$classes
	$credit_reqs
	$years

*/

if(!isset($classes,
	$credit_reqs,
	$years)) {
	require_once __DIR__ . "/kill.php";
	kill("Error: Unable to find required variables.");
	die();
}

require_once __DIR__ . "/hsc.php";

echo '<script src="style/chosen/chosen.jquery.min.js"></script>
<script>
var classes = ', json_encode($classes), ';
var credit_reqs = ', json_encode($credit_reqs), ';

$(".chosen-select").chosen({no_results_text: "No classes found!", allow_single_deselect: true});

function hexRBGA(hex){
	var c;
	if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
		c = hex.substring(1).split("");
		if(c.length === 3){
			c = [c[0], c[0], c[1], c[1], c[2], c[2]];
		}
		c = "0x" + c.join("");
		return "rgba(" + [(c>>16)&255, (c>>8)&255, c&255].join(",") + ",0.30)";
	}
	throw new Error("Bad Hex");
}

function update() {
	var sum = new Array(', $hsc($years), ').fill(0);
	$(":selected").each(function() {
		var key = $(this).val().indexOf(",");
		if(key === -1) {
			$(this).parents().eq(2).children().eq(1).css("background-color", "transparent").html("");
			return;
		}

		var val = parseInt($(this).val().substring(key + 1));
		var year = parseInt($(this).val().substring(0, key));

		if(val.length === 0) {
			$(this).parents().eq(2).children().eq(1).css("background-color", "transparent").html("");
			return;
		}

		key = -1;
		for(var i = 0; i < classes.length; ++i) {
			if(classes[i]["class_id"] === val) {
				key = i;
				break;
			}
		}

		if(key === -1) {
			$(this).parents().eq(2).children().eq(1).css("background-color", "transparent").html("");
			return;
		}

		var colored = false;

		for(var i = 0; i < credit_reqs.length; ++i) {
			if(classes[key]["area"] === credit_reqs[i][0]) {
				var color = credit_reqs[i][2];
				$(this).parents().eq(2).children().eq(1).css("background-color", hexRBGA(color));
				colored = true;
				break;
			}
		}

		if(!colored) {
			$(this).parents().eq(2).children().eq(1).css("background-color", "transparent");
		}

		sum[year] += parseFloat(classes[key]["hs_terms"]);

		$(this).parents().eq(4).find("thead > tr:nth-child(2) > th:nth-child(2)").html(sum[year]);
		$(this).parents().eq(2).children().eq(1).html(classes[key]["hs_terms"]);
	});
}

update();


$(document).ready(function(){
	$(document).on("change", "select", function() {
		update();

		$.ajax({
			type: "POST",
			url: "transit_to/to_s_classes.php",
			error: function() {
				alert("Form submit failed. Refresh the page and try again.");
			},
			data: $("#sendClasses").serialize(),
			success: function() {
				$(".classes-success").animate({opacity:($(".classes-success").css("opacity")===1)?0:1}, 0).delay(1500).animate({opacity:($(".classes-success").css("opacity")===1)?0:1}, 750);
			}
		});
	});
});

</script>';

