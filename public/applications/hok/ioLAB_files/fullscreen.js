
function beginFullscreen(id) {// full-screen available?

    if (
            document.fullscreenEnabled ||
            document.webkitFullscreenEnabled ||
            document.mozFullScreenEnabled ||
            document.msFullscreenEnabled
            ) {

        // image container
        var i = document.getElementById("fullscreen");
        var button = document.getElementById("button_fs");

        // click event handler
        button.onclick = function () {

            // in full-screen?
            if (
                    document.fullscreenElement ||
                    document.webkitFullscreenElement ||
                    document.mozFullScreenElement ||
                    document.msFullscreenElement
                    ) {

                // exit full-screen
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                if (arguments.length>0)
                { var ifr=document.getElementById(id); ifr.src=ifr.src; }
            }
            else {

                // go full-screen
                if (i.requestFullscreen) {
                    this.requestFullscreen();
                } else if (i.webkitRequestFullscreen) {
                    i.webkitRequestFullscreen();
                } else if (i.mozRequestFullScreen) {
                    i.mozRequestFullScreen();
                } else if (i.msRequestFullscreen) {
                    i.msRequestFullscreen();
                }
                if (arguments.length>0)
                { var ifr=document.getElementById(id); ifr.src=ifr.src; }
            }

        }

    }

}