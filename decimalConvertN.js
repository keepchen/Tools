//实现将一个10进制数字转换为N(2~36)进制
function decimalConvertN(num, n) {
	if (false === /^\d+$/.test(n) || n < 2 || n > 36) {
		throw new Error("错误的进制,无法转换");
	}
	if (false === /^\d+$/.test(num)) {
		throw new Error("错误的十进制数字");
	}

	var remain = 0,
		current = num,
		result = [],
		holders = [0,1,2,3,4,5,6,7,8,9,"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];

	while(current > 0) {
		//计算各个权位上的值
		remain = current % n;
		//根据权值找到对应的代表值
		if (remain > 9 && remain < 36) {
			result.push(holders[remain] + "");
		} else if (remain >= 36) {
			result.push(remain.toString());
		} else {
			result.push(remain.toString());
		}
		//向低位移动
		current = parseInt(current / n);
		// console.log("current / n: " + current);
	}
	result.reverse();
	// console.log(result);
	return result.join("");
}
