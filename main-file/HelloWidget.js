HelloWidget = function(opts) { 
  //console.log("Hello widget running, video id=" + opts.video.kapsule_id); 

  this.on_timeupdate = function(time) {
    if (opts.enabled) {
      console.log('{"time": "' + time + '"}');
    }
  };
  
};