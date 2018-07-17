<script>
/*********** didlie handlers *********/
var mirrorObj = null;
//var mirror = document.getElementById("currentIce");//now defined as var object mirror = { value: ""; }
var chatStarted = false;
//////////////////////////////////////////////////////////////////////////
//all call begin with this:
var thisPeerType = "";
var chat = () => {
log("A");
    peerConn = null;
//    chatStarted = true;
    stopIceChange = false;
    if(!chatJax){
        chatJax = chatAjax;
    }
    if(!getIce){
        getIce = currentIceJax;
    }
    getIce();

    if(!createChat){
        createChat = chat2;
    }
    //console.log("this is the right file too");
    //document.getElementById("stopChat").style.display = "block";
    createChat();
}

    var chat2 = (option = "") => {
log("B");
        document.getElementById("doChat").style.display = "none";
        document.getElementById("stopChat").style.display = "none";
        mirrorObj = null;
        var temp = mirror.value;
        if(temp.length > 10) mirrorObj = JSON.parse(temp);//for all conditions
        {
log("G");
            createConn();//calls sendOffer
            peerConn.onicegatheringstatechange = function(){
log("H");
log(peerConn.iceGatheringState);
                };
            setTimeout(function(){
log("I");
                if(chatJax){
log("J");
                    mirrorObj = null;
                    var temp = mirror.value;
                    if(temp.length > 10) mirrorObj = JSON.parse(temp);
                    if(!mirrorObj || mirrorObj.type != "answer"){
log("K");
                        //this loops to create an answer for its own offer
                        thisPeerType = "offer";
                        createChat();
                    }else if(peerConn.iceConnectionState != "completed" && peerConn.remoteDescription != null){
log("Ka");
                        mirror.value = "";
                        chat();
                    }
                }
            },6000);
        }
log("L");
    }
var createChat = chat2;
//////////////////////////////////////////
//functions used in the peer creation process for createConn and join
//////////////////////////////////////////
var sendJoiner = () => {
log("M");
    document.getElementById("doChat").style.display = "none";
    document.getElementById("stopChat").style.display = "none";
    var chatJax = chatAjax;
    chatJax(sendJoinerCallback,JSON.stringify(peerConn.localDescription));
}
        var sendJoinerCallback = (x) => {
log("N");
            mirror.value = x.trim();
            stopIceChange = false;
        }
///////////////////////////////////////////////
var sendOffer = () => {
log("O");
    chatJax(sendOfferCallback,JSON.stringify(peerConn.localDescription));
};//define internal function
        var sendOfferCallback = (x) => {
log("P");

                stopIceChange = false;
                mirror.value = x.trim();
        };
/******** creator does polling to complete connection *********/

//////////////////////////////
var endChat = () =>
{
log("Q");
    thisPeerType = "";
    stopPolling = true;
    chatJax = null;
    getIce = null;
    createChat = null;
    mirror.value = "";
    thisIce = "";
    mssgForm.style.display = "none";
    userConsole.innerHTML = "Disconnected.<br>Clearing cache...";
    document.getElementById("header").style.display = "block";
    document.getElementById("doChat").style.display = "none";
    document.getElementById("stopChat").style.display = "none";
    endChatComplete();
}

var completeConnCallback = () => {
log("R");
    getIce = null;
    document.getElementById("messageForm").style.display = "block";
}
/////////////complete connection call back function////////////
</script>
