const selectColor = (color) => {
    $(`#parent_div_of_color`).find(".prod-options-slide").each(function() {
        $(this).removeClass('prod-options-slide-first');
    });
    $(`#${color}`).addClass('prod-options-slide-first');
};
