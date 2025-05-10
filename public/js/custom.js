$(function(){
    $('a[target=""]').on('click', function (e){
        e.preventDefault();
        window.open($(this).attr('href'), "_blank")
    })
})

function decodeHtmlEntity(str) {
    return str.replace(/&#(\d+);/g, function(match, dec) {
        return String.fromCharCode(dec);
    });
}
