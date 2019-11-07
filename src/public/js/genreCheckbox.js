$(function () {
    const checkall = $('input[name="checkall[]"]');

    // console.log(checkall);
    for (let val of checkall) {
        console.log(val.className);
        $('.' + val.className).on('change', function () {
            $('.genre_' + val.className.slice(-1)).prop('checked', this.checked);
        });
    }
});
