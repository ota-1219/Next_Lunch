(function($) {
    // 読み込んだら開始
    $(function() {
        // アコーディオン
        $(".accordion").each(function() {
            var accordion = $(this);
            $(this)
                .find(".switch")
                .click(function() {
                    var targetContentWrap = $(this).next(".contentWrap");
                    if (targetContentWrap.css("display") === "none") {
                        accordion.find(".contentWrap").slideUp();
                        accordion.find(".switch.open").removeClass("open");
                    }
                    targetContentWrap.slideToggle();
                    $(this).toggleClass("open");
                });
        });
    });
})(jQuery);
