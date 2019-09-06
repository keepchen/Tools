function copy(el) {
    if (typeof el !== "object" || typeof el.getAttribute !== "function") {
        throw Error("[copy] copy failed, `el` not a element node.");
    }
    var attr = el.getAttribute("data-copy");
    if (attr === null) {
        console.log("[copy] copy failed, `data-copy` attribute not exist.");
        return false;
    }
    //1.select
    if (el.createTextRange) {
        //IE
        var selRange = el.createTextRange();
        selRange.collapse(true);
        selRange.moveStart("character", 0);
        selRange.moveEnd("character", attr.length);
        selRange.select();
    } else if (el.setSelectionRange) {
        el.setSelectionRange(0, attr.length);
    }
    el.focus();
    //2.execute copy command
    if (document.execCommand == undefined) {
        throw Error("[copy] copy failed, `execCommand` not be supported by your browser.");
    }
    var flag = document.execCommand("copy");
    //3.clear selection
    if ("getSelection" in window) {
        window.getSelection().removeAllRanges();
    } else {
        //IE
        document.selection.empty();
    }
    return flag;    
}
