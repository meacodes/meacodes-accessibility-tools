function dragElement(e) {
    var t = 0,
        n = 0,
        o = 0,
        d = 0;

    function l(e) {
        (e = e || window.event).preventDefault(), (o = e.clientX), (d = e.clientY), (document.onmouseup = c), (document.onmousemove = u);
    }

    function u(l) {
        (l = l || window.event).preventDefault(),
            "rtl" === document.body.style.direction ? ((t = o + l.clientX), (n = d - l.clientY), (e.style.right = document.documentElement.clientWidth - (e.offsetLeft + e.offsetWidth) + "px")) : ((t = o - l.clientX), (n = d - l.clientY)),
            (o = l.clientX),
            (d = l.clientY),
            (e.style.top = e.offsetTop - n + "px"),
            (e.style.left = e.offsetLeft - t + "px");
    }

    function c() {
        (document.onmouseup = null), (document.onmousemove = null);
    }
    document.getElementById(e.id + "Header") ? (document.getElementById(e.id + "Header").onmousedown = l) : (e.onmousedown = l);
}
dragElement(document.getElementById("Dragit_meac"));