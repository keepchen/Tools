function quickCopy(el) {
    if (typeof el !== "object" || typeof el.getAttribute !== "function") {
        throw new Error("[copy] copy failed, `el` not a element node.");
    }
    var attr = el.getAttribute("data-copy");
    if (attr === null) {
        console.log("[copy] copy failed, `data-copy` attribute not exist.");
        return false;
    }
    var newEle = document.createElement("textarea");
    newEle.setAttribute("readonly", "readonly");
    newEle.value = attr;
    newEle.style.opcity="0";
    el.parentElement.appendChild(newEle);
    //1.select
    newEle.select();
    // newEle.focus();
    if (newEle.createTextRange) {
        //IE
        var selRange = newEle.createTextRange();
        selRange.collapse(true);
        selRange.moveStart("character", 0);
        selRange.moveEnd("character", attr.length);
    } else if (newEle.setSelectionRange) {
        newEle.setSelectionRange(0, attr.length);
    }
    //2.excute copy command
    if (document.execCommand == undefined) {
        throw new Error("[copy] copy failed, `execCommand` not be supported by your browser.");
    }
    var flag = document.execCommand("Copy");
    el.parentElement.removeChild(newEle);
    //3.clear selection
    if ("getSelection" in window) {
        window.getSelection().removeAllRanges();
    } else {
        //IE
        document.selection.empty();
    }
    return flag;    
}
