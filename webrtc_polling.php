<script>
//////////////////////////////////////////////////////////////////////////
//create file display loop
///////////////////////polling only functions

//when answering an offer, the answer is made when the user sees the offer change.

//var currentIce="";//only evaluate on a change in mirror


    var rotateTicker = () => {
        var out = "";
        var chr = "&%$#@*";
        var end = "!?.~";
        var x = Math.floor((Math.random() * 5));
        var y;
        while(x >= 0){
            y = Math.floor((Math.random() * 5));
            out += chr[y];
            x--;
        }
        x = Math.floor((Math.random() * 3));
        return out + end[x];
    }

    var currentIceJax = function(){
        thisIce = "";
        var chatJax = chatAjax;
        if(!stopIceChange) chatJax(getIceCallback);
    }

    var getIceCallback = (x) => {
        mirror.value = x.trim();////////////////////////////////////set ice for testing
        iceChange();
        setTimeout(getIce,1000);
    }
    ///now called by onchange callback
    var oldIce="";//only evaluate on a change in mirror
    var stopIceChange = false;

    var iceChange = () => {
log(1);
//animate
                userConsole.innerHTML = rotateTicker();
        ///noting in mirror, do nothing
                if(mirror.value.length < 10){
                    oldIce = "";
                    return false;
                }
        var ice = mirror.value.trim();
        var obj = JSON.parse(ice);
        //is this the answer?
                if(!stopIceChange
                    && peerConn
                    && peerConn.localDescription.type == "offer"
                    && obj.type == "answer"
                    && peerConn.iceConnectionState != "completed"){
log(2);
                    gotAnswer(obj);
                    stopIceChange = true;
                    return false;
                }
        //is this a fresh offer, or a renewed offer from a failed attempt?
                if(!stopIceChange
                    && obj.type == "offer"
                    && (peerConn == null
                        || (thisPeerType == "join"
                                && peerConn.iceConnectionState != "connected")))
                {
log(3);
                    if(oldIce != ice)
                    {
log(4);
                            stopIceChange = true;
                            peerConn = null;
                            thisPeerType = "join";
                            document.getElementById("doChat").style.display = "none";
                            joinConn(obj);
                            return false;
                    }
                }
log(5);
            oldIce = ice;
        };//end of poll

//console.log(mirror);
//mirror.addEventListener("change",iceChange);
var getIce = currentIceJax;//redefine getIce to currentIceJax, when the process is restarted
</script>
