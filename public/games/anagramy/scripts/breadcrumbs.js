/*http://www.w3schools.com/Html/html5_webstorage.asp
 * http://stackoverflow.com/questions/2010892/storing-objects-in-html5-localstorage
 */


$(document).ready(function(){

    if (typeof(Storage) != "undefined") {
        var linksCollection = JSON.parse(localStorage.getItem("breadcrumbs"));
        var newLink = {nazov: $(document).find("title").text(), link: window.location.href.split("#")[0]};

        if (linksCollection == null){
            var linksCollection = new Array();
            linksCollection.push(newLink);
        }

        else if (linksCollection[linksCollection.length - 1].link != newLink.link){
            if (linksCollection.length == 5) {
                linksCollection.shift();
            }

            linksCollection.push(newLink);
        }
        localStorage.setItem("breadcrumbs", JSON.stringify(linksCollection));
    }
    createBreadcrumbs(linksCollection);
});

function createBreadcrumbs(links){
    var tags = "";
    for(var i= 0; i<links.length; i++){
        tags = tags + "<li><a href= " + links[i].link + ">" + links[i].nazov + "</a></li>";
    }
    $(".breadcrumb").html(tags);
    var lastLi = $(".breadcrumb").find("li").last();
    lastLi.addClass("active");
    var lastLiText = $(".breadcrumb").find("a").last().text();
    lastLi.html(lastLiText);
}


