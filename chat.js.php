<script>
var log = (x) => {
    console.log(x);
};
</script>
<center>
    <div id="doChat" style="display:block;"><button id="doChatButton" onclick="chat()" disabled>Wait!</button></div>
    <div id="stopChat" style="display:none;"><button id="stopChatButton" onclick="endChat()">Stop Chat</button></div>
	<div id='chatWrap' style="display:block">
        <div>----------------------</div>
            <div id="iceConnectionState"></div>
            <div id="status" style="height:200px; overflow:auto; word-wrap:break-word">
                <br>>---------------------<<br>
                cleaning history.<br>
                please wait.<br>
                >---------------------<
            </div>
            <div id="messageForm" style="display:none;"><input type="text" id="msgTxt" onkeydown="submitMsgTxt(event)"><br><button onclick="doSay()">Do</button></div>
            <script>
                var submitMsgTxt = () => {
                    if(event.keyCode == 13) doSay();
                }
            </script>
            <div id="txtAreaContainer" style="display:none;" >
                <textarea id="currentIce" readonly></textarea>
                <script>
                //<textarea id="currentIce" readonly></textarea>
                var mirror = document.getElementById("currentIce");
                //mirror.addEventListener("change",iceChange());//in the polling file
                </script>
            </div>
            <div id="dataDump" style="display:block">
            </div>
    </div>
</center>
<script>
var mssgForm = document.getElementById("messageForm");
//var said = "";
var doSay = () => {
    var source = document.getElementById("msgTxt");
    var val = source.value;
    val = val.trim();
    //if(val != said && val != ""){
        said = val;
        peerConn.say(val);
        source.value = "";
        source.focus();
    //}
}
</script>
<script>
var userConsole = document.getElementById("status");
var connState = document.getElementById("iceConnectionState");
//
var connected = false;
var peerConn = null;
var peerConnType = "";
var thisIce = "";
</script>
<?php
  //seperated function for better control,
  //ever instance of use must include this function first.
require_once("webrtc.php");
//uses the functions:
        //sendOffer()
        //sendJoiner();
//has the functions:
        //createConn();
                //gotAnswer();
                //say();
                //destroyConn();
        //joinConn();
                //say();
require_once("webrtc_didlie.php");
require_once("webrtc_chatjax.php");
require_once("webrtc_polling.php");
//updates the currentIce).value every 3 seconds, and uses gotAnswer(), if peerConnType = offer && return value is answer
?>
<script>
window.onload = function(){
setTimeout(function(){
    userConsole.innerHTML = "Ready to connect.";
    document.getElementById("doChatButton").removeAttribute("disabled");
    if(mirror.value == "") document.getElementById("doChatButton").innerHTML= "Do Chat";
    getIce();
},2000);
};
</script>
<?php
