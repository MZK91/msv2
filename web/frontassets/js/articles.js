
var counter = $("#share-counter").attr("data-counter");
var url = $("#share-url").attr("data-url");

$.ajax({
    type: "GET",
    url: counter,
    data: 'url='+ url,
    dataType: "xml",
    success: function (xml) {
        $(xml).find('shares').each(function () {
            alert($(this).find('twitter').text());
            $('#twitter-count').text( 'The URL has ' + $(this).find('twitter').text() + ' shares count on Twitter');
            $('#facebook-count').text( 'The URL has ' + $(this).find('facebook').text() + ' shares count on Facebook');
            $('#pinterest-count').text( 'The URL has ' + $(this).find('pinterest').text() + ' shares count on Pinterest');
            $('#google-count').text( 'The URL has ' + $(this).find('google').text() + ' shares count on Google +');
            $('#countUp').text($(this).find('total').text());
        });

    },
    error: function () {
        alert("The XML File could not be processed correctly.");
    }
});