ccmValidateBlockForm = function() {
	
	if ($('input[name=field_1_date_value]').val() == '' || $('input[name=field_1_date_value]').val() == 0) {
		ccm_addError('Missing required date: Start Date');
	}


	return false;
}
