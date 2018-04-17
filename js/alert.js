function showAlert(error)
{
	var box = bootbox.alert(error);
	box.find('.modal-content').css({'background-color': '#fff', 'text-align':'center', 'font-weight' : 'bold', color: '#333', 'font-size': '25px'} );
	box.find('.modal-footer').css({'text-align':'center'});
	box.find(".btn-primary").removeClass("btn-primary").css({'width':'150px','background-color': '#fff', 'font-weight' : 'bold', color: '#33', 'font-size': '25px'});
};