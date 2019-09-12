function quickCopy(el) {
    if (typeof el !== "object" || typeof el.getAttribute !== "function") {
        throw new Error("[copy] copy failed, `el` not a element node.");
    }
    var attr = el.getAttribute("data-copy");
    if (attr === null) {
        console.log("[copy] copy failed, `data-copy` attribute not exist.");
        return false;
    }
    var newEle = document.createElement("input");
    newEle.setAttribute("readonly", "readonly");
    newEle.setAttribute("value", attr);
    newEle.style.opcity="0";
    newEle.style.position="fixed";
    newEle.style.top="-1000px";
    newEle.style.zIndex="-1";
    document.body.appendChild(newEle);
    //1.select
    if (newEle.createTextRange) {
        //IE
        var selRange = newEle.createTextRange();
        selRange.collapse(true);
        selRange.moveStart("character", 0);
        selRange.moveEnd("character", attr.length);
    } else if (newEle.setSelectionRange) {
        newEle.setSelectionRange(0, attr.length);
    }
    newEle.focus();
    newEle.select();
    //2.excute copy command
    if (document.execCommand == undefined) {
        throw new Error("[copy] copy failed, `execCommand` not be supported by your browser.");
    }
    var flag = document.execCommand("copy");
    document.body.removeChild(newEle);
    //3.clear selection
    if ("getSelection" in window) {
        window.getSelection().removeAllRanges();
    } else {
        //IE
        document.selection.empty();
    }
    return flag;    
}
