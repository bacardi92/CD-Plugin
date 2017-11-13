(function($){

	if( !$("#wpcd_settings_form").length )
	{
		return;
	}

	var _this = {

		form: $("#wpcd_settings_form"),
		username: $("#wpcd_user_name"),
		useremail: $("#wpcd_user_email"),
		saveBtn: $("#save_user_data"),
		publickey: $("#wpcd_public_key"),
		privatekey: $("wpcd_private_key"),
		generateBtn: $("#generate_keys"),
		sshAddBtn: $("#add_keys"),


		sendPostRequest: function(url, data, callback){
			$.ajax({
	            url: url,
	            type: 'POST',
	            data: data,
	            dataType: "json",
	            success: callback,
	            error: callback
	        });
		},

		saveUserData: function(){
			$(_this.saveBtn).on("click", function(e){
				e.preventDefault();
				$("[id^=message-].notice").remove();
				var data = {
					action: 'save_git_user_data',
					username: '',
					useremail: ''
				};
				if( _this.validateText(_this.username) && _this.validateEmail(_this.useremail) )
				{
					data.username = _this.username.val();
					data.useremail = _this.useremail.val();

					_this.sendPostRequest(ajaxurl, data, function(json){
						if( json.hasOwnProperty('message') )
						{
							_this.form.before(json.message);
						}
					});
				}
			});
		},

		generateKeys: function(){
			$(_this.generateBtn).on('click', function(e){
				e.preventDefault();
				$("[id^=message-].notice").remove();
				var data = {
					action: 'generate_ssh_keys'
				};
				_this.sendPostRequest(ajaxurl, data, function(json){
					if( json.hasOwnProperty('message') )
					{
						_this.form.before(json.message);
					}
					if( json.hasOwnProperty('public') )
					{
						_this.publickey.val(json.public);
					}
					if( json.hasOwnProperty('private') )
					{
						_this.privatekey.val(json.private);
					}
				});
			});
		},

		sshAddKeys: function(){
			$(_this.sshAddBtn).on('click', function(e){
				e.preventDefault();
				$("[id^=message-].notice").remove();
				var data = {
					action: 'add_ssh_keys'
				};
				_this.sendPostRequest(ajaxurl, data, function(json){
					if( json.hasOwnProperty('message') )
					{
						_this.form.before(json.message);
					}
				});
			});
		},

		validateText: function(obj){
			obj.removeClass('error');
			if( !obj.val().length ){
				obj.addClass('error');
				return false;
			}
			return true;
		},

		validateEmail: function(obj) {
			obj.removeClass('error');
		  	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		  	if (emailReg.test( obj.val() ) == false || !obj.val().length ){
		  		obj.addClass('error');
		  		return false;
			}
			return true;
		},

		init: function(){
			_this.saveUserData();
			_this.generateKeys();
			_this.sshAddKeys();

		}

	}
	_this.init();

})(jQuery)