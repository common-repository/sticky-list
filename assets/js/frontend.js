(function ($) {
	var settings = $(".ud-stickylist-panel").attr("data-settings");
	settings = JSON.parse(settings);

	var position = settings.position || "left",
		containerWidth = settings.width || 300,
		animSpeed = 500,
		easing = "";

	var opener = $(".ud-sticky-list-opener, .ud-sticky-list-opener-menu"),
		content = $(".ud-sticky-list-content"),
		overlay = $(".ud-sticky-list-overlay"),
		openIcon = opener.find(".ud-sticky-list-pi-o"),
		hideIcon = opener.find(".ud-sticky-list-pi-h");

	overlay.on("click", function (e) {
		e.preventDefault();
		$(this).fadeOut(animSpeed);
		opener.removeClass("ud-sticky-list-opener-open");
		openIcon.show();
		hideIcon.hide();
		var animationO = {};
		animationO[position] = -containerWidth + "px";

		content.animate(animationO, animSpeed, easing);

		animationO[position] = "0px";
		opener.animate(animationO, animSpeed, easing);
	});

	opener.on("click", function (e) {
		e.preventDefault();
		var animationO = {};
		if ($(this).hasClass("ud-sticky-list-opener-open")) {
			$(".ud-sticky-list-overlay").fadeOut(animSpeed);
			$(this).removeClass("ud-sticky-list-opener-open");
			openIcon.show();
			hideIcon.hide();
			animationO[position] = "0px";
			$(this).animate(animationO, animSpeed, easing);
			animationO[position] = -containerWidth + "px";
			content.animate(animationO, animSpeed, easing);
		} else {
			$(".ud-sticky-list-overlay").fadeIn(animSpeed);
			$(this).addClass("ud-sticky-list-opener-open");
			openIcon.hide();
			hideIcon.show();
			animationO[position] = containerWidth + "px";
			$(this).animate(animationO, animSpeed, easing);
			animationO[position] = "0px";
			content.animate(animationO, animSpeed, easing);
		}
	});
})(jQuery);
