(function () {
    "use strict";
    var $form = document.querySelector(".form-actions");
    if ($form) {
        (function () {
            var collectionHolder = document.querySelector(".doctrine-collection");
            console.log("ok");
            var lis = collectionHolder.querySelectorAll("li").length;
            var $addTagLink = document.createElement("A");
            var $removeTagLink = "<a href='javascript://' class='remove-item'>Remove item</a>";
            [].forEach.call(collectionHolder.querySelectorAll("li"), function (el, i) {
                console.log(el);
                el.innerHTML += $removeTagLink;
                el.setAttribute("data-index", i);
                el.querySelector("a").setAttribute("data-index", i);
            });
            var tagPrototype = collectionHolder.getAttribute("data-prototype");
            $addTagLink.href = "javascript://";
            $addTagLink.class = "add_tag_link";
            var text = document.createTextNode("Add item")
            $addTagLink.appendChild(text);
            var $newTagLi = document.createElement("div");
            $newTagLi.appendChild($addTagLink);
            collectionHolder.parentNode.insertBefore($newTagLi, collectionHolder);
            // remove items
            collectionHolder.addEventListener("click", function (e) {
                if (e.target.className == "remove-item") {
                    console.log('remove-item', e.target);
                    var selector = "li[data-index='" + e.target.getAttribute("data-index") + "']";
                    //debugger;
                    var elementToRemove = e.currentTarget.querySelector(selector);
                    e.currentTarget.removeChild(elementToRemove)
                }
            });
            // add items
            $addTagLink.addEventListener("click", function (e) {
                var li = document.createElement("li");
                li.className = "item";
                li.innerHTML = tagPrototype.replace(/__name__/g, ++lis);
                li.innerHTML += $removeTagLink;
                li.setAttribute("data-index",lis);
                li.querySelector("a").setAttribute("data-index",lis);
                //tag.querySelector('label').innerHTML = " ";
                //tag.querySelector("input").required = false;
                collectionHolder.insertBefore(li, collectionHolder.lastChild);
            });
        }())
    }
}());