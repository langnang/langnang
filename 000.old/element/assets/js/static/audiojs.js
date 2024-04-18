require(["audiojs"], function (audiojs) {
  console.log(audiojs);
  window.audiojs.events.ready(function () {
    var as = audiojs.createAll();
  });
});
