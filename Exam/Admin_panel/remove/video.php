<video id="adminVideo" autoplay playsinline></video>
<script>
const socket = new WebSocket('ws://localhost:8080/signaling');
const peer = new RTCPeerConnection();

peer.ontrack = event => {
    const video = document.getElementById('adminVideo');
    video.srcObject = event.streams[0];
};

// Handle incoming signaling messages
socket.onmessage = event => {
    const data = JSON.parse(event.data);
    if (data.offer) {
        peer.setRemoteDescription(new RTCSessionDescription(data.offer));
        peer.createAnswer().then(answer => {
            peer.setLocalDescription(answer);
            socket.send(JSON.stringify({ answer: answer }));
        });
    } else if (data.candidate) {
        peer.addIceCandidate(new RTCIceCandidate(data.candidate));
    }
};
</script>
