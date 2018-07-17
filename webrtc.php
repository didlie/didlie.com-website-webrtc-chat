<style>
div.fright{
    max-width:280px;
    text-align:right;
    float:right;
    margin-right:0;
    margin-top:5px;
    background:#ccc;
    border-radius: 2px;
    padding:2px;
    border:2px solid #ddd;
    word-wrap:break-word;
}

div.fleft{
    max-width:280px;
    text-align:left;
    float:left;
    margin-left:0;
    margin-top:5px;
    background:#ddd;
    border-radius:2px;
    padding:2px 2px 2px 2px;
    border: 2px solid #ccc;
    word-wrap:break-word;
}

div.line{
    width:100%;
    float:left;
}
</style>
<script>
var RTCPeerConnection = window.RTCPeerConnection || window.webkitRTCPeerConnection || window.mozRTCPeerConnection;
var stunarray = [
                'stun:stun3.l.google.com:19302' ,
                'stun:stun1.l.google.com:19302' ,
                'stun:stun4.l.google.com:19302' ,
                'stun:stun.l.google.com:19302' ,
                'stun:stun2.l.google.com:19302'
                ];
var stunIndex = 0;
var newPeerConn = () => {
log(stunarray[stunIndex]);
      peerConn = new RTCPeerConnection({'iceServers': [{'urls': [ stunarray[stunIndex] ] }] });
log(peerConn);
      stunIndex++;
      if(stunIndex == stunarray.length) stunIndex = 0;
      connState.innerHTML = peerConn.iceConnectionState;
      peerConn.oniceconnectionstatechange = (e) => {
          connState.innerHTML = (e.currentTarget.iceConnectionState != "failed")? e.currentTarget.iceConnectionState : "";
      }
  }

// userConsole.innerHTML += ('Call create(), or join("some offer")');
/*********connect************/
                                var chatLine = (side,txt) => {
                                    return "<div class=\"line\"><div class=\"f" + side + "\">" + txt + "</div></div>";
                                }
                                var scrollUserConsole = () => {
                                    userConsole.scrollTo(0,userConsole.scrollHeight);
                                }

                                var onGotAnswer = () => {
                                    log("answer is:");
                                    log(peerConn.iceConnectionState);
                                }

                                var connectedComplete = () => {
                                    peerConn.say("We are connected.");
                                    mssgForm.style.display = "block";
                                    setTimeout(function(){
                                            document.getElementById("stopChat").style.display = "block";
                                            document.getElementById("header").style.display = "none";
                                        },1000);
                                }

                                var endChatComplete = () => {
                                    if(peerConn && peerConn.say) peerConn.say("_endChat_");
                                    peerConn = null;
                                    setTimeout(function(){
                                        readyChat();
                                    },1000);
                                }
//not in use
                                var readyChat = () => {
                                    userConsole.innerHTML = "Ready to connect.";
                                    document.getElementById("doChat").style.display = "block";
                                    getIce = currentIceJax;
                                    stopIceChange = false;
                                    getIce();
                                }

                                var onConnect = (x) => {
                                    userConsole.innerHTML = "chat";
                                    stopIceChange = true;
                                    setTimeout(function(){
                                        if(peerConn.iceConnectionState == x)
                                        {
                                            connectedComplete();
                                        }
                                        else {
                                            log(peerConn.iceConnectionState);

                                        }
                                    },1000);
                                };
var createConn = () => {
log("a");
    userConsole.innerHTML = ("Creating a new connection");
    newPeerConn();
    var dataChannel = peerConn.createDataChannel('test');
    dataChannel.onopen = () => {
        {
log("b");
log(dataChannel);
            peerConn.say = (msg) => {
log("c");
                dataChannel.send(msg);
                userConsole.innerHTML += chatLine("left",msg);
                scrollUserConsole();
            };
            onConnect("completed");
        }
    };
                peerConn.msgAction = (x) => {
log("d");
                    userConsole.innerHTML += chatLine("right",x);
                    scrollUserConsole();
                    if(peerkeys && peerkeys[x]) peerkeys[x]();
                }
    dataChannel.onmessage = (e) => {
log("e");
        if(peerConn) peerConn.msgAction(e.data);
    };
    //if true, then the offer is reset
    peerConn.createOffer({iceRestart:false})
      .then((desc) => peerConn.setLocalDescription(desc))
      .catch((err) => console.error(err));
      var candCount = 0;
                                    peerConn.checkCandidate = (x) => {
                            log("h");
                                        if(null == x) return false;
                                                        log(x.candidate);
                                        if(x.candidate.indexOf("srflx") > 1){
                            log("i");
                                            return true;
                                        }
                            log("j");
                                        return false;
                                    };
    var offersenttomirror = false;
    peerConn.onicecandidate = (e) => {
log("k");
        if((e.candidate == null || peerConn.checkCandidate(e.candidate)) && !offersenttomirror){
log("l");
////////////////////////////////////////////////////////////////
            peerConn.sendOffer = sendOffer;
            peerConn.sendOffer();
            offersenttomirror = true;
////////////////////////////////////////////////////////////////
      }
//       if(e.candidate == null && !offersenttomirror) console.log("No srflx candidates found, no offer sent");
//       console.log(peerConn);
log("m");
    };
    //needs error function in case the setRemoteDescrition doesn't match
                                        peerConn.validateAnswerIdentity = (a) => {
                                            var str = JSON.stringify(a);
                                        }
    window.gotAnswer = (answer) => {
log("n");
log("got answer");
        log(answer);
        var z = new RTCSessionDescription(answer);
        log(z);
        peerConn.setRemoteDescription(z,onGotAnswer);
    };

    window.destroyConn = () => {
log("o");
        thisIce = "";
        stopIceChange = true;
        getIce = null;
        userConsole.innerHTML = ("..evaluating..");
        peerConn = null;
    };
  }
  ///////////////////////////////////////////////////////////////////////////

  /***** JOIN *********/
var resetJoinAttempt = () => {
log("p");
    if(peerConn && peerConn.iceConnectionState == "connected") return false;
    peerConn = null;
    userConsole.innerHTML = "Connection failed.";
    getIce = currentIceJax;
    stopIceChange = false;
    getIce();
log("q");
};

  function joinConn(offer) {
log("r");
      newPeerConn();
    userConsole.innerHTML = ("Someone is here.<br>You are being connected.");
    peerConn.ondatachannel = (e) => {
log("s");
      var dataChannel = e.channel;
      dataChannel.onopen = (e) => {
log("t");
          peerConn.say = (msg) => {
log("u");
              dataChannel.send(msg);
              userConsole.innerHTML += chatLine("left",msg);
              scrollUserConsole();
          };
        onConnect("connected");
log("v");
      };
                      peerConn.msgAction = (x) => {
log("w");
                          userConsole.innerHTML += chatLine("right",x);
                          scrollUserConsole();
                          if(peerkeys && peerkeys[x]) peerkeys[x]();
                      }
      dataChannel.onmessage = (e) => {
log("x");
          if(peerConn) peerConn.msgAction(e.data)
      }
    };
//   console.log("this is the right file");
                                      peerConn.checkCandidate = (x) => {
log("y");
                                                        if(null == x) return false;
                                                                      log(x.candidate);
                                                      if(x.candidate.indexOf("srflx") > 1){
log("z");
                                                          return true;
                                                      }
log("aa");
                                                      return false;
                                      };
                                      peerConn.restartJoiner = () => {
log("bb");
                                            endChat();
                                      };
var sent = false;
    peerConn.onicecandidate = (e) => {
log("cc");
log(e);
      if(e.candidate && peerConn.checkCandidate(e.candidate)){
log("dd");
          sendJoiner();
          sent = true;
log("sent == true");
      }else if(e.candidate == null && !sent){
log("ee");
          log("no reflex candidates found");
          sendJoiner();
      }
    };
    var offerDesc = new RTCSessionDescription(offer);
    peerConn.setRemoteDescription(offerDesc);
    //if true, then sound detection is enabled
    peerConn.createAnswer({voiceActivityDetection:false})
      .then((answerDesc) => peerConn.setLocalDescription(answerDesc))
      .catch((err) => console.warn("Couldn't create answer"));
  }
  /////////////////////////////////////////////
  var peerkeys = {
      _endChat_: function() { endChat(); }
  }
  /////////////////////////////////////////////
  window.onunload = function () {
log('jj')
      endChat();
  }
</script>
