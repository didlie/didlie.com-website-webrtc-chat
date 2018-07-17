# didlie.com-website-webrtc-chat
Anonymous P2P
This is a working, resilient javascript/php chat script that works on https://didlie.com

You can test the working model by navegating to didlie.com, inputing and remembering a "location" name and claiming the location.
When you claim the location, just keep the page open and someone can visit you there. When they search the same "location" words, they will be brought to your page. If they click on "Do Chat", they will be connected to you via direct webrtc. The connection is mediated with a php-mirror scheme. There are no Turn servers, and no Node use; just a simple PHP credentials pass between peers.

*note: the process can be instant, or it can take up to 1 minute to complete a stable connection. It takes longer than other apps, but this one is completely annonymous!

Developers interested in this project are welcome to make pull requests.
