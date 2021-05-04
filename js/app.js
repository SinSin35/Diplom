$(".plusminus").on("click", function(e){
	const input=$(e.target).parent().find("input");
	input.val(+input.val()+$(e.target).data("step"));
	if (input.val()<=0){
		input.val(1);
	}
});