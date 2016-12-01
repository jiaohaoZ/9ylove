(function($, validate) {
	function TestRgexp(re, s){   // 参数说明 re 为正则表达式   s 为要判断的字符
     return re.test(s)
	}
	/*验证邮箱*/
	validate.email=function(emailinfo, callback) {
		var emailinfo = emailinfo || '';
		if(TestRgexp(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,emailinfo)){
			
		}else{
			return callback('请输入正确邮箱号码');
		}
		return callback();
	};

	/*验证qq*/
	validate.qq=function(qqinfo, callback) {
		var qqinfo = qqinfo || '';
		if(TestRgexp(/^[1-9][0-9]{4,9}$/,qqinfo)){
			
		}else{
			return callback('请输入正确qq号码');
		}
		return callback();
	};

	/*验证银行卡长度*/
	validate.cardNum=function(cardNums, callback) {
		var cardNums = cardNums || '';
		if(cardNums.length == 0){
			return callback('银行卡号码不能为空');
		}

		if(cardNums.length < 20){
			if(!TestRgexp(/^\d{4}(?:\s\d{4}){3}$/,cardNums)){
				return callback('请输入正确银行卡号码');
			}
		}

		if(cardNums.length > 19){
			if(!TestRgexp(/^\d{4}(?:\s\d{4}){3}\s\d{3}$/,cardNums)){
				return callback('请输入正确银行卡号码');
			}
		}
		return callback();
	};

	/*验证身份证*/
	validate.identity=function(identityinfo, callback) {
		var identityinfo = identityinfo || '';
		if(TestRgexp(/(^\d{15}$)|(^\d{17}([0-9]|X)$)/,identityinfo)){
			
		}else{
			return callback('请输入正确身份证号码');
		}
		return callback();
	};
	/*验证手机号*/
	validate.phone=function(phoneInfo, callback) {
		var phoneInfo = phoneInfo || '';
		if(TestRgexp(/^(0|86|17951)?(13[0-9]|15[0-9]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/,phoneInfo)){
			
		}else{
			return callback('请输入正确手机号码');
		}
		return callback();
	};
	/*登录验证*/
	validate.login=function(loginInfo, callback) {
		callback = callback || $.noop;
		loginInfo = loginInfo || {};
		loginInfo.account = loginInfo.account || '';
		loginInfo.password = loginInfo.password || '';
		if(TestRgexp(/^(0|86|17951)?(13[0-9]|15[0-9]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/,loginInfo.account)||TestRgexp(/^[a-z\d_\u4e00-\u9fa5]{3,16}/i,loginInfo.account)){
			
		}else{
			return callback('请输入正确手机号码/用户名');
		}
		if (loginInfo.password.length < 6) {
			return callback('密码最短为 6 个字符');
		}
		return callback();
	};
	/*注册验证-1*/
	validate.reg=function(regInfo, callback) {
		callback = callback || $.noop;
		regInfo = regInfo || {};
		regInfo.account = regInfo.account || '';
		regInfo.password = regInfo.password || '';
		regInfo.code = regInfo.code || '';
		if (regInfo.accountName.length < 3) {
			return callback('用户名最短为 3 个字符');
		}
		if(TestRgexp(/[-:：]+/,regInfo.accountName)) {
			return callback('用户名不能包含特殊字符-:');
		};
		if(TestRgexp(/^(0|86|17951)?(13[0-9]|15[0-9]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/,regInfo.account)){
			
		}else{
			return callback('请输入正确手机号码');
		}
		if (regInfo.code.length < 4) {
			return callback('验证码最短为 4 个字符');
		}
		if (regInfo.password.length < 6) {
			return callback('密码最短为 6 个字符');
		}
		
		return callback();
	};
	/*注册验证-2*/
	validate.reg2=function(reg2Info, callback) {
		callback = callback || $.noop;
		reg2Info = reg2Info || {};
		reg2Info.accountName = reg2Info.accountName || '';
		reg2Info.sex = reg2Info.sex || false;
		reg2Info.email = reg2Info.email || '';
		if (reg2Info.accountName.length < 5) {
			return callback('用户名最短为 5 个字符');
		}
		if (!reg2Info.sex) {
			return callback('请选择性别');
		}
		if(TestRgexp(/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/,reg2Info.email)){
			
		}else{
			return callback('请输入正确邮箱');
		}
		return callback();
	};
	/*忘记密码验证*/
	validate.forget=function(forgetInfo, callback) {
		callback = callback || $.noop;
		forgetInfo = forgetInfo || {};
		forgetInfo.account = forgetInfo.account || '';
		forgetInfo.code = forgetInfo.code || '';
		forgetInfo.password = forgetInfo.password || '';
		if(TestRgexp(/^(0|86|17951)?(13[0-9]|15[0-9]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/,forgetInfo.account)){
			
		}else{
			return callback('请输入正确手机号码');
		};
		if (forgetInfo.code.length < 4) {
			return callback('验证码最短为 4 个字符');
		};
		if (forgetInfo.password.length < 6) {
			return callback('密码最短为 6 个字符');
		}
		return callback();
	};
}(mui, window.validate = {}));