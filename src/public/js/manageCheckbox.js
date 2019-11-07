var $script = $("#script");
var result = JSON.parse($script.attr("data-param"));

//受理ボタン
$(function() {
    const acceptCheck = $('a[name="acceptCheck[' + result + ']"]');
    const check = $('input[name="check[' + result + ']"]');
    console.log(acceptCheck);
    console.log(check);

    acceptCheck[Symbol.iterator] = function() {
        let index = 0;
        return {
            next() {
                if (acceptCheck.length <= index) {
                    return { done: true };
                } else {
                    return { value: acceptCheck[index++] };
                }
            }
        };
    };

    for (let val of acceptCheck) {
        console.log(val);
        $(check).click(function() {
            if (val.checked) {
                $("a[name='acceptCheck[" + result + "]']").replaceWith(
                    "<a id='acceptCheck' href='deleteAccept/" +
                        result +
                        "' class='btn btn-sm btn-success px-2 text-light'><i class='fas fa-user-check'></i> <b>受理</b></a>"
                );
            } else {
                $("#acceptCheck").replaceWith(
                    "<a id='acceptCheck[" +
                        result +
                        "]' class='btn btn-sm alert-secondary px-2 text-light disabled' tabindex='-1' aria-disabled='true'><i class='fas fa-user-check'></i> <b>受理</b></a>"
                );
            }
        });
    }
});

//棄却ボタン
$(function() {
    const rejectCheck = $('a[name="rejectCheck[' + result + ']"]');
    const check = $('input[name="check[' + result + ']"]');
    console.log(rejectCheck);

    rejectCheck[Symbol.iterator] = function() {
        let index = 0;
        return {
            next() {
                if (rejectCheck.length <= index) {
                    return { done: true };
                } else {
                    return { value: rejectCheck[index++] };
                }
            }
        };
    };

    for (let val of rejectCheck) {
        $(check).click(function() {
            if (val.checked) {
                $("a[name='rejectCheck[" + result + "]']").replaceWith(
                    "<a id='rejectCheck' href='deleteReject/" +
                        result +
                        "' class='btn btn-sm btn-danger px-2 text-light'><i class='fas fa-user-check'></i> <b>棄却</b></a>"
                );
            } else {
                $("#rejectCheck").replaceWith(
                    "<a id='rejectCheck[" +
                        result +
                        "]' class='btn btn-sm alert-secondary px-2 text-light disabled' tabindex='-1' aria-disabled='true'><i class='fas fa-user-check'></i> <b>棄却</b></a>"
                );
            }
        });
    }
});
