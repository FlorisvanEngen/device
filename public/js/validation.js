function onlyNumbers(e) {
    if (e.which != 8 && e.which != 35 && e.which != 36 && e.which != 37 &&
        e.which != 39 && e.which != 46 && (e.which < 48 || e.which > 57) && (e.which < 96 || e.which > 105)) {
        e.preventDefault();
    }
}
