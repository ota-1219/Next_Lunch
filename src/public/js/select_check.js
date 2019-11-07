$(function () {
    const sortCondition = $('input[type="hidden"][name="sort"]').val();
    // console.log(sortCondition);
    const sortSelect = $('.sortSelect');
    for (let i = 0; i < sortSelect.length; i++) {
        if (sortSelect[i].value == sortCondition) {
            sortSelect[i].selected = true;
        }
        // console.log(sortSelect[i].value);
    }
});
