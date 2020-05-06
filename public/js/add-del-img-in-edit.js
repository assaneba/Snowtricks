jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('div.images');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('image-input').each(function() {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $('#trick_images').find(':input').length);

    $addImageButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
});

var $collectionHolder;

// setup an "add a image" link
var $addImageButton = $('<button type="button" class="btn btn-sm btn-primary btn-add" data-rel="#images">Uploader une image</button>');
var $newLinkLi = $('<p></p>').append($addImageButton);

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<p></p>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}
