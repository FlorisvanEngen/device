
var dragging, draggedOver;

function dragStart(event) {
    dragging = event.target.id;
}

function allowDrop(event) {
    event.preventDefault();
    draggedOver = $(event.target).parent("tr").attr("id");
}

function drop(event) {
    event.preventDefault();

    console.log(devices);

    //calculate the order
    console.log('Dragged=' + dragging);
    console.log('draggedOver=' + draggedOver);
}
