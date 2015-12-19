$(function() {
    $(".test_result_table .item").click(function(e) {
        if (e.target.nodeName === "A") {
            return;
        }

        var testNo = $(this).find(".no").text();
        var testSource = $(this).attr("test-source");

        $("#js_test_source_test_no").text(testNo);
        $("#js_test_source_content").text(testSource);
        $("#js_test_source").slideDown(100);
    });

    $("#js_test_source_close").click(function(e) {
        $("#js_test_source").slideUp(100);
    });
});
