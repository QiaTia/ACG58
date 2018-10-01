/**
 * http://www.flvcd.com/
 *  .--,       .--,
 * ( (  \.---./  ) )
 *  '.__/o   o\__.'
 *     {=  ^  =}
 *      >  -  <
 *     /       \
 *    //       \\
 *   //|   .   |\\
 *   "'\       /'"_.-~^`'-.
 *      \  _  /--'         `
 *    ___)( )(___
 *   (((__) (__)))    高山仰止,景行行止.虽不能至,心向往之。
 */
var banner = document.getElementsByClassName('banner'),
	imgBanner = document.getElementsByClassName('img-banner')['0'];
i = 0,
	j = 0,
	bannerWidth = 0,
	bannerLength = banner.length;

imgBanner.innerHTML = imgBanner.innerHTML + imgBanner.innerHTML;
for (var index = 0; index < bannerLength; index++) {
	bannerWidth = bannerWidth + banner[index].offsetWidth;
	//console.log(document.body.offsetWidth);
}
var startPoint = 0,
	currPoint = 0,
	slideshow = document.querySelector('.img-banner');
//手指按下
slideshow.addEventListener("touchstart", function(e) {
	startPoint = e.changedTouches[0].pageX;
});
slideshow.addEventListener("touchmove", function(e) {
	currPoint = e.changedTouches[0].pageX;
});
slideshow.addEventListener("touchend", function(e) {
	if ((currPoint - startPoint) >= 100) moveLast();
	else if ((currPoint - startPoint) <= 100) moveNext();
	else return 0;
})

function moveNext() {
	if (i >= bannerLength) {
		j = 0;
		i = 0;
	}
	j += banner[i].offsetWidth;
	i++;
	imgBanner.style.webkitTransform = "translate3d(-" + j + "px, 0px, 0px)";
	imgBanner.style.width = '5000px';
}

function moveLast() {
	i--;
	if (i < 0) {
		j = bannerWidth;
		i = bannerLength;
	}
	j -= banner[i].offsetWidth;
	imgBanner.style.webkitTransform = "translate3d(-" + j + "px, 0px, 0px)";
	imgBanner.style.width = bannerWidth * 2 + 'px';
}
setInterval(() => {
	moveNext();
}, 4000);