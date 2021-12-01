function AjaxLengthTheme(cat,id) {
    $.ajax(
        {
            url: "",
            type: "GET",
            data: {
                'cat': cat,
            },
            success: function (data) {
                console.log(data.counter)
                let paragraphe = $("#lengthArticle"+id);
                if (data.counter === 0){
                    length = data.counter +" classe";
                }
                if (data.counter === 1){
                    length = data.counter + " classe";
                }
                if (data.counter > 1)
                {
                    length = data.counter +" classes";
                }
                paragraphe.append(length);
            }
        }
    )
}